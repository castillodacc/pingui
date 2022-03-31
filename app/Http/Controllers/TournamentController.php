<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Tournament, Referee, Category_open, Category_latino, Subcategory_latino, Category_standar, Subcategory_standar, Hotel, Price, Organizer, Inscription, MoreInfo };
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
            $t->name = (strlen($t->name) > 40) ? substr($t->name, 0, 40) . '...' : $t->name;
            $t->description = (strlen($t->description) > 70) ? substr($t->description, 0, 70) . '...' : $t->description;
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
            'name' => 'required|string|min:5|max:200|unique:tournaments',
            'description' => 'required|string|min:15',
            'start' => 'required',
            'end' => 'required',
            'show_hour' => 'nullable',
            'inscription' => 'required|boolean',
            'organizer_id' => 'required|numeric',
            'image' => 'required|image64:jpeg,jpg,png',
            'results' => 'nullable|numeric|min:1|unique:tournaments',
            'hours' => 'nullable|string|unique:tournaments',
            'info' => 'nullable|string|unique:tournaments',
            'maps' => 'nullable|string',
            'more_info' => 'nullable|array',
            'referee' => 'nullable|array',
            'category_open' => 'nullable|array',
            'hoteles' => 'nullable|array',
            'prices' => 'nullable|array',
            'subcategory_latino' => 'nullable|array',
            'subcategory_standar' => 'nullable|array',
            'external_link' => 'nullable|string',
        ],[],[
            'name' => 'titulo',
            'description' => 'detalles',
            'start' => 'fecha de comienzo',
            'organizer_id' => 'organizador',
            'end' => 'fecha final',
            'inscription' => 'inscripción',
            'image' => 'imagen',
            'results' => 'resultados',
            'hours' => 'horarios',
            'maps' => 'mapas',
            'info' => 'información',
            'prices' => 'precios',
            'referee' => 'referee',
            'category_open' => 'categoria open',
            'subcategory_latino' => 'categoria latino',
            'subcategory_standar' => 'categoria standard',
            'external_link' => 'link',
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
            (new ImageManager)->make($request->image)->save(env('APP_FILES', public_path('storage/')) . $data['image']);
        }

        $tournament = Tournament::create($data);

        foreach ($data['hoteles'] as $h) {
            Hotel::create([
                'name' => $h['hotel'],
                'link' => $h['link'],
                'tournament_id' => $tournament->id,
            ]);
        }

        foreach ($data['prices'] as $p) {
            $p['tournament_id'] = $tournament->id;
            Price::create($p);
        }

        foreach ($data['more_info'] as $m) {
            $m['tournament_id'] = $tournament->id;
            MoreInfo::create($m);
        }

        $tournament->referees()->attach($data['referee']);

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
        $tournament->hotels;
        $tournament->moreInfo;
        $tournament->prices = $tournament->prices->each(function ($p) {
            if ($p->category_id == 1) {
                $p->level_text = optional(Category_open::withTrashed()->find($p->subcategory_id))->name;
                if (!$p->level_text) {
                    return false;
                }
            } elseif ($p->category_id == 2) {
                $p->level_text = optional(Category_latino::withTrashed()->find($p->level_id))->name;
                $p->subcategory_text = optional(Subcategory_latino::withTrashed()->find($p->subcategory_id))->name;
                if (!$p->level_text || !$p->subcategory_text) {
                    return false;
                }
            } elseif ($p->category_id == 3) {
                $p->level_text = optional(Category_standar::withTrashed()->find($p->level_id))->name;
                $p->subcategory_text = optional(Subcategory_standar::withTrashed()->find($p->subcategory_id))->name;
                if (!$p->level_text || !$p->subcategory_text) {
                    return false;
                }
            }
        });
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
            'name' => 'required|string|min:5|max:200|unique1:tournaments',
            'description' => 'required|string|min:15',
            'start' => 'required',
            'end' => 'required',
            'inscription' => 'required|boolean',
            'organizer_id' => 'required|numeric',
            'image' => 'required|image64:jpeg,jpg,png',
            'results' => 'nullable|numeric|min:1|unique1:tournaments',
            'show_hour' => 'nullable',
            'hours' => 'nullable|string',
            'more_info' => 'nullable|array',
            'info' => 'nullable|string',
            'maps' => 'nullable|string',
            'referee' => 'nullable|array',
            'prices' => 'nullable|array',
            'category_open' => 'nullable|array',
            'hoteles' => 'nullable|array',
            'subcategory_latino' => 'nullable|array',
            'subcategory_standar' => 'nullable|array',
            'external_link' => 'nullable|string',
        ],[],[
            'name' => 'titulo',
            'description' => 'detalles',
            'start' => 'fecha de comienzo',
            'organizer_id' => 'organizador',
            'end' => 'fecha final',
            'inscription' => 'inscripción',
            'prices' => 'precios',
            'image' => 'imagen',
            'results' => 'resultados',
            'hours' => 'horarios',
            'maps' => 'mapas',
            'info' => 'información',
            'referee' => 'referee',
            'category_open' => 'categoria open',
            'subcategory_latino' => 'categoria latino',
            'subcategory_standar' => 'categoria standard',
            'external_link' => 'link',
        ]);

        $data['slug'] = str_replace(' ', '-', $data['name']);
        $slug = Tournament::where('slug', '=', $data['slug'])->count();
        if ($slug > 1) {
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

        if (is_readable(env('APP_FILES', public_path('storage/')) . $request->image)) {
        } else {
            if (strlen($request->image) > 50) {
                $imageData = $request->image;
                $data['image'] = 'tournament-' . \Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                (new ImageManager)->make($request->image)->save(env('APP_FILES', public_path('storage/')) . $data['image']);
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

        $id_prices = $tournament->prices->pluck('id')->toArray();
        $id_prices_new = [];
        foreach ($data['prices'] as $p) {
            if (isset($p['id'])) {
                $id_prices_new[] = $p['id'];
                Price::findOrFail($p['id'])->update($p);
            } else {
                $p['tournament_id'] = $tournament->id;
                Price::create($p);
            }
        }
        $delete = array_diff($id_prices, $id_prices_new);
        foreach ($delete as $d) {
            Price::findOrFail($d)->delete();
        }

        foreach ($data['more_info'] as $m) {
            if (isset($m['id'])) {
                MoreInfo::findOrFail($m['id'])->update($m);
            } else {
                $m['tournament_id'] = $tournament->id;
                MoreInfo::create($m);
            }
        }

        $tournament->update_pivot($data['referee'], 'referees');
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
        $organizers = Organizer::get(['id', 'name']);
        $referees = Referee::get(['id', 'name']);
        $category_opens = Category_open::get(['id', 'name']);
        $category_latinos = Subcategory_latino::get(['id', 'name', 'category_latino_id']);
        $category_latinos->each(function ($c) {
            $c->name = $c->category_latino->name . ' - ' . $c->name;
            $c->category_id = $c->category_latino->id;
            unset($c->category_latino, $c->category_latino_id);
        });
        $category_standars = Subcategory_standar::get(['id', 'name', 'category_standar_id']);
        $category_standars->each(function ($c) {
            $c->name = $c->category_standar->name . ' - ' . $c->name;
            $c->category_id = $c->category_standar->id;
            unset($c->category_standar, $c->category_standar_id);
        });
        return response()->json(compact('referees', 'category_opens', 'category_latinos', 'category_standars', 'organizers'));
    }

    public function upload(Request $request, $name)
    {
        $file = $request->file($name);
        $nombre = str_replace(' ', '-', $file->getClientOriginalName());
        \Storage::disk('public')->put("/$name/$nombre", \File::get($file));
        return response()->json($nombre);
    }

    public function user(Request $request)
    {
        $select = ['id', 'febd_num_1', 'name_1', 'last_name_1', 'febd_num_2', 'name_2', 'last_name_2', 'state_pay', 'method_pay', 'state', 'tournament_id'];
        $data = Inscription::orderBy($request->order?:'id', $request->dir?:'ASC')
        ->search($request->search)
        ->where('user_id', \Auth::user()->id)
        ->select($select)
        ->paginate($request->num?:10);
        $data->each(function ($d) {
            $d->state = ($d->state == 1) ? 'Aprobado' : 'Por Aprobar';
            $d->type_pay = ($d->method_pay == 1) ? 'Transferencia' : 'Paypal';
            $d->state_pay = ($d->state_pay) ? '<i class="glyphicon glyphicon-check text-center"></i>' : '<i class="glyphicon glyphicon-unchecked text-center"></i>';
            $t = $d->tournament->name;
            $d->user = $d->febd_num_1 . ' - ' . $d->name_1 . ' ' . $d->last_name_1;
            $d->pareja = $d->febd_num_2 . ' - ' . $d->name_2 . ' ' . $d->last_name_2;
            unset($d->tournament);
            $d->tournament = $t;
        });
        return $this->dataWithPagination($data);
    }

    public function uploadFile(Request $request, $type_id)
    {
        $file = $request->file('file');
        $nombre = utf8_encode(str_replace(' ', '-', $file->getClientOriginalName()));
        if ($request->type_id == 2) {
            $folder = 'csv';
        } else {
            $request->validate(['file' => 'required|mimes:pdf']);
            $folder = 'pdf';
        }
        \Storage::disk('public')->put("/more_info/$folder/$nombre", \File::get($file));
        return response()->json("/storage/more_info/$folder/$nombre");
    }
}
