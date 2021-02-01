<?php

namespace App\Http\Controllers\Dashboard;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\ { ChangePasswordRequest, UpdatePerfilUserRequest };
use App\Models\ { Club, Pareja, Category_latino, Category_standar, Subcategory_latino, Subcategory_standar };

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if ($request->id) {
            $user = User::findOrFail($request->id);
        } else {
            $user = \Auth::user();
        }
        $user->fullName = $user->fullName();
        $user->logoPath = $user->getLogoPath();
        $user->roles;
        $pareja = optional($user->parejas)[0];
        $pareja2 = optional($user->parejas)[1];
        $user->module;
        $club = Club::get(['id', 'name']);
        $category_latino = Category_latino::get();
        $category_standar = Category_standar::get();
        return response()->json(compact('user', 'club', 'pareja', 'pareja2', 'category_latino', 'category_standar'));
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
        $user = User::findOrFail($request->id)->update($data);
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
        User::findOrFail($request->id)->update(['password' => bcrypt($request->password)]);
    }

    public function bailarin(Request $request, $id)
    {
        $data = $this->validate($request, [
            'category_l' => 'nullable',
            'category_s' => 'nullable',
            'club_id' => 'required|numeric',
            'febd_num' => 'nullable|numeric',
            'group_l' => Rule::requiredIf($request->category_l),
            'group_s' => Rule::requiredIf($request->category_s),
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
        User::findOrFail($id)->update($data);
    }

    public function pareja(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'p_email' => 'nullable|email',
            'p_febd_num' => 'nullable|numeric',
            'birthdate' => 'nullable',
            'sex' => 'required|numeric',
            'p_last_name' => 'required|string|min:3|max:40',
            'p_name' => 'required|string|min:3|max:40'
        ],[],[
            'p_email' => 'email',
            'p_febd_num' => 'número FEBD',
            'sex' => 'sexo',
            'birthdate' => 'fecha de nacimiento',
            'p_last_name' => 'apellido',
            'p_name' => 'nombre',
        ]);
        if ($request->id) {
            Pareja::where('user_id', '=', $request->user_id)
            ->findOrFail($request->id)
            ->update([
                'sex' => $request->sex,
                'name' => $request->p_name,
                'last_name' => $request->p_last_name,
                'email' => $request->p_email,
                'febd_num' => $request->p_febd_num,
            ]);
        } else {
            Pareja::create([
                'sex' => $request->sex,
                'name' => $request->p_name,
                'last_name' => $request->p_last_name,
                'email' => $request->p_email,
                'febd_num' => $request->p_febd_num,
                'user_id' => $request->user_id
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

    public function subcategories()
    {
        if (request()->id == 1) {
            $subcategories = Subcategory_latino::where('category_latino_id', '=', request()->cat)->get();
        } elseif (request()->id == 2) {
            $subcategories = Subcategory_standar::where('category_standar_id', '=', request()->cat)->get();
        }
        return response()->json(compact('subcategories'));
    }
}
