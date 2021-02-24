<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerAccount;
use App\GoogleAccount;
use Illuminate\Http\Request;
use Socialite;
use Redirect;
use Auth;
use App\User;
use Session;

class GoogleLoginCtr extends Controller
{
    private $tbl_emp = "tblemployee";
    private $tbl_cust_acc = "tblcustomer_account";

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
           
            $this->googleLogin($user->email, $user->name, $user->avatar);
  
        } catch (Exception $e) {
            return redirect('customer-login/google');
        }
    }

    public function googleLogin($email, $name, $avatar){

        $user = User::where('email', $email)->first();
        
        if($user)
        {
        //    Auth::loginUsingId($user->id, true);   
            $this->putToSession($user->id, $email, $avatar);
            return Redirect::to('/')->send();
        }
        else
        {
            $this->putToSession($email, $avatar);

            $cust_acc = new CustomerAccount;
            $cust_acc->_prefix = 'CUST-'. date('yy').'-';
            $cust_acc->fullname = $name;
            $cust_acc->email = $email;
            $cust_acc->save();
            
            $this->putToSession($email, $avatar);
            Auth::loginUsingId($user->id);
            return Redirect::to('/')->send();   
        }
    }

    public function putToSession($id, $email, $avatar){
        session()->put('user-id', $id);
        session()->put('email', $email);
        session()->put('avatar', $avatar);
        session()->put('is-customer-logged', 'yes');
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
