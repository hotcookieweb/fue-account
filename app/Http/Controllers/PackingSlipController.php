<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PackingSlipController extends Controller
{
  public function download($order_number) {
    $pdf = PDF::loadView('pdf.slip', []);
    return $pdf->download('test.pdf');
  }
}
