<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            'name' => 'string|required|unique:users',
            'email' => 'string|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nombre de usuario requerido',
            'name.unique' => 'Nombre de usuario ya se encuentra registrado',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email ya se encuentra registrado',
            'password.required' => 'Contraseña requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Contraseñas no coinciden',
        ];
    }
}
