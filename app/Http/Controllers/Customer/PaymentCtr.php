<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Support\Str;
use App\OnlineOrder;

class PaymentCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cart = "tblcart";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";

    public function index()
    {
        $this->isLoggedIn();
        return view('customer/payment');
    }

    public function afterPayment(){
       
        return view('customer/layouts/after_payment');
    }

    public function forgetOrder(){
        session()->forget('order-no');
    }

    public function cashOnDelivery(){
        $user_id = $this->getUserIDWithPrefix();
        DB::table($this->tbl_ol_order)
        ->where([
            ['email',  $user_id],
            ['order_no',  $this->getOrderNo() -1 ]
        ])
        ->update([
            'payment_method' => 'COD',
            'status' => 'Processing'
        ]);   
    }

    public function getOrderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->max('order_no');
        return ++ $order_no;
    }

    public function gcashPayment(){

        $source = Paymongo::source()->create([
            'type' => 'gcash',
            'amount' =>  session()->get('checkout-total'),
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('gcashpayment'),
                'failed' => dd('failed')
            ]
        ]);
        dd($source);
        return redirect($source->getRedirect()['checkout_url']);       
       }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }

    public function getUserIDWithPrefix(){
        if(session()->get('phone_no')){
          $id =  DB::table($this->tbl_cust_acc)
          ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
          ->where('phone_no', session()->get('phone_no'))    
          ->first();  
          return $id->user_id;
      }
      else{
        $id =  DB::table($this->tbl_cust_acc)
        ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
        ->where('email', session()->get('email'))    
        ->first();  
        return $id->user_id;
       }
      }

}
