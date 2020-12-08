<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardCtr extends Controller
{
    public function index()
    {
        if(session()->get('position') == 'owner'){
           
        }
        else{
            dd('nyaa no no no!');
        }
        return view('/dashboard');
    }
}
