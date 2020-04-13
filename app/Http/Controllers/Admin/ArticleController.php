<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Articles\CreateArticleRequest;
use App\Http\Requests\Articles\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Queries\ArticleFilter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request, ArticleFilter $filters)
    {
        $articles = Article::query()
            ->filterBy($filters, $request->only(['search', 'from', 'to']))
            ->orderBy('id', 'DESC')
            ->paginate();
        $articles->appends($filters->valid());

        return ArticleResource::collection($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateArticleRequest $request
     * @return JsonResponse
     */
    public function store(CreateArticleRequest $request)
    {
        $file = $request->file('image');
        $extension = $file->extension();
        $name = $file->getClientOriginalName();
        $fileName = pathinfo($name, PATHINFO_FILENAME);
        $i = 1;
        while (Storage::disk('public')->exists("articles/$name")) {
            $name = "$fileName$i.$extension";
            $i++;
        }
        Storage::disk('public')->putFileAs('articles', $file, $name);

        Article::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $name,
            'approval_at' => Carbon::now()
        ]);
        return response()->json(['msg' => 'Artículo creado exitosamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return ArticleResource
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateArticleRequest $request
     * @param Article $article
     * @return JsonResponse
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete("articles/$article->image");
            $file = $request->file('image');
            $extension = $file->extension();
            $name = $file->getClientOriginalName();
            $fileName = pathinfo($name, PATHINFO_FILENAME);
            $i = 1;
            while (Storage::disk('public')->exists("articles/$name")) {
                $name = "$fileName$i.$extension";
                $i++;
            }
            Storage::disk('public')->putFileAs('articles', $file, $name);
            $request->image = $name;
        } else {
            $request->image = $article->image;
        }
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image
        ]);

        return response()->json(['msg' => 'Artículo actualizado con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     * @return JsonResponse
     */
    public function destroy(Int $id)
    {
        $article = Article::withTrashed()
            ->where('id', $id);
        try {
            Storage::disk('public')->delete("articles/$article->image");
            $article->forceDelete();
            return response()->json(['msg' => 'Artículo eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['msg' => "Ha ocurrido un error"]);
        }
    }

    /**
     * Delete the specified resource
     * @param Article $article
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Article $article)
    {
        $article->delete();
        return response()->json(['msg' => 'Artículo eliminado con éxito']);
    }

    /**
     * Restore the specified resource
     * @param Int $id
     * @return JsonResponse
     */
    public function restore(Int $id)
    {
        Article::withTrashed()
            ->where('id', $id)
            ->restore();
        return response()->json(['msg' => 'Artículo restaurado con éxito']);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function trashed()
    {
        return ArticleResource::collection(Article::onlyTrashed()->paginate());
    }

    /**
     * @param Article $article
     * @return JsonResponse
     */
    public function approve(Article $article)
    {
        $article->update(['approval_at' => Carbon::now()]);
        return response()->json(['msg' => 'Artículo aprobado con éxito']);
    }

}
