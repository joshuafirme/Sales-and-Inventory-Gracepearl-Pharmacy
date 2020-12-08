<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Input;
use App\AdminLogin;
use Illuminate\Http\Request;

class AdminLoginCtr extends Controller
{
    public function index(){

        return view('/admin-login');
    }

    public function login(){

        $username = Input::input('username');
        $password = Input::input('password');

        session()->get('admin-username');
        session()->put('admin-username', $username);

        if($username == 'admin' && $password == 'admin'){
            return 'success';
        }
        else{
            return 'invalid';
        }
    }
}
