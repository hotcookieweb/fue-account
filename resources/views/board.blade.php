@extends('layouts.app')

@section('content')
	<div class="container">
		<table data-toggle="table" data-search="true" data-url="/data/board">
			<thead>
				<tr>
					<th data-sortable="true" data-field="number">Order #</th>
					<th data-sortable="true" data-field="created_at">Created On</th>
					<th data-sortable="true" data-field="delivery_type">Delivery Type</th>
					<th data-sortable="true" data-field="prepare_by">Prepare By</th>
					<th data-sortable="true" data-field="delivery_date">Delivery Date</th>
					<th data-sortable="true" data-field="delivery_time">Delivery Time</th>
					<th data-sortable="true" data-field="status">Status</th>
					<th data-field="packing_slip">Packing Slip</th>
					<th data-field="edit">Edit</th>
				</tr>
			</thead>
		</table>
	</div>
@endsection
