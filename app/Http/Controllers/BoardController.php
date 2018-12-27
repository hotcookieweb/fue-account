<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;

class BoardController extends Controller
{
    public function board() {
      $params = [
  			'status' => 'processing'
  		];

  		$orders = Woocommerce::get('orders', $params);

      $data = [];

      foreach($orders as $order) {
        $new_data = [];

        $delivery_type = $order['shipping_lines'][0]["method_title"];

        $new_data["number"] = $order["number"];
        $new_data["created_at"] = $order["date_created"];
        $new_data["delivery_type"] = $delivery_type;
        $new_data["prepare_by"] = "TODO";
        $new_data["delivery_date"] = $order['meta_data'][0]['value'] ? $order['meta_data'][0]['value'] : "None";

        $new_data["delivery_time"] = $order['meta_data'][1]['value'] ? $order['meta_data'][1]['value'] : "None";
        if (explode(" ", $new_data["delivery_time"])[0] !== "Between") {
          $new_data["delivery_time"] = "None";
        }

        $new_data["status"] = $order["status"];
        $new_data["packing_slip"] = "TODO";
        $new_data["edit"] = '<a href="/orders/' . $order["number"]. '">Edit</a>';

        $data[] = $new_data;
      }

      return $data;
    }
}
