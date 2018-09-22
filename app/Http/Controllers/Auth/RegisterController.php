<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Permisologia\Role;
use App\Models\Club;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/perfil/3';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $clubs = Club::get(['id', 'name', 'population', 'province']);
        $roles = Role::whereIn('id', [2,3])->get(['id', 'name']);
        return view('auth.register', compact('clubs', 'roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email'     => 'required|email|min:8|max:35|unique:users|DomainValid',
            'last_name' => 'required|alfa_space|min:3|max:50',
            'user'      => 'required|alfa_space|min:3|max:20|unique:users',
            'name'      => 'required|alfa_space|min:3|max:50',
            'num_id'    => 'required|numeric|digits_between:6,8|exr_ced|unique:users',
            'club_id'   => 'nullable|numeric',
            'phone'     => 'nullable|numeric',
            'rol'     => 'nullable|numeric',
            'web'     => 'nullable|string',
            'password'  => 'required|string|min:6|max:20|confirmed',
        ],[],[
            'email'     => 'correo',
            'last_name' => 'apellido',
            'user'      => 'nombre de usuario',
            'name'      => 'nombre',
            'num_id'    => 'DNI',
            'rol'    => 'perfil',
            'phone'    => 'telefono',
            'club_id'    => 'club',
            'password'  => 'contraseña',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $data['confirm'] = str_replace('/', '', Hash::make(Hash::make(env('APP_KEY')) . $data['password'] . '-rs'));
        $user = User::create($data);
        \Mail::to($user->email)->send(new \App\Mail\Welcome($user));
        $user->roles()->attach($data['rol']);
        $user->assignPermissionsOneUser($data['rol']);
        return $user;
    }
}
