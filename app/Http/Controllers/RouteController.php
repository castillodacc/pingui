<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permisologia\Permission;
use App\User;
use App\Models\ { Inscription, Tournament };

class RouteController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except(['front', 'publication', 'confirm']);
    }

    /**
     * Vista principal que renderizara vuejs
     * @return view
     */
    function index()
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
        $tournament2 = \App\Models\Tournament::take(10)->orderBy('id', 'desc')->get();
        $tournament = Tournament::paginate(10);
        return view('frontend', compact('tournament', 'tournament2'));
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
        return view('inscription', compact('tournament', ''));
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
        $inscription = Inscription::where('tournament_id', '=', $request->id)
        ->where('user_id', '=', \Auth::user()->id)
        ->first();
        $state = false;
        if ($inscription) {$state = $inscription; }
        if (\Auth::guest()) return;
        $user = \App\User::findOrFail(\Auth::user()->id);
        $user->parejas;
        return response()->json(compact('user', 'state'));
    }
}
