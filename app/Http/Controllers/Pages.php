<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Pages extends Controller
{
    public function index(){
   
        return view('/layouts/404');
    }
}
