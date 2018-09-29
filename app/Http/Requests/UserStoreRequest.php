<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('user', 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|min:8|max:35|unique:users',/*DomainValid*/
            'user'      => 'required|alfa_space|min:3|max:25|unique:users',
            'last_name' => 'required|alfa_space|min:3|max:50',
            'name'      => 'required|alfa_space|min:3|max:50',
            'num_id'    => 'required|string|min:6|max:12|unique:users',/*digits_between:6,9|exr_ced*/
            'password'  => 'required|string|min:6|max:20|confirmed',
            'phone'     => 'nullable|numeric',
            'name'      => 'required|alfa_space|min:3|max:50',
            'sex'       => 'required|numeric',
        ];
    }

    /**
     * mensajes personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return ['email.required' => 'El campo :attribute es requerido.'];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'email'     => 'correo',
            'last_name' => 'apellido',
            'user'      => 'nombre de usuario',
            'name'      => 'nombre',
            'num_id'    => 'DNI',
            'rol'    => 'perfil',
            'phone'    => 'telefono',
            'club_id'    => 'club',
            'password'  => 'contraseña',
            'sex'       => 'sexo',
        ];
    }
}
