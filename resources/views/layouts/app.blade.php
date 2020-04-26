<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hot Cookie Kitchen') }}</title>

    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/bootstrap-table.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>


    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="/apple-touch-icon.png">

    <script src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/bootstrap-table.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="/js/bootstrap-table-editable.js"></script>
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active" style="padding-left: 20px">
            <a class="nav-link" href="/dashboard">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active" style="padding-left: 20px">
            <a class="nav-link" href="/manage/zones">Zones <span class="sr-only">(current)</span></a>
          </li>
          @if(Auth::check())
            <li class="nav-item" style="padding-left: 20px">
              <a class="nav-link active" href="/logout">Logout <span class="sr-only">(current)</span></a>
            </li>
          @endif
          <li class="nav" style="padding-left: 20px;">
            <input id="turn-on-audio" class="nav-button" type="button" style="background-color: #f44336; color: white" value="Turn order alert on" onclick="play_order_alert()">
            <script>
              const new_order_alert = new Audio("/new_order_alert.wav")
              function play_order_alert() {
                new_order_alert.play();
                var onbutton = document.getElementById("turn-on-audio");
                onbutton.value="Order alert on"
                onbutton.style.backgroundColor="#e7e7e7"
                onbutton.style.color="black";
              }
            </script>
          </li>
        </ul>
      </div>
    </nav>

    <br>

    <div class="row">
      <div class="col-md-12">
        @yield('content')
      </div>
    </div>
</body>
</html>
