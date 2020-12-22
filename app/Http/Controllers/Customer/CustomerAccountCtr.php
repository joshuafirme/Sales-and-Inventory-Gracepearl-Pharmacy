<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\CustomerAccount;

class CustomerAccountCtr extends Controller
{
    private $tbl_cust_acc = "tblcustomer_account";
    private $tbl_google_acc = "tblgoogle_account";

    public function index(){
        $acc_info = $this->getAccountInfo();
        return view('/customer/account',[
            'account' => $acc_info
        ]);
    }

    public function getAccountInfo(){

        $acc_info = DB::table($this->tbl_cust_acc)->where('email', session()->get('email'))->get(); 

        return $acc_info;
    }

    public function updateAccount(){

        $fullname = Input::input('fullname');
        $email = Input::input('email');
        $phone_no = Input::input('phone_no');

        CustomerAccount::where('email', $email)
        ->update([
            'fullname' => $fullname,
            'email' => $email,
            'phone_no' => $phone_no
            ]);

        return redirect('/account')->send();
    }

}
