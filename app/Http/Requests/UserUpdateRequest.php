<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('user', 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required|email|min:8|max:35|unique1:users',/*DomainValid*/
            'last_name' => 'required|alfa_space|min:3|max:50',
            'name'      => 'required|alfa_space|min:3|max:50',
            'num_id'    => 'required|string|min:6|max:12|unique1:users',/*digits_between:6,9|exr_ced*/
            'password'  => 'nullable|string|min:6|max:20|confirmed',
            'sex'       => 'required|numeric',
            'roles'     => 'required|array|max:2',
            'user'      => 'required|alfa_space|min:3|max:25|unique1:users',
            'phone'     => 'nullable|numeric',
        ];
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
