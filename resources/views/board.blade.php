@extends('layouts.app')

@section('content')
	<link rel="stylesheet" href="/css/style.css">

	<div class="row board">
		<div class="col-lg-2">
			<h3>unknown</h3>
			<ul>
				@foreach($orders as $order)
					<li>
						<i>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</i>
					</li>
				@endforeach
			</ul>
		</div>

		<div class="col-lg-2">
			<h3>Upcoming</h3>
			<p></p>
		</div>

		<div class="col-lg-2">
			<h3>Prepare Today</h3>
			<p></p>
		</div>

		<div class="col-lg-2">
			<h3>Ship Today</h3>
			<p></p>
		</div>

		<div class="col-lg-2">
			<h3>Shipped</h3>
			<p></p>
		</div>
	</div>
@endsection
