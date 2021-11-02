<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Inscription, Tournament, Price, Category_open, Category_latino, Category_standar, Subcategory_latino, Subcategory_standar};

class InscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:inscription,index')->only(['index']);
        $this->middleware('can:inscription,store')->only(['store']);
        $this->middleware('can:inscription,show')->only(['show']);
        $this->middleware('can:inscription,update')->only(['update']);
        $this->middleware('can:inscription,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $select = [
            'id',
            'febd_num_1',
            'name_1',
            'last_name_1',
            'febd_num_2',
            'name_2',
            'last_name_2',
            'state_pay',
            'method_pay',
            'state',
            'tournament_id',
            'dorsal'
        ];
        if (is_numeric($request->dir)) {
            $request->dir = 'ASC';
        }
        $data = Inscription::orderBy($request->order ?? 'id', $request->dir ?? 'ASC')
            ->search($request->search)
            ->where('tournament_id', $request->d)
            ->select($select)
            ->paginate($request->num ?? 10);
        $data->each(function ($d) {
            $d->dorsal = ($d->dorsal) ?? '------------';
            $d->state = ($d->state == 1) ? 'Aprobado' : 'No Aprobado';
            if ($d->method_pay == 1) {
                $d->type_pay = 'Transferencia';
            } elseif ($d->method_pay == 2) {
                $d->type_pay = 'Paypal';
            } else {
                $d->type_pay = 'Tarjeta';
            }
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
            'febd_num_1' => 'nullable|numeric',
            'febd_num_2' => 'nullable|numeric',
            'last_name_1' => 'required|string',
            'last_name_2' => 'required|string',
            'name_1' => 'required|string',
            'name_2' => 'required|string',
            'price' => 'required|array',
            'tournament_id' => 'required|numeric',
            'method_pay' => 'required|numeric',
            'pay' => 'required|numeric',
        ], [], [
            'name_1' => 'pareja',
            'name_2' => 'pareja',
            'price' => 'precios',
            'method_pay' => 'metodo de pago',
            'pay' => 'pago',
        ]);

        $data['user_id'] = \Auth::user()->id;

        $validate = Inscription::where([
            'user_id' => $data['user_id'],
            'tournament_id' => $data['tournament_id'],
            'febd_num_1' => $data['febd_num_1'],
            'febd_num_2' => $data['febd_num_2'],
            'pay' => $data['pay'],
            'method_pay' => $data['method_pay'],
        ])->first();
        if ($validate) {
            return response()->json([]);
        }

        $inscription = Inscription::create($data);

        $inscription->prices()->attach(array_unique($data['price']));

        if ($inscription->method_pay == 2) {
            $inscription->delete();
            return $this->payWithPayPal($inscription);
        }

        if ($inscription->method_pay == 3) {
            $inscription->delete();
            \Stripe\Stripe::setApiKey($inscription->tournament->organizer->t_secret_key);
            $charge = \Stripe\Charge::create([
                'amount' => $request->pay . '00',
                'currency' => env('CURRENCY'),
                'description' => 'Pago de Competición a PINGUI:'  . $inscription->tournament->name,
                'source' => $request->stripeToken
            ]);
            if ($charge['status'] == 'succeeded') {
                $inscription->restore();
                $inscription->update(['state_pay' => true]);
            }
        }

        \Mail::to($inscription->user->email)->send(new \App\Mail\Inscription($inscription));
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
        $data->user;
        $prices = $data->prices->pluck('id');
        unset($data->prices);
        $data->prices = $prices;
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
            'pay' => 'required'
        ], [], [
            'state' => 'estado de participación',
            'state_pay' => 'estado del pago',
            'pay' => 'pago'
        ]);
        $prices = $this->validate($request, ['prices' => 'required|array'], [], ['prices' => 'precios']);
        $inscription = Inscription::findOrFail($id);
        $inscription->update($data);
        $inscription->update_pivot($request->prices, 'prices');
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

    // public function paymentCancel($id, Request $request)
    // {
    //     if (!isset($request->token)) redirect('/');
    //     $inscription = Inscription::withTrashed()->findOrFail($id);
    //     $tournament = Tournament::findOrFail($inscription->tournament_id);
    //     $cancel = 'Transacción cancelada o fallida.';
    //     return view('inscription', compact('tournament', 'cancel'));
    // }

    public function generateDorsales($tournament)
    {
        $prices = Price::where('tournament_id', '=', $tournament)->get();
        $count = 1;
        foreach ($prices as $p) {
            foreach ($p->inscriptions as $i) {
                if ($i->state_pay == 1 && $i->state == 1 && $i->dorsal == null) {
                    $i->update(['dorsal' => $count]);
                    $count++;
                }
            }
        }
    }

    public function getData(Request $request)
    {
        $price = Price::where('tournament_id', $request->id)->get();
        $price->each(function ($p) {
            if ($p->category_id == 1) {
                $p->name = $p->subHelp()->name;
            } elseif ($p->category_id == 2) {
                $p->name = $p->subHelp()->category_latino->name . ' - ' . optional(Subcategory_latino::find($p->subcategory_id))->name;
            } elseif ($p->category_id == 3) {
                $p->name = $p->subHelp()->category_standar->name . ' - ' . Subcategory_standar::find($p->subcategory_id)->name;
            }
        });
        return compact('price');
    }

    private function payWithPayPal($inscription)
    {

        $organizer = $inscription->tournament->organizer;

        $payPalConfig = config('paypal');
        $payPalConfig['account']['client_id'] = $organizer->paypal_client_id;
        $payPalConfig['account']['client_secret'] = $organizer->paypal_client_secret;

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $payPalConfig['account']['client_id'],
                $payPalConfig['account']['client_secret']
            )
        );

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($inscription->pay);
        $amount->setCurrency($payPalConfig['currency']);

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription($inscription->tournament->name);

        $callbackUrl = route('payment.status', ['id' => $inscription->id]);
        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl($callbackUrl)->setCancelUrl($callbackUrl);

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($apiContext);
            return $payment->getApprovalLink();
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getData();
        }
    }

    public function paymentStatus($id, Request $request)
    {

        $inscription = Inscription::withTrashed()->findOrFail($id);
        $tournament = $inscription->tournament;
        $cancel = 'Lo sentimos! El pago a través de PayPal no se pudo realizar. Transacción cancelada o fallida.';

        if (!$request->paymentId || !$request->PayerID || !$request->token) {
            return view('inscription', compact('tournament', 'cancel'));
        }

        $organizer = $inscription->tournament->organizer;

        $payPalConfig = config('paypal');
        $payPalConfig['account']['client_id'] = $organizer->paypal_client_id;
        $payPalConfig['account']['client_secret'] = $organizer->paypal_client_secret;

        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $payPalConfig['account']['client_id'],
                $payPalConfig['account']['client_secret']
            )
        );

        $payment = \PayPal\Api\Payment::get($request->paymentId, $apiContext);

        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($request->PayerID);

        /** Execute the payment **/
        $result = $payment->execute($execution, $apiContext);

        if ($result->getState() === 'approved') {
            $status = 'Gracias! El pago a través de PayPal se ha ralizado correctamente.';

            $inscription->restore();
            $inscription->update(['state_pay' => true]);
            // \Mail::to($inscription->user->email)->send(new \App\Mail\Inscription($inscription));
            return view('inscription', compact('tournament', 'status'));
        }

        return redirect('/inscription')->with(compact('cancel'));
    }
}
