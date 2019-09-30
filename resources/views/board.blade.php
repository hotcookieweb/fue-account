@extends('layouts.app')

@section('content')
	<audio id="new_order_alert" src="/new_order_alert.wav" preload="auto"></audio>

	<div class="container">
		<a href="" style="font-size: 18px; color: white; background-color: #0808FF; padding: 5px; border-radius: 4px;">Refresh</a>
		<table id="table" data-toggle="table" data-search="true" data-url="/data/board" data-editable-emptytext="..." data-editable-url="/data/board" data-id-field="number">
			<thead>
				<tr>
					<th data-sortable="true" data-field="number" data-formatter="format_link">Order #</th>
					<th data-sortable="true" data-field="created_at">Created On</th>
					<th data-sortable="true" data-field="delivery_type">Delivery Type</th>
					<th data-sortable="true" data-editable="true" data-field="prepare_by" data-editable-field="status">Prepare By</th>
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

		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

		// $.fn.editable({
		// 	url:'/data/board',
		// 	params: function(params){
		// 		params.pk = $(this).attr('data-pk');
		// 		return params;
		// 	},
		// 	success:function(response,value){
		// 		console.log("test");
		// 	}
		// });
		current_total_rows = -1;

		setInterval(function() {
			current_total_rows = total_rows;
			console.log("current total rows:", current_total_rows);

			$("#table").bootstrapTable('refresh');
		}, 20000)

		$("#table").on('load-success.bs.table', function() {
			total_rows = $('#table').bootstrapTable('getData').length;
			console.log("total rows:", total_rows);

			if (current_total_rows != -1) {
				if (current_total_rows < total_rows) {
					document.getElementById('new_order_alert').play();

					var uri = $($('#table').bootstrapTable('getData')[0].packing_slip).attr('href');

					console.log("A new order has just came in.");

					setTimeout(function() {
						window.location.href = uri;
					}, 60000);
				} else {
					console.log('same')
				}
			}
		})

	</script>

@endsection
