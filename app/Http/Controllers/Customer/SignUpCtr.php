<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerAccount;
use Illuminate\Support\Facades\Hash;

class SignUpCtr extends Controller
{
    private $tbl_cust_acc = "tblcustomer_account";

    public function index(){
        return view('customer/signup');
    }

    public function signUp(){

        $fullname = Input::input('fullname');
        $phone_no = Input::input('phone_no');
        $password = Input::input('password');
        
            $cust_acc = new CustomerAccount;
            $cust_acc->_prefix = 'CUST-'. date('yy').'-';
            $cust_acc->fullname = $fullname;
            $cust_acc->phone_no = $phone_no;
            $cust_acc->password = $this->hashPassword($password);
            $cust_acc->save();
            
            return redirect('/customer-login')->send();
      
    }

    public function hashPassword($password)
    {
        return Hash::make($password);
    }

    public function isPhoneNoExists()
    {
        $phone_no = Input::input('phone_no');
        
        $account =  DB::table($this->tbl_cust_acc)
        ->where('phone_no', $phone_no)->get();  

        if($account->count() > 0)
        {
            return '1';
        }
    }
 
}
