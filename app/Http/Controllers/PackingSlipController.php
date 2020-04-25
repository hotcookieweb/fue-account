<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;
class PackingSlipController extends Controller
{
  public function print($status, $order_number) {
    if ($status == 'processing') {
      $order = Woocommerce::put("orders/$order_number", [ "status" => "printed" ]);
    }
    else {
      $order = Woocommerce::get("orders/$order_number");
    }
    $url = env("PRINTER_URL");
    return view("receipt")->with([
      "order_number" => $order_number,
      "order" => $order,
      "url" => $url
    ]);
  }
}
?>
