<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FEHomeController extends Controller
{
    //
    public function index()
    {
        return view('home');
    }

    public function bestaand()
    {
        return view('bestaand');
    }

    public function nieuwbouw()
    {
        return view('nieuwbouw');
    }
    public function projecten()
    {
        return view('projecten');
    }
}
