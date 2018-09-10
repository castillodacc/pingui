<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;

class ClubsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:club,index')->only(['index']);
        $this->middleware('can:club,store')->only(['store']);
        $this->middleware('can:club,show')->only(['show']);
        $this->middleware('can:club,update')->only(['update']);
        $this->middleware('can:club,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['name', 'id', 'province', 'population'];
        $clubs = Club::dataForPaginate($select);
        return $this->dataWithPagination($clubs);
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
            'name' => 'required|string|min:3|max:70|unique:clubs',
            'province' => 'required|string|min:3|max:70',
            'population' => 'required|string|min:3|max:70',
        ],[],[
            'name' => 'nombre',
            'province' => 'provincia',
            'population' => 'población',
        ]);
        $data['name'] = ucfirst(mb_strtolower($data['name']));
        $data['province'] = ucfirst(mb_strtolower($data['province']));
        $data['population'] = ucfirst(mb_strtolower($data['population']));
        Club::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $club = Club::findOrFail($id);
        return response()->json($club);
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
            'name' => 'required|string|min:3|max:70|unique1:clubs',
            'province' => 'required|string|min:3|max:70',
            'population' => 'required|string|min:3|max:70',
        ],[],[
            'name' => 'nombre',
            'province' => 'provincia',
            'population' => 'población',
        ]);
        $data['name'] = ucfirst(mb_strtolower($data['name']));
        $data['province'] = ucfirst(mb_strtolower($data['province']));
        $data['population'] = ucfirst(mb_strtolower($data['population']));
        Club::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $club = Club::findOrFail($id)->delete();
    }
}
