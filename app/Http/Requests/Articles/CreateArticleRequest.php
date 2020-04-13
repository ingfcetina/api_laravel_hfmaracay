<?php

namespace App\Http\Requests\Articles;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user())
            return true;

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:10',
            'content' => 'required|min:100',
            'image' => 'required|mimes:jpeg,png',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Título requerido',
            'title.min' => 'Título debe ser de al menos 10 caracteres',
            'content.required' => 'El contenido es obligatorio',
            'content.min' => 'El contenido debe ser de al menos 100 caracteres',
            'image.required' => 'Imagen requerida',
            'image.mimes' => 'Formato inválido'
        ];
    }
}
