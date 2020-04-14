<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LogInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "email" => "required|email",
            "password" => "required|min:8"
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email requerido',
            'email.email' => 'Email inválido',
            'password.required' => 'Contraseña requerida',
            'password.min' => 'Contraseña inválida'
        ];
    }
}
