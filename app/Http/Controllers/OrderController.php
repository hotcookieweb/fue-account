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
  public function __construct() {
    $this->middleware('auth');
  }

	public function order($id) {
		$order = Woocommerce::get("orders/$id");

		return view('order')->with('order', $order);
	}

  public function board() {
    return view('board');
  }
}
