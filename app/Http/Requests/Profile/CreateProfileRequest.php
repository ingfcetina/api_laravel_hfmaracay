<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class CreateProfileRequest extends FormRequest
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
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'email' => 'string|email:rfc,dns|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'string|required',
            'birth_date' => 'string|required',
            'city' => 'string|required',
            'state' => 'string|required',
            'country' => 'string|required',
            'area' => 'string|required',
            'level' => 'string|required',
            'linkedin' => 'string|nullable',
            'facebook' => 'string|nullable',
            'instagram' => 'string|nullable',
            'twitter' => 'string|nullable'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nombre de usuario requerido',
            'name.unique' => 'Nombre de usuario ya se encuentra registrado',
            'first_name.required' => 'Nombre requerido',
            'last_name.required' => 'Apellido requerido',
            'email.required' => 'Email requerido',
            'email.email' => 'Email inválido',
            'email.unique' => 'Email ya se encuentra registrado',
            'password.required' => 'Contraseña requerida',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.confirmed' => 'Contraseñas no coinciden',
            'phone.required' => 'Teléfono requerido',
            'birth_date.required' => 'Fecha de nacimiento requerida',
            'city.required' => 'Ciudad requerida',
            'state.required' => 'Estado requerido',
            'country.required' => 'País requerido',
            'area.required' => 'Área requerida',
            'level.required' => 'Nivel requerido'
        ];
    }
}
