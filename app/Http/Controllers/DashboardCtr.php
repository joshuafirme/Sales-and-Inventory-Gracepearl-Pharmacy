<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardCtr extends Controller
{

    private $table_emp = "tblemployee";

    public function __construct()
    {
     
    }

    public function index(){
          $this->isLoggedIn();

        return view('/dashboard');
    }

    public function isLoggedIn(){
        if(session()->get('is-login') !== 'yes'){
   
           return redirect()->to('/admin-login')->send();
        }
    }

}
