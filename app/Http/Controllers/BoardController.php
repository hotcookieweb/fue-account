<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Woocommerce;

class BoardController extends Controller
{
  public function board() {
    $params = [
      'status' => array ('processing','printed','done'),
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
        $new_data["class"] = "table-light";

      } elseif ($order['status'] == "printed") {
        $new_data["status"] = 2;
        $new_data["class"] = "table-success";
        } elseif ($order['status'] == "done") {
          $new_data["status"] = 3;
          $new_data["class"] = "table-warning";
      } else {
          $new_data["status"] = 4;
          $new_data["class"] = "table-secondary";
      }

      $new_data["packing_slip"] = '<a href="/receipt/' . $order['status'] . '/' . $order['number'] . '">Print</a>';

      if ($ready_sort <= $now) {
        $new_data["class"] = "table-danger";
      }
      else if ($ready_date != $today) {
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
      "text" => "Printed"
    ];

    $statuses[] = [
      "value" => 3,
      "text" => "Done"
    ];
    if (Auth::user()->email == 'admin') {
      $statuses[] = [
        "value" => 4,
        "text" => "Completed"
      ];
    }

    return $statuses;
  }

  public function update(Request $request) {
    if ($request->input("name") == "status") {

      if ($request->input("value") == "1") {
        $status = "processing";
      } elseif ($request->input("value") == "2") {
        $status = "printed";
      } elseif ($request->input("value") == "3") {
          $status = "done";
      } elseif ($request->input("value") == "4") {
          $status = "completed";
      }

      $data = [
        "status" => $status
      ];

      $number = $request->input("pk");
      try {
        $newproduct = Woocommerce::put("orders/$number", $data);;
      } catch(HttpClientException $e) {
        return("Woocommerce error");
      }
    }
    elseif ($request->input("name") == "prepare_by") {
      Log::info($request->input());
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

    return "done";
  }
}
