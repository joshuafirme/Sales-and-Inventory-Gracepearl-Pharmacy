<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerLogin;
use Illuminate\Http\Request;

class CustomerLoginCtr extends Controller
{
    private $table_emp = "tblemployee";

    public function index(){
      //  dd(session()->get('emp-username') . session()->get('is-login'));
        return view('/customer-login');
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
            session()->get('customer-username');
            session()->put('customer-username', $username);
            session()->put('is-customer-login', 'yes');
            return 'success';
        }
        else{
            return 'invalid';
        }
    }

    public function logout(){
        session()->forget('customer-username');
        session()->forget('is-customer-login');
    }
}
