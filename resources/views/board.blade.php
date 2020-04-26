@extends('layouts.app')

@section('content')
	<div class="container">
		{{-- <a href="" style="font-size: 18px; color: white; background-color: #0808FF; padding: 5px; border-radius: 4px;">Refresh</a> --}}
		<table id="table"
			data-sort-name="ready_date"
			data-sort-order="asc"
			data-toggle="table"
			data-search="false"
			data-url="/data/board"
			data-editable-emptytext="..."
			data-editable-url="/data/board"
			data-id-field="number"
			data-row-style="row_style">
			<thead class="thead-dark">
				<tr>
					<th data-sortable="true" data-field="number" data-formatter="format_link">Order #</th>
					<th data-sortable="true" data-field="shipping_zone">Ship Zone</th>
					<th data-sortable="true" data-field="delivery_type">Delivery Type</th>
					<th data-sortable="true" data-field="ready_date">Ready Date</th>  <!-- should search on ready_sort data -->
					<th data-sortable="true" data-field="ready_time">Ready Time</th>  <!-- should search on ready_sort data -->
					<th data-editable-type="select" data-editable="true" data-field="status" data-editable-field="status" data-editable-source="/data/statuses" class="mdb-select md-form">Status</th>
					<th data-field="packing_slip">Packing Slip</th>
			</thead>
		</table>
	</div>

	<script>
		function row_style(row, index) {
			return {
				classes: row["class"]
			}
		}
		function format_link(value, row, index, field) {
			return '<a href="/orders/' + value + '">' + value + '</a>';
		}

		$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

		$.fn.editable({
			url:'/data/board',
			params: function(params){
				params.pk = $(this).attr('data-pk');
				return params;
			},
			success:function(response,newvalue){
				return newvalue;
			},
			error: function(response, newValue) {
    		if(response.status === 500) {
        	return 'Service unavailable. Please try later.';
    		} else {
        	return response.responseText;
    		}
			},
		});

		current_total_rows = -1;

		setInterval(function() {
			current_total_rows = total_rows;
			console.log("current total rows:", current_total_rows);

			$("#table").bootstrapTable('refresh');
		}, 60000)

		$("#table").on('load-success.bs.table', function() {
			total_rows = $('#table').bootstrapTable('getData').length;
			console.log("total rows:", total_rows);

			if (current_total_rows != -1) {
				if (current_total_rows < total_rows) {
					new_order_alert.play();
					console.log("A new order has just came in.");
				} else {
					console.log('same')
				}
			}
		})

		var isUnlocked = false;
		function unlock() {

			if(isIOS || this.unlocked)
				return;

			// create empty buffer and play it
			var source = "/new_order_alert.wav";
			source.buffer = buffer;
			source.connect(myContext.destination);
			source.noteOn(0);

			// by checking the play state after some time, we know if we're really unlocked
			setTimeout(function() {
				if((source.playbackState === source.PLAYING_STATE || source.playbackState === source.FINISHED_STATE)) {
					isUnlocked = true;
				}
			}, 0);
		}
	</script>

@endsection
