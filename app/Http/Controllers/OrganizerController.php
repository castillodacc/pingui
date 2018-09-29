<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organizer;

class OrganizerController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:organizer,index')->only(['index']);
        $this->middleware('can:organizer,store')->only(['store']);
        $this->middleware('can:organizer,show')->only(['show']);
        $this->middleware('can:organizer,update')->only(['update']);
        $this->middleware('can:organizer,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Organizer::dataForPaginate(['*'], function ($o) {
            $o->t = '<i class="glyphicon glyphicon-unchecked"></i>';
            if ($o->bank && $o->account && $o->headline) {
                $o->t = '<i class="glyphicon glyphicon-check"></i>';
            }
            $o->t_ = '<i class="glyphicon glyphicon-unchecked"></i>';
            if ($o->t_publishable_key && $o->t_secret_key) {
                $o->t_ = '<i class="glyphicon glyphicon-check"></i>';
            }
            $o->p = '<i class="glyphicon glyphicon-unchecked"></i>';
            if ($o->paypal_client_id && $o->paypal_client_secret) {
                $o->p = '<i class="glyphicon glyphicon-check"></i>';
            }
        });
        return $this->dataWithPagination($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|min:3|max:70|unique:referees',
            'bank' => 'nullable|string',
            'account' => 'nullable|string',
            'headline' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'paypal_client_secret' => 'nullable|string',
            't_publishable_key' => 'nullable|string',
            't_secret_key' => 'nullable|string',
        ],[],['name' => 'nombre']);
        $data['name'] = ucfirst(mb_strtolower($data['name']));
        Organizer::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Organizer::findOrFail($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validate($request, [
            'id' => 'required|numeric',
            'name' => 'required|string|min:3|max:70|unique1:referees',
            'bank' => 'nullable|string',
            'account' => 'nullable|string',
            'headline' => 'nullable|string',
            'paypal_client_id' => 'nullable|string',
            'paypal_client_secret' => 'nullable|string',
            't_publishable_key' => 'nullable|string',
            't_secret_key' => 'nullable|string',
        ],[],['name' => 'nombre']);
        $data['name'] = ucfirst(mb_strtolower($data['name']));
        Organizer::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Organizer::findOrFail($id)->delete();
    }
}
