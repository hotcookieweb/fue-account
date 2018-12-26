@extends('layouts.app')

@section('content')
	<link rel="stylesheet" href="/css/style.css">

	<div class="row board">
		<div class="col-lg-2">
			<h3>unknown</h3>
			<ul>
				@foreach($unknown as $order)
					<li>
						<i>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</i>
					</li>
				@endforeach
			</ul>
		</div>

		<div class="col-lg-2">
			<h3>Upcoming</h3>

			<ul>
				@foreach($upcoming as $order)
					<li>
						<i>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</i>
					</li>
				@endforeach
			</ul>

			{{-- <ul>
				<li class="board-list-item">
					<div class="board-order-number board-item">#1337</div>
					<div class="board-prepare-by board-item board-red">11AM</div>
					<div class="board-item-count board-item"><i class="fa fa-list" aria-hidden="true"></i> 25</div>
					<div class="board-total-price board-item">$450.00</div>
				</li>
			</ul> --}}
		</div>

		<div class="col-lg-2">
			<h3>Prepare Today</h3>

			<ul>
				@foreach($prepare_today as $order)
					<li>
						<i>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</i>
					</li>
				@endforeach
			</ul>
		</div>

		<div class="col-lg-2">
			<h3>Ship Today</h3>

			<ul>
				@foreach($ship_today as $order)
					<li>
						<i>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</i>
					</li>
				@endforeach
			</ul>
		</div>

		<div class="col-lg-2">
			<h3>Shipped</h3>

			<p class="board-number">{{ $total_completed }}</p>
		</div>
	</div>
@endsection
