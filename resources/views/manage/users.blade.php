@extends('layouts.app')

@section('content')
@if (Auth::user()->email != 'admin')
  <h1>Not allowed to manage users</h1>
@else
  <div class="container">
    <h2>Manage Users</h2>
    @if(count($users) > 0)
      @foreach($users as $u)
        @if($u->email == Auth::user()->email)
          <b>{{ $u->name }}</b> | <i>This is you.</i><br><br>
        @else
          <b>{{ $u->name }}</b>
          <form action="/manage/users/delete" method="POST">
              @csrf
              <button type="submit">Delete User</button><input id="user_id" name="user_id" type="hidden" value="{{ $u->id }}">
          </form>
          <form action="/manage/users/passreset" method="POST">
              @csrf
              <button type="submit">Reset Password</button><input type="password" id="password" name="password" value="new password"><input id="user_id" name="user_id" type="hidden" value="{{ $u->id }}">
          </form><br>
        @endif
      @endforeach
    @else
      <p>There are no users currently. You shouldn't be seeing this.</p>
    @endif

    <hr>

    <h2>Create User</h2>

    <form action="/manage/users/create" method="POST">
      @csrf
      User ID <input type="text" name="email"><br>
      User Name <input type="text" name="name"><br>
      Password <input type="password" name="password"><br>
      <div style="vertical-align: top;display: inline-block">
      <span style="vertical-align:text-top">Zones</span>
      </div>
      <div style="padding-left: 50px; vertical-align: top;display: inline-block;">
        <input type="checkbox" id="other_zone" name="zones[]" value="other">
        <label for="other_zone">unknown</label><br>
        <input type="checkbox" id="national_zone" name="zones[]" value="national">
        <label for="national_zone">national</label><br>
        <input type="checkbox" id="castro_sf_zone" name="zones[]" value="castro-sf">
        <label for="castro_sf_zone">castro-sf</label><br>
        <input type="checkbox" id="polk_sf_zone" name="zones[]" value="polk-sf">
        <label for="polk_sf_zone">polk-sf</label><br>
      </div>

      <br><button type="submit">Create</button>
    </form>
  </div>
@endif
@endsection
