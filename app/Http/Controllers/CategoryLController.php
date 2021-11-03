<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Category_latino, Subcategory_latino };

class CategoryLController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:categories_l,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:categories_l,store')->only(['store']);
        $this->middleware('can:categories_l,show')->only(['show']);
        $this->middleware('can:categories_l,update')->only(['update']);
        $this->middleware('can:categories_l,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'name', 'category_latino_id'];
        $category_standar = Subcategory_latino::dataForPaginate($select, function ($c) {
            $c->category_latino_id = $c->category_latino->name;
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
            Subcategory_latino::create([
                'name' => $data['subcategory'],
                'category_latino_id' => $data['category_id'],
            ]);
        } else {
            $data = $this->validate($request, [
                'category' => 'required|string|min:3|max:35|unique:category_latinos,name',
                'subcategory' => 'required|string|min:3|max:35',
            ],[],[
                'category' => 'categoria',
                'subcategory' => 'subcategoria',
            ]);
            $c = Category_latino::create(['name' => $data['category']]);
            Subcategory_latino::create([
                'name' => $data['subcategory'],
                'category_latino_id' => $c->id,
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
        $sl = Subcategory_latino::select(['name', 'id', 'category_latino_id'])->findOrFail($id);
        $sl->category = $sl->category_latino->name;
        $sl->subcategory = $sl->name;
        $sl->category_id = $sl->category_latino->id;
        unset($sl->category_latino, $sl->category_latino_id, $sl->name);
        return response()->json($sl);
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
            'category' => 'required|string|min:3|max:35|unique1:category_latinos,name',
            'subcategory' => 'required|string|min:3|max:35',
        ],[],[
            'category' => 'categoria',
            'subcategory' => 'subcategoria',
        ]);
        Category_latino::findOrFail($data['category_id'])
        ->update(['name' => $data['category']]);
        Subcategory_latino::findOrFail($id)
        ->update(['name' => $data['subcategory']]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subcategory_latino::findOrFail($id)->delete();
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $categories = Category_latino::get(['id', 'name']);
        return response()->json(compact(['categories']));
    }
}
