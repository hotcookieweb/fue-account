@extends('layouts.app')

@section('content')
  <form action="/manage/users/update_zones" method="POST">
    @csrf
    <div style="padding-left: 10px;vertical-align: top;display: inline-block">
    <span style="font-weight: bold; vertical-align:text-top">Zones</span>
    </div>
    <div style="padding-left: 20px; vertical-align: top;display: inline-block;">
      <input type="checkbox" id="other_zone" name="zones[]" value="other" @if (in_array('other', $zones)) checked @endif>
      <label for="other_zone">unknown</label><br>
      <input type="checkbox" id="national_zone" name="zones[]" value="national" @if (in_array('national', $zones)) checked @endif>
      <label for="national_zone">national</label><br>
      <input type="checkbox" id="castro_sf_zone" name="zones[]" value="castro-sf" @if (in_array('castro-sf', $zones)) checked @endif>
      <label for="castro_sf_zone">castro-sf</label><br>
      <input type="checkbox" id="polk_sf_zone" name="zones[]" value="polk-sf" @if (in_array('polk-sf', $zones)) checked @endif>
      <label for="polk_sf_zone">polk-sf</label><br>
    </div>
    <div style="padding-left: 20px; vertical-align: top;display: inline-block;">
      <button type="submit">Change</button>
    </div>
  </form>
@endsection
