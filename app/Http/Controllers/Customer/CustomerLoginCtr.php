<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerLogin;
use Illuminate\Http\Request;
use Socialite;

class CustomerLoginCtr extends Controller
{
    private $tbl_emp = "tblemployee";
    private $tbl_google_id = "tblgoogle_id";

    public function index(){
    
        return view('/customer-login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
   
    public function handleGoogleCallback()
    {
        try {
  
            $user = Socialite::driver('google')->user();
           
            $this->login($user->email, $user->name, $user->avatar);
  
        } catch (Exception $e) {
            return redirect('customer-login/google');
        }
    }

    public function login($google_email, $name, $avatar){

        $finduser =  DB::table($this->tbl_google_id)->where('email', $google_email)->get();   

        if($finduser)
        {
            session()->put('email', $google_email);
            session()->put('name', $name);
            session()->put('avatar', $avatar);
            session()->put('is-customer-logged', 'yes');
            return redirect('/homepage')->send();
        }
        else
        {
            DB::table($this->tbl_google_id)->insert(
                ['email' => $google_email]
            );
            session()->put('email', $google_email);
            session()->put('name', $name);
            session()->put('avatar', $name);
            return redirect('/homepage')->send();
        }
    }

    public function logout(){
        session()->forget('email');
        session()->forget('name');
        session()->forget('avatar');
        session()->put('is-customer-logged', 'no');
    }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') == 'yes'){
   
           return 'yes';
        }
        else{
            return 'no';
        }
    }

}
