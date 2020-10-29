<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardCtr extends Controller
{
    public function index()
    {
        return view('/dashboard');
    }
}
