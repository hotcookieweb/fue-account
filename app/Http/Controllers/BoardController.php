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

      $zones = unserialize(auth()->user()->zones);
      if (in_array ('other', $zones)) {
        $other = true;
      }
      else {
        $other = false;
      }

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

      $now = time()-7*3600;
      $today = date('m/d/Y', $now);

      foreach($orders as $order) {
        $new_data = [];

        $shipping_zone = "";
        $ready_date = "";
        $ready_time = "";
        $ready_sort = "";
        $ready_type = "";

        foreach ($order['meta_data'] as $md) {
          if ($md["key"] == "shipping_zone") {
            $shipping_zone = $md["value"];
          }
          if ($md["key"] == "ready_date") {
            $ready_date = $md["value"];
          }

          if ($md["key"] == "ready_time") {
            $ready_time = $md["value"];
          }

          if ($md["key"] == "ready_sort") {
            $ready_sort = $md["value"];
          }
          if ($md["key"] == "ready_type") {
            $ready_type = $md["value"];
          }
        }

        if (!in_array ( $shipping_zone, $zones )) {
          if (in_array($shipping_zone, ["national", "castro-sf", "polk-sf"]))
            continue;
          if ($other == false)
            continue;
        }

        $new_data["number"] = $order["number"];
        $new_data["shipping_zone"] = $shipping_zone;

        if (count($order['shipping_lines']) != 0) {
          $new_data["delivery_type"] = $order['shipping_lines'][0]["method_title"];
        }
        else {
          $new_data["delivery_type"] = $ready_type;
        }

        $new_data["ready_date"] = '<span style="display:none">' . $ready_sort . '</span>' . $ready_date;
        $new_data["ready_time"] = '<span style="display:none">' . $ready_sort . '</span>' . $ready_time;

        if ($order['status'] == "processing") {
          $new_data["status"] = 1;
        } elseif ($order['status'] == "completed") {
          $new_data["status"] = 2;
        }

        $new_data["packing_slip"] = '<a href="/receipt/' . $new_data["number"] . '">Print</a>';

        if ($ready_sort <= $now) {
          $new_data["class"] = "table-danger";
        }
        else if ($ready_date == $today) {
          $new_data["class"] = "table-light";
        }
        else {
          $new_data["class"] = "table-dark";
        }

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
