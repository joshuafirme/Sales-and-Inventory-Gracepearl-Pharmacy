<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginCtr extends Controller
{
    public function index(){
        return view('/login-backend');
    }
}
