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
        $data = Organizer::dataForPaginate(['id', 'name']);
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
