<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;

class BoardController extends Controller
{
    public function board() {
      $params = [
  			'status' => 'processing',
        'per_page' => 100
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

        // foreach ($order['meta_data'] as $meta) {
        //   if ($meta['key'] == "prepare_by") {
        //     $new_data["prepare_by"] = $meta['value'];
        //     \Log::info("TEST");
        //   }
        // }

        if (!isset($new_data["prepare_by"])) {
          $new_data["prepare_by"] = "Type a new date.";
        }

        // foreach ($order['meta_data'] as $md) {
        //   if ($md["key"] == "Delivery or Pickup Date") {
        //     $new_data["delivery_date"] = $md["value"];
        //   }
        //
        //   if ($md["key"] == "Time Slot") {
        //     $new_data["delivery_time"] = $md["value"];
        //   }
        // }

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
