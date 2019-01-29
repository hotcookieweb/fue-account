@extends('layouts.app')

@section('content')
  <div class="container">
    <h1>Manage Users</h1>

    @if(count($users) > 0)
      @foreach($users as $u)
        @if($u->email == Auth::user()->email)
          <b>{{ $u->name }}</b> | <i>This is you.</i><br>
        @else
          <b>{{ $u->name }}</b> | <a href="/manage/users/delete/{{ $u->id }}">delete</a><br>
        @endif
      @endforeach
    @else
      <p>There are no users currently. You shouldn't be seeing this.</p>
    @endif

    <hr>

    <h2>Create User</h2>

    <form action="/manage/users/create" method="POST">
      @csrf

      Name <input type="text" name="name"><br>
      Email <input type="email" name="email"><br>
      Password <input type="password" name="password"><br>

      <br><button type="submit">Create</button>
    </form>
  </div>
@endsection
