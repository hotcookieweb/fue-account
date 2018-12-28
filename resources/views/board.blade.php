@extends('layouts.app')

@section('content')
	<div class="container">
		<table data-toggle="table" data-search="true" data-url="/data/board" data-editable-emptytext="..." data-editable-url="/test">
			<thead>
				<tr>
					<th data-sortable="true" data-field="number" data-formatter="format_link">Order #</th>
					<th data-sortable="true" data-field="created_at">Created On</th>
					<th data-sortable="true" data-field="delivery_type">Delivery Type</th>
					<th data-sortable="true" data-field="prepare_by">Prepare By</th>
					<th data-sortable="true" data-field="delivery_date">Delivery Date</th>
					<th data-sortable="true" data-field="delivery_time">Delivery Time</th>
					<th data-editable-type="select" data-editable="true" data-field="status" data-editable-field="status" data-editable-source="/data/statuses">Status</th>
					<th data-field="packing_slip">Packing Slip</th>
				</tr>
			</thead>
		</table>
	</div>

	<script>
		function format_link(value, row, index, field) {
			return '<a href="/orders/' + value + '">' + value + '</a>';
		}
	</script>
@endsection
