<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Tournament, Referee, Category_open, Subcategory_latino, Subcategory_standar, Hotel};
use Intervention\Image\ImageManager;

class TournamentController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:tournament,index')->only(['index']);
        $this->middleware('can:tournament,store')->only(['store']);
        $this->middleware('can:tournament,show')->only(['show']);
        $this->middleware('can:tournament,update')->only(['update']);
        $this->middleware('can:tournament,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tournament = Tournament::dataForPaginate(['*'], function ($t) {
            if (strlen($t->description) > 70) {
                $t->description = substr($t->description, 0, 70) . '...';
            }
            $t->inscription = ($t->inscription) ? 'Abierta' : 'Cerrada';
        });
        return $this->dataWithPagination($tournament);
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
            'name' => 'required|string|min:5|max:40|unique:tournaments',
            'description' => 'required|string|min:15',
            'start' => 'required',
            'end' => 'required',
            'inscription' => 'required|boolean',
            'organizador' => 'required|string|min:2|max:40',
            'image' => 'required|image64:jpeg,jpg,png',
            'results' => 'nullable|string|unique:tournaments',
            'hours' => 'nullable|string|unique:tournaments',
            'info' => 'nullable|string|unique:tournaments',
            'maps' => 'nullable|string',
            'price' => 'required|numeric|min:1|max:999',
            'entrance_price' => 'required|numeric|min:1|max:999',
            'referee' => 'nullable|array',
            'category_open' => 'nullable|array',
            'hoteles' => 'nullable|array',
            'subcategory_latino' => 'nullable|array',
            'subcategory_standar' => 'nullable|array',
        ],[],[
            'name' => 'titulo',
            'description' => 'detalles',
            'start' => 'fecha de comienzo',
            'end' => 'fecha final',
            'inscription' => 'inscripción',
            'image' => 'imagen',
            'results' => 'resultados',
            'hours' => 'horarios',
            'maps' => 'mapas',
            'info' => 'información',
            'price' => 'precio',
            'entrance_price' => 'precio de entrada',
            'referee' => 'referee',
            'category_open' => 'categoria open',
            'subcategory_latino' => 'categoria latino',
            'subcategory_standar' => 'categoria standard',
        ]);

        $data['slug'] = str_replace(' ', '-', $data['name']);
        $slug = Tournament::where('slug', '=', $data['slug'])->count();
        if ($slug > 0) {
            $data['slug'] .= '-' . $slug;
        }

        $data['end'] = str_replace('/', '-', $data['end']);
        if (!is_null($data['end'])) {
            $data['end'] = \Carbon::parse($data['end'])->format('Y-m-d');
        }
        $data['start'] = str_replace('/', '-', $data['start']);
        if (!is_null($data['start'])) {
            $data['start'] = \Carbon::parse($data['start'])->format('Y-m-d');
        }
        $data['record_id'] = \Auth::user()->id;

        if ($request->image) {
            $imageData = $request->image;
            $data['image'] = 'tournament-' . \Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            (new ImageManager)->make($request->image)->save(public_path('storage\\') . $data['image']);
        }

        $tournament = Tournament::create($data);

        foreach ($data['hoteles'] as $h) {
            Hotel::create([
                'name' => $h['hotel'],
                'link' => $h['link'],
                'tournament_id' => $tournament->id,
            ]);
        }

        $tournament->referees()
        ->attach($data['referee']);
        $tournament->category_opens()
        ->attach($data['category_open']);
        $tournament->subcategory_latinos()
        ->attach($data['subcategory_latino']);
        $tournament->subcategory_standars()
        ->attach($data['subcategory_standar']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tournament = Tournament::findOrFail($id);
        $tournament->start = \Carbon::parse($tournament->start)->format('d/m/Y');
        $tournament->end = \Carbon::parse($tournament->end)->format('d/m/Y');
        $tournament->referee_tournament = $tournament->referees->pluck('name');
        $tournament->category_open_tournament = $tournament->category_opens->pluck('name');
        $tournament->subcategory_latino_tournament = $tournament->subcategory_latinos->pluck('name', 'category_latino_id');
        $tournament->subcategory_latino_tournament = $tournament->subcategory_latinos;
        $tournament->subcategory_latino_tournament->each(function ($s) {
            $s->name = $s->category_latino->name . ' - ' . $s->name;
            unset($s->category_latino,$s->category_latino_id,$s->description,$s->id,$s->pivot);
        });
        $tournament->subcategory_standar_tournament = $tournament->subcategory_standars;
        $tournament->subcategory_standar_tournament->each(function ($s) {
            $s->name = $s->category_standar->name . ' - ' . $s->name;
            unset($s->category_standar,$s->category_standar_id,$s->description,$s->id,$s->pivot);
        });
        $tournament->hotels;
        unset($tournament->referees, $tournament->category_opens, $tournament->subcategory_latinos, $tournament->subcategory_standars);
        return response()->json($tournament);
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
            'name' => 'required|string|min:5|max:40|unique1:tournaments',
            'description' => 'required|string|min:15',
            'start' => 'required',
            'end' => 'required',
            'inscription' => 'required|boolean',
            'organizador' => 'required|string|min:2|max:40',
            'image' => 'required|image64:jpeg,jpg,png',
            'results' => 'nullable|string',
            'hours' => 'nullable|string',
            'info' => 'nullable|string',
            'maps' => 'nullable|string',
            'price' => 'required|numeric|min:1|max:999',
            'entrance_price' => 'required|numeric|min:1|max:999',
            'referee' => 'nullable|array',
            'category_open' => 'nullable|array',
            'hoteles' => 'nullable|array',
            'subcategory_latino' => 'nullable|array',
            'subcategory_standar' => 'nullable|array',
        ],[],[
            'name' => 'titulo',
            'description' => 'detalles',
            'start' => 'fecha de comienzo',
            'end' => 'fecha final',
            'inscription' => 'inscripción',
            'image' => 'imagen',
            'results' => 'resultados',
            'hours' => 'horarios',
            'maps' => 'mapas',
            'info' => 'información',
            'price' => 'precio',
            'entrance_price' => 'precio de entrada',
            'referee' => 'referee',
            'category_open' => 'categoria open',
            'subcategory_latino' => 'categoria latino',
            'subcategory_standar' => 'categoria standard',
        ]);

        $data['slug'] = str_replace(' ', '-', $data['name']);
        $slug = Tournament::where('slug', '=', $data['slug'])->count();
        if ($slug > 0) {
            $data['slug'] .= '-' . $slug;
        }

        $data['end'] = str_replace('/', '-', $data['end']);
        if (!is_null($data['end'])) {
            $data['end'] = \Carbon::parse($data['end'])->format('Y-m-d');
        }
        $data['start'] = str_replace('/', '-', $data['start']);
        if (!is_null($data['start'])) {
            $data['start'] = \Carbon::parse($data['start'])->format('Y-m-d');
        }
        $data['record_id'] = \Auth::user()->id;

        if (is_readable(public_path("storage\$request->image"))) {
        } else {
            if (strlen($request->image) > 50) {
                $imageData = $request->image;
                $data['image'] = 'tournament-' . \Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                (new ImageManager)->make($request->image)->save(public_path('storage\\') . $data['image']);
            }
        }

        $tournament = Tournament::findOrFail($id);
        $tournament->update($data);
        
        $id_hotels = $tournament->hotels->pluck('id')->toArray();
        $id_hotels_new = [];
        foreach ($data['hoteles'] as $h) {
            if (isset($h['id'])) {
                $id_hotels_new[] = $h['id'];
                Hotel::findOrFail($h['id'])->update([
                    'name' => $h['hotel'],
                    'link' => $h['link'],
                ]);
            } else {
                Hotel::create([
                    'name' => $h['hotel'],
                    'link' => $h['link'],
                    'tournament_id' => $tournament->id,
                ]);
            }
        }
        $delete = array_diff($id_hotels, $id_hotels_new);
        foreach ($delete as $d) {
            Hotel::findOrFail($d)->delete();
        }

        $tournament->update_pivot($data['referee'], 'referees');
        $tournament->update_pivot($data['category_open'], 'category_opens');
        $tournament->update_pivot($data['subcategory_latino'], 'subcategory_latinos');
        $tournament->update_pivot($data['subcategory_standar'], 'subcategory_standars');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Tournament::findOrFail($id)->delete();
    }

    public function dataForRegister()
    {
        $referees = Referee::get(['id', 'name']);
        $category_opens = Category_open::get(['id', 'name']);
        $category_latinos = Subcategory_latino::get(['id', 'name', 'category_latino_id']);
        $category_latinos->each(function ($c) {
            $c->name = $c->category_latino->name . ' - ' . $c->name;
            unset($c->category_latino, $c->category_latino_id);
        });
        $category_standars = Subcategory_standar::get(['id', 'name', 'category_standar_id']);
        $category_standars->each(function ($c) {
            $c->name = $c->category_standar->name . ' - ' . $c->name;
            unset($c->category_standar, $c->category_standar_id);
        });
        return response()->json(compact('referees', 'category_opens', 'category_latinos', 'category_standars'));
    }

    public function upload($name)
    {
        $file = request()->file($name);
        $nombre = str_replace(' ', '-', $file->getClientOriginalName());
        \Storage::disk('local')->put("/$name/$nombre", \File::get($file));
        return response()->json($nombre);
    }
}
