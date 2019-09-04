<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Woocommerce;

class PackingSlipController extends Controller
{
  public function download($order_number) {
    $order = Woocommerce::get("orders/$order_number");

    $pdf = new Fpdf('P', 'mm', array(80, 1000));
    $pdf->AddPage();

    // logo
    $pdf->Image(public_path() . "/logo.png", 20, 10, 40, 40);

    // company name
    $pdf->SetFont("Courier", "B", 12);
    $pdf->SetY(55);
    $pdf->Cell(0, 3, "Hot Cookie", 0, 0, "C");

    // company address line 1
    $pdf->SetFont("Courier", "", 10);
    $pdf->SetY(60);
    $pdf->Cell(0, 3, "407 Castro St", 0, 0, "C");

    // company address line 2
    $pdf->SetFont("Courier", "", 10);
    $pdf->SetY(63);
    $pdf->Cell(0, 3, "San Francisco, CA 94114", 0, 0, "C");

    // "PACKING SLIP"
    $pdf->SetFont("Courier", "B", 18);
    $pdf->SetY(70);
    $pdf->Cell(0, 3, "Packing Slip", 0, 0, "C");

    $pdf->SetFont("Courier", "", 10);

    $shipping_x = 10;
    $shipping_y = 80;

    // Shipping name
    $full_name = $order["shipping"]["first_name"] . " " . $order["shipping"]["last_name"];
    $pdf->Text($shipping_x, $shipping_y, $full_name);

    // Shipping company
    if (isset($order["shipping"]["company"])) {
      $company = $order["shipping"]["company"];
      $pdf->Text($shipping_x, $shipping_y+4, $company);
      $shipping_y = $shipping_y + 4;
    }

    // Shipping address 1
    $address_one = $order["shipping"]["address_1"];
    $pdf->Text($shipping_x, $shipping_y+4, $address_one);

    // Shipping address 2
    $shipping_y = $shipping_y + 4;

    if (isset($order["shipping"]["address_2"])) {
      $pdf->Text($shipping_x, $shipping_y, $order["shipping"]["address_2"]);
      $shipping_y = $shipping_y + 4;
    }

    // Shipping city, state zip
    $city = $order["shipping"]["city"];
    $state = $order["shipping"]["state"];
    $postcode = $order["shipping"]["postcode"];
    $location = "$city, $state $postcode";
    $pdf->Text($shipping_x, $shipping_y, $location);

    // Shipping country
    $country = $order["shipping"]["country"];
    $pdf->Text($shipping_x, $shipping_y+4, $country);

    // billing email
    $email = $order["billing"]["email"];
    $pdf->Text($shipping_x, $shipping_y+8, $email);

    // Billing phone number
    $phone = $order["billing"]["phone"];
    $pdf->Text($shipping_x, $shipping_y+12, $phone);

    $total_y = $shipping_y+18;

    // Order number
    $pdf->Text($shipping_x, $total_y, "Order Number: $order_number");

    // Order date
    $order_date = date("F j, Y", strtotime($order["date_created"]));
    $pdf->Text($shipping_x, $total_y+5, "Order Date: $order_date");

    // Shipping method
    $shipping_method = $order["shipping_lines"][0]["method_title"];
    $pdf->Text($shipping_x, $total_y+10, "Shipping Method: $shipping_method");

    // Delivery Time
    if (isset($order["meta_data"][1]["value"])) {
      $delivery_time = $order["meta_data"][1]["value"];
      $pdf->Text($shipping_x, $total_y+15, "Delivery Time: $delivery_time");
      $total_y += 15;
    }

    // line items (product, quantity)
    $items_name_x = 5;
    $items_quantity_x = 65;

    $total_y += 10;

    $pdf->SetFont("Courier", "B", 12);

    $pdf->Text($items_name_x, $total_y, "Product");
    $pdf->Text($items_quantity_x-10, $total_y, "Quantity");

    $pdf->SetFont("Courier", "", 8);

    $items = $order["line_items"];

    foreach($items as $item) {
      $pdf->Text($items_name_x, $total_y+5, $item["name"]);
      $pdf->Text($items_quantity_x, $total_y+5, $item["quantity"]);

      $total_y += 5;
    }

    $page_height = $total_y + 10;

    // Repeat!
    $pdf = new Fpdf('P', 'mm', array(80, $page_height));
    $pdf->AddPage();

    // logo
    $pdf->Image(public_path() . "/logo.png", 20, 10, 40, 40);

    // company name
    $pdf->SetFont("Courier", "B", 12);
    $pdf->SetY(55);
    $pdf->Cell(0, 3, "Hot Cookie", 0, 0, "C");

    // company address line 1
    $pdf->SetFont("Courier", "", 10);
    $pdf->SetY(60);
    $pdf->Cell(0, 3, "407 Castro St", 0, 0, "C");

    // company address line 2
    $pdf->SetFont("Courier", "", 10);
    $pdf->SetY(63);
    $pdf->Cell(0, 3, "San Francisco, CA 94114", 0, 0, "C");

    // "PACKING SLIP"
    $pdf->SetFont("Courier", "B", 18);
    $pdf->SetY(70);
    $pdf->Cell(0, 3, "Packing Slip", 0, 0, "C");

    $pdf->SetFont("Courier", "", 10);

    $shipping_x = 10;
    $shipping_y = 80;

    // Shipping name
    $full_name = $order["shipping"]["first_name"] . " " . $order["shipping"]["last_name"];
    $pdf->Text($shipping_x, $shipping_y, $full_name);

    // Shipping company
    if (isset($order["shipping"]["company"])) {
      $company = $order["shipping"]["company"];
      $pdf->Text($shipping_x, $shipping_y+4, $company);
      $shipping_y = $shipping_y + 4;
    }

    // Shipping address 1
    $address_one = $order["shipping"]["address_1"];
    $pdf->Text($shipping_x, $shipping_y+4, $address_one);

    // Shipping address 2
    $shipping_y = $shipping_y + 4;

    if (isset($order["shipping"]["address_2"])) {
      $pdf->Text($shipping_x, $shipping_y, $order["shipping"]["address_2"]);
      $shipping_y = $shipping_y + 4;
    }

    // Shipping city, state zip
    $city = $order["shipping"]["city"];
    $state = $order["shipping"]["state"];
    $postcode = $order["shipping"]["postcode"];
    $location = "$city, $state $postcode";
    $pdf->Text($shipping_x, $shipping_y, $location);

    // Shipping country
    $country = $order["shipping"]["country"];
    $pdf->Text($shipping_x, $shipping_y+4, $country);

    // billing email
    $email = $order["billing"]["email"];
    $pdf->Text($shipping_x, $shipping_y+8, $email);

    // Billing phone number
    $phone = $order["billing"]["phone"];
    $pdf->Text($shipping_x, $shipping_y+12, $phone);

    $total_y = $shipping_y+18;

    // Order number
    $pdf->Text($shipping_x, $total_y, "Order Number: $order_number");

    // Order date
    $order_date = date("F j, Y", strtotime($order["date_created"]));
    $pdf->Text($shipping_x, $total_y+5, "Order Date: $order_date");

    // Shipping method
    $shipping_method = $order["shipping_lines"][0]["method_title"];
    $pdf->Text($shipping_x, $total_y+10, "Shipping Method: $shipping_method");

    // Delivery Time
    if (isset($order["meta_data"][1]["value"])) {
      $delivery_time = $order["meta_data"][1]["value"];
      $pdf->Text($shipping_x, $total_y+15, "Delivery Time: $delivery_time");
      $total_y += 15;
    }

    // line items (product, quantity)
    $items_name_x = 5;
    $items_quantity_x = 65;

    $total_y += 10;

    $pdf->SetFont("Courier", "B", 12);

    $pdf->Text($items_name_x, $total_y, "Product");
    $pdf->Text($items_quantity_x-10, $total_y, "Quantity");

    $pdf->SetFont("Courier", "", 8);

    $items = $order["line_items"];

    foreach($items as $item) {
      $pdf->Text($items_name_x, $total_y+5, $item["name"]);
      $pdf->Text($items_quantity_x, $total_y+5, $item["quantity"]);

      $total_y += 5;
    }


    return $pdf->Output('I');
  }

  public function print($order_number) {
    $order = Woocommerce::get("orders/$order_number");

    $o = [];

    $o["full_name"] = $order["shipping"]["first_name"] . " " . $order["shipping"]["last_name"];

    $o["address_1"] = $order["shipping"]["address_1"];
    $o["address_2"] = $order["shipping"]["address_2"];

    $o["city"] = $order["shipping"]["city"];
    $o["state"] = $order["shipping"]["state"];
    $o["postcode"] = $order["shipping"]["postcode"];
    $city = $o["city"];
    $state = $o["state"];
    $postcode = $o["postcode"];
    $o["location"] = "$city, $state $postcode";

    $o["country"]= $order["shipping"]["country"];
    $o["email"] = $order["billing"]["email"];
    $o["phone"] = $order["billing"]["phone"];

    $o["order_number"] = $order_number;
    $o["order_date"] = date("F j, Y", strtotime($order["date_created"]));

    $o["shipping_method"] = $order["shipping_lines"][0]["method_title"];
    $o["delivery_time"] = $order["meta_data"][1]["value"];

    $o["items"] = $order["line_items"];

    $url = env("PRINTER_URL");

    return redirect("/");

    return view("receipt")->with([
      "order" => $o,
      "url" => $url
    ]);
  }
}
