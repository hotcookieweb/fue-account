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
          						<!-- Graphs -->
                      <h2><?php echo $all; ?> Orders</h2>
                      <canvas id="dashboard-order-chart" width="150" height="150" style="width: 150px; height: 150px;"></canvas>
                      <!-- End Graphs -->
          					</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js"></script>
<script>
  jQuery(document).ready(function() {
    var ctx = document.getElementById("dashboard-order-chart").getContext('2d');

    var data = {
      labels: ["Processing", "Completed"],
      datasets: [
        {
          data: [
            <?php echo $processing . "," . $completed; ?>
          ],
          backgroundColor: [
            "rgb(255, 100, 100)",
            "rgb(100, 255, 100)"
          ],
          label: "<?php echo $all; ?> Orders"
        }
      ]
    };

    var options = {
      responsive: true,
      maintainAspectRatio: true,
    };

    var orderChart = new Chart(ctx, {
      type: 'pie',
      data: data,
      options: options
    });
  });
</script>
@endsection
