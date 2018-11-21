<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;

class OrderController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function orders() {
		$params = [
			'per_page' => 10,
			'page' => 1
		];

		$orders = Woocommerce::get('orders', $params);

		return view('orders')->with('orders', $orders);
	}
}
