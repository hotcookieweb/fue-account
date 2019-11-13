@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Order #: {{ $order['number'] }}</h4>
          </div>
          <div class="card-body">
            Date created: {{ date("F d, Y", strtotime($order['date_created'])) }}<br>
            Order status: {{ $order['status'] }}<br>
            {{ $order['shipping_lines']['0']['method_title'] }}: {{ $order['shipping_lines']['0']['total']}}<br>
            @foreach ($order['meta_data'] as $md)
              @if ($md["key"] == "ready_date")
                Ready date: {{ $md["value"] }}<br>
              @endif
              @if ($md["key"] == "ready_time")
                Ready time: {{ $md["value"] }}<br>
              @endif
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Billing Address</h4>
          </div>
          <div class="card-body">
            {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}<br>
            {{ $order['billing']['address_1'] }}<br>
            @if($order['billing']['address_2'])
              {{ $order['billing']['address_2'] }}<br>
            @endif
            {{ $order['billing']['city'] }}, {{ $order['billing']['state'] }} {{ $order['billing']['postcode'] }} {{ $order['billing']['country'] }}<br>
            Phone # {{ $order['billing']['phone'] }}<br>
            Email - <i>{{ $order['billing']['email'] }}</i><br>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Shipping Address</h4>
          </div>
          <div class="card-body">
            {{ $order['shipping']['first_name'] }} {{ $order['shipping']['last_name'] }}<br>
            {{ $order['shipping']['address_1'] }}<br>
            @if($order['shipping']['address_2'])
              {{ $order['shipping']['address_2'] }}<br>
            @endif
            {{ $order['shipping']['city'] }}, {{ $order['shipping']['state'] }} {{ $order['shipping']['postcode'] }} {{ $order['shipping']['country'] }}<br>
          </div>
        </div>
      </div>
    </div>
    <div class="row justify-content-left">
      <div class="card-header">
        <h4 class="card-title">Items</h4>
      </div>
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
              <td>
                {{ $item["name"] }}<br>
                @foreach ($item["meta_data"] as $md)
                  @php
                  $key = str_replace("pa_", "", $md["key"]); // meta data passed as slugs, not names
                  @endphp
                  {{ $key }}: {{ $md["value"] }}<br>
                @endforeach
              </td>
              <td>${{ $item['price'] }}</td>
              <td>{{ $item['quantity'] }}</td>
              <td>${{ $item['total'] }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="row justify-content-left">
      @if($order['customer_note'])
        <div class="card-header">
          <h4 class="card-title">Customer Note:</h4>
        </div>
        <div class="card-body">
          {{ $order['customer_note'] }}
        </div>
      @endif
    </div>
  </div>
</div>
@endsection
