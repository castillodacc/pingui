<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permisologia\Permission;
use App\User;
use App\Models\ { Inscription, Tournament, Category_open, Category_latino, Subcategory_latino, Category_standar, Subcategory_standar };

class RouteController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->only([
            'index',
            'canPermission',
            'inscription',
            'data',
        ]);
    }

    /**
     * Vista principal que renderizara vuejs
     * @return view
     */
    public function index()
    {
    	return view('index');
    }

    /**
     * Envia a la vista datos.
     * @return Array
     */
    public function dataForTemplate()
    {
        if (! \Auth::check()) return response()->json();

        if (request()->rs == 'ras') {
            $user = \Auth::user();
            $all = [
                'L' => [
                    'Lg' => config('frontend.logo_lg'),
                    'Lm' => config('frontend.logo_mini')
                ],
                'user' => [
                    'fullName' => $user->fullName(),
                    'logoPath' => $user->getLogoPath(),
                    'from' => $user->created_at->toFormattedDateString()
                ],
                'foot' => [
                    'y' => date('Y'),
                    'credits' => config('frontend.credits'),
                    'version' => config('frontend.version')
                ]
            ];
        } elseif (request()->rs == 'p') {
            $all = \Auth::user()->permissionsOfUser();
        }
        return response()->json($all);
    }

    /**
     * Verifica si puedo acceder a esa vista.
     * @return Boolean
     */
    public function canPermission(Request $request)
    {
        $whiteList = ['error', 'profile', 'dashboard'];
        if (in_array($request->p, $whiteList)) return response()->json(true);
        $separated = explode('.', $request->p);
        $module = $separated[0];
        $action = $separated[1];
        if (\Auth::user()->iCan($module, $action)) return response()->json(true);
        if (strpos($request->p, '-') > 0) {
            $modules_separated = explode('-', $request->p);
            $lastArray = array_pop($modules_separated);
            $separated = explode('.', $lastArray);
            $module = $separated[0];
            $action = $separated[1];

            if (\Auth::user()->iCan($module, $action)) return response()->json(true);

            foreach ($modules_separated as $ms) {
                if (\Auth::user()->iCan($ms, $action)) return response()->json(true);
            }
        }

        return response()->json(false);
    }

    public function front()
    {
        $tournament2 = Tournament::take(10)->orderBy('id', 'DESC')->where('inscription', 1)->get();
        $tournament = Tournament::orderBy('inscription', 'DESC')->orderBy('id', 'DESC')->paginate(10);
        $all = $tournament->all();
        $data = [];
        if (isset($all[1]) && $all[1]->inscription == 1) {
            foreach ($all as $key => $value) {
                $data[] = $value;
            }
        } else {
            $data = $all;
        }
        return view('frontend', compact('tournament', 'tournament2', 'data'));
    }

    public function publication($slug)
    {
        $tournament = Tournament::where('slug', '=', $slug)->first();
        if ($tournament == null) return redirect('/');
        return view('publicacion', compact('tournament'));
    }

    public function inscription($slug)
    {
        $tournament = Tournament::where('slug', '=', $slug)->first();
        if ($tournament == null) return redirect('/');
        return view('inscription', compact('tournament'));
    }

    public function confirm($slug)
    {
        try {
            $user = User::where('confirm', '=', $slug)->first();
            if ($user) {
                $user->update(['confirm' => 1]);
                \Auth::loginUsingId($user->id);
                return redirect('/');
            } else {
                return view('errors.404', ['msg' => 'Ups! al parecer te has perdido...']);
            }
        } catch(QueryException $e) {
            return redirect('/');
        }
    }

    public function data(Request $request)
    {
        $tournament = Tournament::select(['id', 'name', 'slug', 'organizer_id'])->findOrFail($request->id);
        $tournament->prices->each(function ($p) {
            if ($p->category_id == 1) {
                $p->level_text = Category_open::findOrFail($p->subcategory_id)->name;
            } elseif ($p->category_id == 2) {
                $p->level_text = Category_latino::findOrFail($p->level_id)->name;
                $p->subcategory_text = Subcategory_latino::findOrFail($p->subcategory_id)->name;
            } elseif ($p->category_id == 3) {
                $p->level_text = Category_standar::findOrFail($p->level_id)->name;
                $p->subcategory_text = Subcategory_standar::findOrFail($p->subcategory_id)->name;
            }
        });
        $tournament->organizer;
        $tournament->organizer->paypal_client_id = ($tournament->organizer->paypal_client_id) ? true : false;
        $tournament->organizer->paypal_client_secret = ($tournament->organizer->paypal_client_secret) ? true : false;
        $tournament->organizer->t_secret_key = ($tournament->organizer->t_secret_key) ? true : false;

        $inscription = Inscription::where('tournament_id', '=', $request->id)
        ->where('user_id', '=', \Auth::user()->id)
        ->select(['id', 'last_name_1', 'last_name_2', 'method_pay', 'name_1', 'name_2', 'pay', 'state', 'state_pay'])
        ->first();
        $state = false;
        if ($inscription) {
            $state = $inscription;
            $state->prices->each(function ($p) {
                unset($p->pivot, $p->tournament_id);
            });
        }
        if (\Auth::guest()) return;
        $user = \Auth::user();
        $user->parejas;
        return response()->json(compact('user', 'state', 'tournament'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function contactSave(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        \Mail::to('info@pingui.com')->send(new \App\Mail\Contact($request));
    }

    public function list($slug)
    {
        $tournament = Tournament::where('slug', $slug)->first();
        if ($tournament == null) return redirect('/');
        return view('inscription-list', compact('tournament'));
    }
}
