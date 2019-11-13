<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;
class PackingSlipController extends Controller
{
  public function print($order_number) {
    $order = Woocommerce::get("orders/$order_number");

    $url = env("PRINTER_URL");

    return view("receipt")->with([
      "order_number" => $order_number,
      "order" => $order,
      "url" => $url
    ]);
  }
}
?>
