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

    public function index()
    {
        $this->isLoggedIn();
        return view('customer/payment');
    }

    public function afterPayment(){
      
        return view('customer/layouts/after_payment');
    }

    public function cashOnDelivery(){
        DB::table($this->tbl_ol_order)
        ->where([
            ['email',  session()->get('email')],
            ['order_no',  $this->getOrderNo() -1 ]
        ])
        ->update([
            'payment_method' => 'COD',
            'status' => 'Processing'
        ]); 
        session()->get('checkout-total');    
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
                'failed' => route('gcashpayment')
            ]
        ]);
        return redirect($source->getRedirect()['checkout_url']);       
       }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }
}
