<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;

class BoardController extends Controller
{
    public function board() {
      $params = [
  			'status' => 'processing',
        'per_page' => 100,
        'orderby' => 'ready_date'
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

        if (count($order['shipping_lines']) == 0) {
          continue;
        }

        $delivery_type = $order['shipping_lines'][0]["method_title"];

        $new_data["number"] = $order["number"];
        $new_data["created_at"] = \Carbon\Carbon::parse($order["date_created"])->toDayDateTimeString();
        $new_data["delivery_type"] = $delivery_type;

        // Ready Type, Ready Date, Ready Time

        foreach ($order['meta_data'] as $meta) {
          if ($meta['key'] == "ready_type") {
            $new_data["ready_type"] = $meta['value'];
          }
        }

        if (!isset($new_data["ready_type"])) {
          $new_data["ready_type"] = "???";
        }

        foreach ($order['meta_data'] as $md) {
          if ($md["key"] == "ready_date") {
            $new_data["ready_date"] = $md["value"];
          }

          if ($md["key"] == "ready_time") {
            $new_data["ready_time"] = $md["value"];
          }
        }

        // if (substr($new_data["delivery_time"], 0, 4) == "ccof") {
        //   $new_data["delivery_time"] = "None";
        // }

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
