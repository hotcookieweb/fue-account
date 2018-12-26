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

                      <b>Delivery Date</b>: ({{ $order['meta_data'][0]['value'] }})<br>
                      <b>Delivery Time</b>: ({{ $order['meta_data'][1]['value'] }})<br>

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
                              <td>{{ $item['name'] }}</td>
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
