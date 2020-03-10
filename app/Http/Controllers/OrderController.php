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

  public function update(Request $request) {
    if ($request->input("name") == "status") {

      if ($request->input("value") == "1") {
        $status = "processing";
      } elseif ($request->input("value") == "2") {
        $status = "completed";
      }

      $data = [
        "status" => $status
      ];

      $number = $request->input("pk");

      return Woocommerce::put("orders/$number", $data);
    } elseif ($request->input("name") == "prepare_by") {
      \Log::info($request->input());
      $data = [
        "meta_data" => [
          [
            "key" => "prepare_by",
            "value" => $request->input("value")
          ]
        ]
      ];

      $number = $request->input("pk");

      return Woocommerce::put("orders/$number", $data);
    }

    return "ok";
  }
}
