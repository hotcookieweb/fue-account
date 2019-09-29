<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hot Cookie Kitchen') }}</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.css">
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="icon" href="/apple-touch-icon.png">



    <script src="https://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.12.2/bootstrap-table.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script src="/js/bootstrap-table-editable.js"></script>


</head>
<body>

  <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li><a href="/dashboard">Home</a></li>
              {{-- <li><a href="/orders">Orders</a></li>
              <li><a href="/board">Board</a></li> --}}
            </ul>
            <ul class="nav navbar-nav navbar-right">
              @if(Auth::check())
                <li><a href="/manage/users">Manage Users</a></li>
                <li><a href="/logout">Logout</a></li>
              @else
                <li><a href="/login">Login</a></li>
              @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </nav>


  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/dashboard">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/orders">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/board">Board</a>
          </li>
        </ul>
        {{-- <form class="form-inline my-2 my-md-0">
          <input class="form-control" type="text" placeholder="Search">
        </form> --}}
        <ul class="navbar-nav ml-auto">
          @if(Auth::check())
            <li class="nav-item">
              <form class="form-inline" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="nav-link" style="background: none; border: none;" type="submit">Logout</button>
              </form>
            </li>
          @else
            <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
            </li>
          @endif
        </ul>
      </div>
    </nav>

    <br>

    <div class="row">
      <div class="col-md-12">
        @yield('content')
      </div>
    </div>

    <script src="https://unpkg.com/bootstrap-table@1.15.4/dist/bootstrap-table.min.js"></script>
</body>
</html>
