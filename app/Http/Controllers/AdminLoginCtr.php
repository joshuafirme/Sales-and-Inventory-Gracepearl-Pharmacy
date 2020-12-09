<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Input;
use App\AdminLogin;
use Illuminate\Http\Request;

class AdminLoginCtr extends Controller
{
    private $table_emp = "tblemployee";

    public function index(){
      //  dd(session()->get('emp-username') . session()->get('is-login'));
        return view('/admin-login');
    }

    public function login(){

        $username = Input::input('username');
        $password = Input::input('password');

        $emp = DB::table($this->table_emp)
        ->where([
            ['username', $username],
            ['password', $password]
        ])
        ->get();
        
        

        if($emp->count() > 0){
            session()->get('emp-username');
            session()->put('emp-username', $username);
            session()->put('is-login', 'yes');
            return 'success';
        }
        else{
            return 'invalid';
        }
    }

    public function logout(){
        session()->forget('emp-username');
        session()->forget('is-login');
    }
    
}
