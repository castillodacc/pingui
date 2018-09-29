<?php

namespace App\Payment;

/**
 * Clase PayPal para manejar las transacciones...
 */
class Paypal
{

	private $_apiContext;
	private $inscription;
	private $currency;
	private $_ClientId;
	private $_ClientSecret;

	function __construct($inscription)
	{
		$this->_apiContext = \PaypalPayment::ApiContext($this->_ClientId, $this->_ClientSecret);
		$this->currency = env('CURRENCY');
		// $this->_ClientId = config('paypal_payment.account.client_id');
		// $this->_ClientSecret = config('paypal_payment.account.client_secret');
		$this->_ClientId = $inscription->tournament->organizer->paypal_client_id;
		$this->_ClientSecret = $inscription->tournament->organizer->paypal_client_secret;

		$config = config('paypal_payment');
		$flatConfig = array_dot($config);
		$this->_apiContext->setConfig($flatConfig);

		$this->inscription = $inscription;
	}

	/**
	 * Funcion para generar el pago.
	 */
	public function generate()
	{
		$payment = \PaypalPayment::payment()
		->setIntent('sale') // Objetivo de la petición "sale" == "vender"
		->setPayer($this->payer()) // Información de la persona que va a pagar
		->setTransactions([$this->transaction()]) // cosas que se quieren cobrar
		->setRedirectUrls($this->redirectURLs()); // url de redireccionamiento (al generar el cobro se envia a paypal y luego paypal lo regresa si se autoriza o cancela)

		try {
			$payment->create($this->_apiContext);
		} catch (\Exeption $ex) {
			// dd($ex);
			exit();
		}

		return $payment;
	}

	/**
	 * Retorna la información del pagador.
	 */
	public function payer()
	{
		return \PaypalPayment::payer()
		->setPaymentMethod('paypal'); // cobro con paypal
	}

	/**
	 * Retorna la información de la transasion.
	 */
	public function transaction()
	{
		return \PaypalPayment::transaction()
		->setAmount($this->amount()) // monto a cobrar
		->setItemList($this->items())
		->setDescription("Pago a PINGUI")
		->setInvoiceNumber(uniqid());
	}

	/**
	 * Retorna el monto a pagar.
	 */
	public function amount()
	{
		return \PaypalPayment::amount()
		->setCurrency($this->currency) // en que moneda se va a pagar
		->setTotal($this->inscription->pay); // total a cobrar
	}

	public function items()
	{
		$items = [];

		$item = \PaypalPayment::item()
		->setName($this->inscription->tournament->name)
		->setDescription('Pago de competición: ' . $this->inscription->tournament->name)
		->setCurrency($this->currency) // colocar en euros
		->setQuantity(1) // cantidad que se va a pagar
		->setPrice($this->inscription->pay);

		array_push($items, $item);

		return \PaypalPayment::itemList()
		->setItems($items);
	}

	/**
	 * Retorna la las url a la que paypal redirigirá.
	 */
	public function redirectURLs()
	{
		return \PaypalPayment::redirectUrls()
		->setReturnUrl(route('payment.store', $this->inscription->id))
		->setCancelUrl(route('payment.cancel', $this->inscription->id));
	}

	/**
	 * Ejecuta el cobro o retira al dinero al saldo del vendedor.
	 */
	public function execute($paymentId, $payerId)
	{
		$payment = \PaypalPayment::getById($paymentId, $this->_apiContext);

		$execution = \PaypalPayment::PaymentExecution()
		->setPayerId($payerId);

		return $payment->execute($execution, $this->_apiContext);
	}

}