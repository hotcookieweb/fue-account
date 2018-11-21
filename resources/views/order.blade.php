@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<p>
						@if($order)
							<h2>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</h2>
							<i>Created on </i><b>{{ date("F jS Y", strtotime($order['number'])) }}</b><br>
							<h3>Status ({{ $order['status'] }})</h3>

							<br><br>

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
											<th scope="row">{{ $i }}</th>
											<td>{{ $item['name'] }}</td>
											<td>${{ $item['price'] }}</td>
											<td>{{ $item['quantity'] }}</td>
											<td>${{ $item['total'] }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						@endif
					</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
