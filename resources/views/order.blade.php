@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }} ({{ $order['status'] }})</div>

                <div class="card-body">
                  <p>
                    @if($order)
                      <i>Created </i><b>{{ date("F d, Y", strtotime($order['date_created'])) }}</b><br>

                      <br>

                      <?php
                      $delivery_date = "None";
                      $delivery_time = "None";

                      foreach ($order['meta_data'] as $md) {
                        if ($md["key"] == "Delivery Date") {
                          $delivery_date = $md["value"];
                        }

                        if ($md["key"] == "Delivery Time") {
                          $delivery_time = $md["value"];
                        }
                      }
                      ?>

                      <b>Delivery Date</b>: {{ $delivery_date }}<br>
                      <b>Delivery Time</b>: {{ $delivery_time }}<br>

                      <br>

                      <div class="row">
                        <div class="col-lg-6">
                          <h3>Billing</h3>

                          <p>
                            {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}<br>
                            Phone # {{ $order['billing']['phone'] }}<br>
                            Email - <i>{{ $order['billing']['email'] }}</i><br>
                            {{ $order['billing']['address_1'] }}<br>
                            @if($order['billing']['address_2'])
                              {{ $order['billing']['address_2'] }}<br>
                            @endif
                            {{ $order['billing']['city'] }}, {{ $order['billing']['state'] }} {{ $order['billing']['postcode'] }}<br>
                            {{ $order['billing']['country'] }}
                          </p>
                        </div>

                        <div class="col-lg-6">
                          <h3>Shipping</h3>

                          <p>
                            {{ $order['shipping']['first_name'] }} {{ $order['shipping']['last_name'] }}<br>
                            {{ $order['shipping']['address_1'] }}<br>
                            @if($order['shipping']['address_2'])
                              {{ $order['shipping']['address_2'] }}<br>
                            @endif
                            {{ $order['shipping']['city'] }}, {{ $order['shipping']['state'] }} {{ $order['shipping']['postcode'] }}<br>
                            {{ $order['shipping']['country'] }}
                          </p>
                        </div>
                      </div>

                      <br>

                      <h2>Items</h2>
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Qty</th>
                            <th scope="col">Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($order['line_items'] as $i=>$item)
                            <tr>
                              <th scope="row">{{ $i+1 }}</th>
                              <?php
                                $meta = "";

                                foreach ($item["meta_data"] as $md) {
                                  if ($md["key"] == "pa_cookie-flavor") {
                                    $key = "Cookie Flavor";
                                  } else if ($md["key"] == "pa_chocolate-type") {
                                    $key = "Chocolate Type";
                                  } else if ($md["key"] == "pa_delivery-shipping-options") {
                                    $key = "Delivery & Shipping Options";
                                  } else if ($md["key"] == "pa_fabrication") {
                                    $key = "Fabrication";
                                  } else if ($md["key"] == "pa_features") {
                                    $key = "Features";
                                  } else if ($md["key"] == "pa_ingredients") {
                                    $key = "Ingredients";
                                  } else if ($md["key"] == "pa_size") {
                                    $key = "Size";
                                  } else if ($md["key"] == "pa_toppings") {
                                    $key = "Toppings";
                                  } else {
                                    $key = $md["key"];
                                  }
                                  $meta = $meta . "<b>" . $key . "</b> - " . $md["value"] . "<br>";
                                }
                              ?>
                              <td>
                                {{ $item["name"] }}<br>
                                {!! $meta !!}
                              </td>
                              <td>${{ $item['price'] }}</td>
                              <td>{{ $item['quantity'] }}</td>
                              <td>${{ $item['total'] }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <h5>Shipping</h5>
                      @foreach($order['shipping_lines'] as $line)
                        <ul>
                          <li>{{ $line['method_title'] }} - ${{ $line['total']}}</li>
                        </ul>
                      @endforeach

                      <br>

                      <h3>Customer Note</h3>
                        @if($order['customer_note'])
                          <p>{{ $order['customer_note'] }}</p>
                        @else
                          <p>The customer did not leave a note.</p>
                        @endif
                    @endif
                  </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
