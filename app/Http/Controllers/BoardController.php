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

      $statuses = [];

      $statuses[] = [
        "value" => "processing",
        "text" => "Processing"
      ];

      $statuses[] = [
        "value" => "completed",
        "text" => "Completed"
      ];

      foreach($orders as $order) {
        $new_data = [];

        $delivery_type = $order['shipping_lines'][0]["method_title"];

        $new_data["number"] = $order["number"];
        $new_data["created_at"] = $order["date_created"];
        $new_data["delivery_type"] = $delivery_type;

        foreach ($order['meta_data'] as $meta) {
          if ($meta['key'] == "prepare_by") {
            $new_data["prepare_by"] = $meta['value'];
            \Log::info("TEST");
          }
        }

        if (!isset($new_data["prepare_by"])) {
          $new_data["prepare_by"] = "Type a new date.";
        }

        $new_data["delivery_date"] = $order['meta_data'][0]['value'] ? $order['meta_data'][0]['value'] : "None";

        $new_data["delivery_time"] = $order['meta_data'][1]['value'] ? $order['meta_data'][1]['value'] : "None";
        if (explode(" ", $new_data["delivery_time"])[0] !== "Between") {
          $new_data["delivery_time"] = "None";
        }

        if ($order['status'] == "processing") {
          $new_data["status"] = 1;
        } elseif ($order['status'] == "completed") {
          $new_data["status"] = 2;
        }

        $new_data["packing_slip"] = '<a href="/receipt/' . $new_data["number"] . '">Print</a>';

        $data[] = $new_data;
      }

      return $data;
    }

    public function statuses() {
      $statuses = [];

      $statuses[] = [
        "value" => 1,
        "text" => "Processing"
      ];

      $statuses[] = [
        "value" => 2,
        "text" => "Completed"
      ];

      return $statuses;
    }
}
