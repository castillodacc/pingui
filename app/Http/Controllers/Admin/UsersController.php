<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permisologia\Role;
use App\Http\Requests\{UserStoreRequest, UserUpdateRequest, ChangePasswordRequest};

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:user,show')->only(['show']);
        $this->middleware('can:user,destroy')->only(['destroy']);
    }

    /**
     * Muestra una lista de recursos en json o la vista.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $select = ['id', 'user', 'name', 'last_name', 'num_id', 'email',];
        $users = User::dataForPaginate($select, function ($u) {
            $rol = '';
            foreach ($u->roles as $r) {
                $rol .= '<span class="badge">' . $r->name . '</span>';
            }
            $u->rol = $rol;
            $u->fullName = $u->fullName();
        });
        return $this->dataWithPagination($users);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $data['roles'] = $this->idsOfRol($request->roles);
        $user = new User($data);
        $user->password = bcrypt($data['password']);
        $user->save();
        $user->roles()->attach($data['roles']);
        $user->assignPermissionsOneUser($data['roles']);
        return response()->json($user);
    }

    /**
     * Mostrar el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->fullName = $user->fullName();
        $user->roles->pluck('name')->toArray();
        return response()->json($user);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if ($id == 1) {
            return response(['errors' => 'Error al modificar usuario'], 422);
        }
        $data = $request->validated();
        $data['roles'] = $this->idsOfRol($data['roles']);

        if (!empty($request->password)) {
            $data['password'] = bcrypt($this->validate($request, [
                'password' => 'string|min:6|confirmed'
            ])['password']);
        }

        $user = User::findOrFail($id)->fill($data);
        $user->update_pivot($data['roles'], 'roles', 'role_id');
        $user->assignPermissionsOneUser($data['roles']);

        return response()->json($user->save());
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id === 1) return response(['msg' => 'Error al modificar usuario'], 422);
        $user = User::findOrFail($id)->delete();
        return response()->json($user);
    }

    /**
     * se inicia la session con un recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function initWithOneUser($id)
    {
        if ($id == 1 || \Auth::user()->id != 1) return abort(401, 'Unauthorized.');
        \Auth::loginUsingId($id);
        return redirect()->to('/');
    }*/

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $roles = Role::all()->pluck('name');
        return response()->json(compact('roles'));
    }
}
