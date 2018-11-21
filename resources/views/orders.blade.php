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

                    You are logged in!<br>

					<p>
						@foreach($orders as $order)
							<p>
								<a href="/orders/{{ $order['id'] }}">
									<i>#{{ $order['number'] }} {{ $order['billing']['first_name'] }} {{ $order['billing']['last_name'] }}</i> |
									<b> {{ date("F jS Y", strtotime($order['number'])) }}</b> |
									<i> {{ $order['status'] }}</i> |
									<b> ${{ $order['total'] }}</b>
								</a>
							</p>
						@endforeach
					</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
