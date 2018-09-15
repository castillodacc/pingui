<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inscription;

class InscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:inscription,index')->only(['index']);
        // $this->middleware('can:inscription,store')->only(['store']);
        $this->middleware('can:inscription,show')->only(['show']);
        $this->middleware('can:inscription,update')->only(['update']);
        $this->middleware('can:inscription,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'febd_num_1', 'name_1', 'last_name_1', 'febd_num_2', 'name_2', 'last_name_2', 'state_pay', 'type_pay', 'state', 'tournament_id'];
        $data = Inscription::orderBy(request()->order?:'id', request()->dir?:'ASC')
        ->search(request()->search)
        ->where('tournament_id', request()->d)
        ->select($select)
        ->paginate(request()->num?:10);
        $data->each(function ($d) {
            $d->state = ($d->state == 1) ? 'Aprovado' : 'No Aprovado';
            $d->type_pay = ($d->type_pay == 1) ? 'Transferencia' : 'Paypal';
            $d->state_pay = ($d->state_pay) ? '<i class="glyphicon glyphicon-check text-center"></i>' : '<i class="glyphicon glyphicon-unchecked text-center"></i>';
            $d->user = $d->febd_num_1 . ' - ' . $d->name_1 . ' ' . $d->last_name_1;
            $d->pareja = $d->febd_num_2 . ' - ' . $d->name_2 . ' ' . $d->last_name_2;
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
            'febd_num_1' => 'required|numeric',
            'febd_num_2' => 'required|numeric',
            'last_name_1' => 'required|string',
            'last_name_2' => 'required|string',
            'name_1' => 'required|string',
            'name_2' => 'required|string',
            'tournament_id' => 'required|numeric',
            'type_pay' => 'required|numeric',
            'user_id' => 'required|numeric',
        ],[
            'febd_num_1.required' => 'Registre en su perfil su número FEBD',
            'febd_num_2.required' => 'Registre en su perfil el número FEBD de su pareja',
        ],[
            'febd_num_1' => 'número FEBD',
            'febd_num_2' => 'número FEBD de su pareja',
            'type_pay' => 'tipo de pago',
        ]);
        Inscription::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Inscription::findOrFail($id);
        $data->pareja = $data->name_1 . ' ' . $data->last_name_1 . ' - ' . $data->name_2 . ' ' . $data->last_name_2;
        $data->usuario = $data->name_1 . ' ' . $data->last_name_1;
        $data->pareja = $data->name_2 . ' ' . $data->last_name_2;
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
            'state' => 'nullable|numeric',
            'state_pay' => 'nullable|numeric',
        ],[],[
            'state' => 'estado de participación',
            'state_pay' => 'estado del pago',
        ]);
        Inscription::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Inscription::findOrFail($id)->delete();
    }
}
