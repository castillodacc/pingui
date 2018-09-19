<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\ { ChangePasswordRequest, UpdatePerfilUserRequest };
use App\Models\ { Club, Pareja };

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
        $pareja = optional($user->parejas)[0];
        $pareja2 = optional($user->parejas)[1];
        $user->module;
        $club = Club::get(['id', 'name']);
        return response()->json(compact('user', 'club', 'pareja', 'pareja2'));
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
            'febd_num' => 'nullable|numeric|digits_between:2,6',
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

    public function pareja(Request $request)
    {
        $request->validate([
            'p_email' => 'nullable|email',
            'p_febd_num' => 'nullable|numeric',
            'birthdate' => 'nullable|date',
            'p_last_name' => 'required|string|min:3|max:40',
            'p_name' => 'required|string|min:3|max:40'
        ],[],[
            'p_email' => 'email',
            'p_febd_num' => 'número FEBD',
            'birthdate' => 'fecha de nacimiento',
            'p_last_name' => 'apellido',
            'p_name' => 'nombre',
        ]);
        if ($request->id) {
            Pareja::where('user_id', '=', \Auth::user()->id)
            ->findOrFail($request->id)
            ->update([
                'name' => $request->p_name,
                'last_name' => $request->p_last_name,
                'email' => $request->p_email,
                'febd_num' => $request->p_febd_num,
            ]);
        } else {
            Pareja::create([
                'name' => $request->p_name,
                'last_name' => $request->p_last_name,
                'email' => $request->p_email,
                'febd_num' => $request->p_febd_num,
                'user_id' => \Auth::user()->id
            ]);
        }
    }

    public function autoDeleting(Request $request)
    {
        if(\Auth::user()->id == 1) return response(['error' => 'Error al modificar usuario'], 421);
        \Auth::user()->fill([
            'email' => \Auth::user()->email . ' - ' . 'D',
            'num_id' => \Auth::user()->num_id . ' - ' . 'D',
            'password' => '',
        ])->save();
        $user = \Auth::user()->delete();
    }
}
