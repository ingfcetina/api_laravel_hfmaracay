<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'author' => $this->user->name,
            'title' => $this->title,
            'content' => $this->content,
            'image' => env('STORAGE_PATH')."articles/$this->image",
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'approval_at' => $this->approval_at
        ];
    }
}
