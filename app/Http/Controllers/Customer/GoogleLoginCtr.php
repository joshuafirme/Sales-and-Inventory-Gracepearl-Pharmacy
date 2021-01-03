<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerAccount;
use App\GoogleAccount;
use Illuminate\Http\Request;
use Socialite;

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

        $account =  DB::table($this->tbl_cust_acc)->where('email', $email)->get();  

        if($account->count() > 0)
        {
            $this->putToSession($email, $avatar);
            return redirect('/homepage')->send();
        }
        else
        {
            $this->putToSession($email, $avatar);

            $cust_acc = new CustomerAccount;
            $cust_acc->_prefix = 'CUST-'. date('yy').'-';
            $cust_acc->fullname = $name;
            $cust_acc->email = $email;
            $cust_acc->save();
            
            return redirect('/homepage')->send();
        }
    }

    public function putToSession($email, $avatar){
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
