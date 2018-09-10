<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category_open;

class CategoryOController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:categories_o,index')->only(['index']);
        $this->middleware('can:categories_o,store')->only(['store']);
        $this->middleware('can:categories_o,show')->only(['show']);
        $this->middleware('can:categories_o,update')->only(['update']);
        $this->middleware('can:categories_o,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category_open = Category_open::dataForPaginate();
        return $this->dataWithPagination($category_open);
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
            'name' => 'required|string|min:3|max:35|unique:category_opens',
        ],[],['name' => 'categoria']);
        $data['name'] = ucfirst(mb_strtolower($data['name']));
        Category_open::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category_open = Category_open::findOrFail($id);
        return response()->json($category_open);
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
            'name' => 'required|string|min:3|max:35|unique1:category_opens',
        ],[],['name' => 'categoria']);
        $data['name'] = ucfirst(mb_strtolower($data['name']));
        Category_open::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category_open::findOrFail($id)->delete();
    }
}
