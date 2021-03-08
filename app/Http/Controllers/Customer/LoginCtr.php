<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerAccount;
use Illuminate\Support\Facades\Hash;
use Auth;

class LoginCtr extends Controller
{  
    private $tbl_cust_acc = "tblcustomer_account";

    public function index(){
        if(session()->get('is-customer-logged') == 'yes'){
   
            return redirect()->to('/')->send();
         }
        return view('/customer-login');
    }

    public function login()
    {
        $phone_email = Input::input('phone_email');
        $password = Input::input('password');

        if (Auth::attempt(['email' => $phone_email, 'password' => $password])) 
        {
            $this->putToSession($phone_email);
            return 'valid';        
        }
    
       
    }
    
    public function isAccountExists($phone_email)
    {
        $acc =  DB::table($this->tbl_cust_acc)
        ->where('phone_no', $phone_email)
        ->orWhere('email', $phone_email)
        ->get(); 
        
        if($acc->count() > 0){
            return true;
        }

    }
 
    public function isPasswordMatch($phone_email, $password)
    {
        $hashedPassword = $this->getHashedPassword($phone_email);
        
       if($hashedPassword){
        if (Hash::check($password, $hashedPassword)) {
            return true;
        }
       }
    }

    public function getHashedPassword($phone_email)
    {
        $acc =  DB::table($this->tbl_cust_acc)
        ->where('phone_no', $phone_email)
        ->value('password');
        
        return $acc;
    }

    public function putToSession($phone_email){
        session()->put('phone_no', $phone_email);
        session()->put('avatar', '');
        session()->put('is-customer-logged', 'yes');
    }

    public function logout(){
        Auth::logout();
        session()->forget('phone_no');
        session()->forget('email');
        session()->forget('avatar');
        session()->put('is-customer-logged', 'no');
    }
}
