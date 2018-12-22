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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $completed = count(Woocommerce::get('orders', ['status' => 'completed']));
        $processing = count(Woocommerce::get('orders', ['status' => 'processing']));
        $all = $processing + $completed;

        return view('dashboard')->with([
          "all" => $all,
          "completed" => $completed,
          "processing" => $processing
        ]);
    }

  	public function board()
  	{
  		  return view('board');
  	}

    public function index()
    {
      return redirect("/dashboard");
    }
}
