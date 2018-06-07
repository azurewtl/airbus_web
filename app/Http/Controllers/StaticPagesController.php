<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPagesController extends Controller
{
    public function table()
    {
        return view('static_pages/table');
    }
}
