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
		$order = Woocommerce::get("orders/$id");

		return view('order')->with('order', $order);
	}

	public function board() {
		$params = [
			'status' => 'processing'
		];

		$orders = Woocommerce::get('orders', $params);

    $total_completed = count(Woocommerce::get('orders', ['status'=>'completed']));

    $upcoming = [];
    $prepare_today = [];
    $ship_today = [];
    $unknown = [];

    // shipping method ID's
    // free_shipping (Local Pickup)
    // hotcookie_delivery (USPS Priority medium)

    foreach ($orders as $order) {
      $_delivery_method = $order['shipping_lines'][0]['method_id'];
      $_delivery_date = $order['meta_data'][0]['value'];
      $_delivery_time = $order['meta_data'][1]['value'];

      // check if delivery date is valid
      $_valid_delivery_date = strtotime($_delivery_date) ? true : false;

      // check if delivery_time is valid
      $_valid_delivery_time = strlen($_delivery_time) > 6 ? true : false;

      $today = date("m/d/Y");

      // If the delivery method is "free_shipping" (local pickup), it needs at least a valid delivery date
      // and will be put in prepare_today if the delivery date is the same as today. Otherwise, if the
      // delivery date is next day or more, put in upcoming. If the delivery date is past, put it in
      // unknown.
      if ($_delivery_method == "free_shipping") {
        if ($_valid_delivery_date) {
          // if today
          $delivery = date("m/d/Y", strtotime($_delivery_date));
          if ($today == $delivery) {
            $prepare_today[] = $order;
          } else {
            if ($delivery > $today) {
              $upcoming[] = $order;
            } else {
              $unknown[] = $order;
            }
          }
        } else {
          $unknown[] = $order;
        }
      }

      // If the delivery method is "hotcookie_delivery", it at least needs a delivery date. If the delivery
      // date is 4 or more days ahead of the current date, put it in "upcoming". If the delivery date is
      // 3 or less days ahead of the current date, put it in "prepare today".

      if ($_delivery_method == "hotcookie_delivery") {
        if ($_valid_delivery_date) {
          $_upcoming_date = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")+4, date("Y")));

          if ($_delivery_date >= $_upcoming_date) {
            // If delivery date is 4 or more days from today
            $upcoming[] = $order;
          } else {
            $prepare_today[] = $order;
          }

        } else {
          $unknown[] = $order;
        }
      }


      // TODO
      // sort prepare_today based on load and delivery times

    }

    // echo count($unknown) . " unknown<br>";
    // echo count($upcoming) . " upcoming<br>";
    // echo count($prepare_today) . " prepare today<br>";
    // exit;


		return view('board')->with([
        "total_completed" => $total_completed,
        "unknown" => $unknown,
        "upcoming" => $upcoming,
        "prepare_today" => $prepare_today,
        "ship_today" => $ship_today
      ]);
	}
}
