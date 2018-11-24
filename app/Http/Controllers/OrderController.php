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

	public function order($id) {
		$params = [
			'id' => $id
		];

		$order = Woocommerce::get('orders', $params)[0];

		return view('order')->with('order', $order);
	}

	public function board() {
		$params = [
			'status' => 'processing'
		];

		$orders = Woocommerce::get('orders', $params);

		return view('board')->with('orders', $orders);
	}
}
