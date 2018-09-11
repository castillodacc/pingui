<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\ { ChangePasswordRequest, UpdatePerfilUserRequest };
use App\Models\Club;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = \Auth::user();
        $user->fullName = $user->fullName();
        $user->logoPath = $user->getLogoPath();
        $user->roles;
        $user->module;
        $club = Club::get(['id', 'name']);
        return response()->json(compact('user', 'club'));
    }

    /**
     * Edita datos del usuario.
     *
     * @param  \App\Http\Requests\UpdatePerfilUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editUser(UpdatePerfilUserRequest $request){
        $data = $request->validated();
        $data['phone'] = ($data['phone'] == 'null') ? null : $data['phone'];
        $data['web'] = ($data['web'] == 'null') ? null : $data['web'];
        $user = \Auth::user()->update($data);
        if ($request->hasFile('image')) {
            $extension = $request->image->getClientOriginalExtension();
            $url = $request->image->storeAs('users/image', \Auth::user()->id.'.'.$extension);
        }
        return response()->json($user);
    }

    /**
     * Edita el password del usuario logueado.
     *
     * @param  \App\Http\Requests\ChangePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editPassword(ChangePasswordRequest $request){
        $user = \Auth::user()->fill([
            'password' => bcrypt($request->password)
        ])->save();
        return response()->json($user);
    }

    public function bailarin(Request $request, $id)
    {
        $data = $this->validate($request, [
            'category_l' => 'nullable',
            'category_s' => 'nullable',
            'club_id' => 'required|numeric',
            'febd_num' => 'required|numeric|digits_between:2,6',
            'group_l' => 'nullable',
            'group_s' => 'nullable',
            'trainer_l' => 'nullable',
            'trainer_s' => 'nullable',
            'international_id' => 'nullable'
        ],[],[
            'category_l' => 'categoria latino',
            'category_s' => 'categoria standar',
            'club_id' => 'club',
            'febd_num' => 'número FEBD',
            'group_l' => 'grupo latino',
            'group_s' => 'grupo standar',
            'trainer_l' => 'entrenador latino',
            'trainer_s' => 'entrenador standar',
            'international_id' => 'internacional ID'
        ]);
        \Auth::user()->fill($data)->save();
    }

    /**
     * Retorna los datos de los modulos.
     * Permite al usuario cambiarse de modulo.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    // public function changeModule(Request $request)
    // {
        // if ($request->method() == 'POST') {
        //     $user = User::findOrFail(Auth::user()->id)->fill([
        //         'module_id' => $request->key
        //     ])->save();
        //     return response()->json($user);
        // } elseif ($request->method() == 'GET') {
        //     $module  = Auth::user()->module()->pluck('module', 'id')->toArray();
        //     $modules = (Auth::user()->iCan('changeModule', 'module')) ? 
        //     array_diff(Module::all()->pluck('module', 'id')->toArray(), $module) : null;

        //     return response()->json(compact('modules', 'module'));
        // }
    // }
}
