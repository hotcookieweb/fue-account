<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class ManageUserController extends Controller
{
  public function __construct() {
    $this->middleware('auth');
  }

  public function manage_users() {
    $users = User::all();

    return view('manage.users')->with([
      "users" => $users
    ]);
  }

  public function delete(Request $request) {
    $user = User::find($request->input('user_id'));
    if ($user) {
      $user->delete();
    }
    return redirect("/manage/users");
  }

  public function passreset(Request $request) {
    $user = User::find($request->input('user_id'));
    if ($user) {
      $user->password = Hash::make($request->input('password'));
      $user->save();
    }
    return redirect("/manage/users");
  }

  public function create(Request $request) {
    $found = User::where('id', $request->input('id'))->first();

    if (!$found) {
      $data = [
        "email"=> $request->input('email'),
        "name" => $request->input('name'),
        "password" => $request->input('password'),
        "zones" => $request->input('zones'),
      ];

      User::create([
        'email' => $data['email'],
        'name' => $data['name'],
        'password' => Hash::make($data['password']),
        'zones' => serialize($data['zones'])
      ]);
    }

    return redirect("/manage/users");
  }

  public function manage_zones() {
    $user = Auth::user();
    $zones = unserialize($user->zones);
    if (!$zones) {
      $zones = [""];
    }

		return view("/manage/zones")->with('zones', $zones);
  }

  public function update_zones(Request $request) {
    $user = Auth::user();

    $user->zones = serialize($request->input('zones'));
    $user->save();

    return redirect("/dashboard");
  }
}
