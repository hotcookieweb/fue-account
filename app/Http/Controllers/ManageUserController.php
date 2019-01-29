<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;

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

  public function delete($id) {
    $user = User::find($id);

    if ($user) {
      $user->delete();
    }
  }

  public function create(Request $request) {
    $found = User::where('email', $request->input('email'))->first();

    if (!$found) {
      $data = [
        "name" => $request->input('name'),
        "email" => $request->input('email'),
        "password" => $request->input('password')
      ];

      User::create([
          'name' => $data['name'],
          'email' => $data['email'],
          'password' => Hash::make($data['password']),
      ]);
    }

    return redirect("/manage/users");
  }
}
