<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Category_standar, Subcategory_standar };

class CategorySController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:categories_s,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:categories_s,store')->only(['store']);
        $this->middleware('can:categories_s,show')->only(['show']);
        $this->middleware('can:categories_s,update')->only(['update']);
        $this->middleware('can:categories_s,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'name', 'category_standar_id'];
        $category_standar = Subcategory_standar::dataForPaginate($select, function ($c) {
            $c->category_standar_id = $c->category_standar->name;
        });
        return $this->dataWithPagination($category_standar);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->category_id) {
            $data = $this->validate($request, [
                'category_id' => 'required|numeric',
                'subcategory' => 'required|string|min:3|max:35',
            ],[],[
                'category_id' => 'categoria',
                'subcategory' => 'subcategoria',
            ]);
            Subcategory_standar::create([
                'name' => ucfirst(mb_strtolower($data['subcategory'])),
                'category_standar_id' => $data['category_id'],
            ]);
        } else {
            $data = $this->validate($request, [
                'category' => 'required|string|min:3|max:35|unique:category_standars,name',
                'subcategory' => 'required|string|min:3|max:35',
            ],[],[
                'category' => 'categoria',
                'subcategory' => 'subcategoria',
            ]);
            $c = Category_standar::create(['name' => ucfirst(mb_strtolower($data['category']))]);
            Subcategory_standar::create([
                'name' => ucfirst(mb_strtolower($data['subcategory'])),
                'category_standar_id' => $c->id,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ss = Subcategory_standar::select(['name', 'id', 'category_standar_id'])->findOrFail($id);
        $ss->category = $ss->category_standar->name;
        $ss->subcategory = $ss->name;
        $ss->category_id = $ss->category_standar->id;
        unset($ss->category_standar, $ss->category_standar_id, $ss->name);
        return response()->json($ss);
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
            'category_id' => 'required|numeric',
            'category' => 'required|string|min:3|max:35|unique1:category_standars,name',
            'subcategory' => 'required|string|min:3|max:35',
        ],[],[
            'category' => 'categoria',
            'subcategory' => 'subcategoria',
        ]);
        Category_standar::findOrFail($data['category_id'])
        ->update(['name' => ucfirst(mb_strtolower($data['category']))]);
        Subcategory_standar::findOrFail($id)
        ->update(['name' => ucfirst(mb_strtolower($data['subcategory']))]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subcategory_standar::findOrFail($id)->delete();
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $categories = Category_standar::get(['id', 'name']);
        return response()->json(compact(['categories']));
    }
}
