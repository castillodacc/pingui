<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Club;
use Illuminate\Http\Request;
use App\Models\Permisologia\Role;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

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
        $roles = Role::whereIn('id', [2, 3])->get(['id', 'name']);
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
            'email'     => 'required|email|min:8|max:35|unique:users',/*DomainValid*/
            'last_name' => 'required|string|min:3|max:50',
            'user'      => 'required|string|min:3|max:20|unique:users',
            'name'      => 'required|string|min:3|max:50',
            'num_id'    => 'required|string|min:6|max:12|exr_ced|unique:users',/*|numeric|digits_between:6,8*/
            'club_id'   => 'nullable|numeric',
            'phone'     => 'nullable|numeric',
            'rol'     => 'required|numeric',
            'sex'     => 'required|numeric',
            'web'     => 'nullable|string',
            'password'  => 'required|string|min:6|max:20|confirmed',
        ], [], [
            'email'     => 'correo',
            'last_name' => 'apellido',
            'user'      => 'nombre de usuario',
            'name'      => 'nombre',
            'num_id'    => 'DNI',
            'rol'    => 'perfil',
            'sex'    => 'sexo',
            'phone'    => 'telefono',
            'club_id'    => 'club',
            'password'  => 'contraseña',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $data['user'] = $data['name'];
        $data['password'] = Hash::make($data['password']);
        $data['confirm'] = str_replace('/', '', Hash::make(Hash::make(env('APP_KEY')) . $data['password'] . '-rs'));
        $user = User::create($data);
        Mail::to($user->email)->send(new \App\Mail\Welcome($user));
        $user->roles()->attach($data['rol']);
        $user->assignPermissionsOneUser($data['rol']);
        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }
}
