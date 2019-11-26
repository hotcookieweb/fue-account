<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Woocommerce;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

  	public function board()
  	{
  		  return view('board');
  	}

    public function index()
    {
      return redirect("/dashboard");
    }

    public function logout() {
      \Auth::logout();
      return redirect("/login");
    }
}
