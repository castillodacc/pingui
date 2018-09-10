<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referee;

class RefereeController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:referee,index')->only(['index']);
        $this->middleware('can:referee,store')->only(['store']);
        $this->middleware('can:referee,show')->only(['show']);
        $this->middleware('can:referee,update')->only(['update']);
        $this->middleware('can:referee,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $referee = Referee::dataForPaginate(['id', 'name']);
        return $this->dataWithPagination($referee);
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
        Referee::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Referee = Referee::findOrFail($id);
        return response()->json($Referee);
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
        Referee::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Referee::findOrFail($id)->delete();
    }
}
