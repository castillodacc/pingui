<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => 'required|min:3|max:10|unique1:users',
            'phone' => 'nullable',
            'web' => 'nullable|string|min:3|max:40',
            'email' => 'required|email|DomainValid|unique1:users,email',
            'last_name' => 'required|alfa_space|min:3|max:25',
            'name' => 'required|alfa_space|min:3|max:25',
            'birthdate' => 'nullable',
            'num_id' => 'required|numeric|exr_ced|unique1:users,num_id'
        ];
    }

    /**
     * Translate name of atributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'user' => 'usuario',
            'phone' => 'teléfono',
            'club_id' => 'club',
            'email' => 'correo',
            'birthdate' => 'fecha de nacimiento',
            'last_name' => 'apellido',
            'name' => 'nombre',
            'num_id' => 'cédula'
        ];
    }
}
