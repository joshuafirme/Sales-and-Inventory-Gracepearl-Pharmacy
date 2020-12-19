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
        DB::table($this->tbl_cart)->delete();
        return view('customer/layouts/after_payment');
    }

    public function cashOnDelivery(){

        if($this->getCheckoutItems()){
            $order_no = $this->getOrderNo();
            foreach ($this->getCheckoutItems() as $data)
            {
                $ol_order = new OnlineOrder;
                $ol_order->_prefix = 'O'.date('ymd');
                $ol_order->order_no = $order_no;
                $ol_order->email = $data->customerID;
                $ol_order->product_code = $data->product_code;
                $ol_order->qty = $data->qty;
                $ol_order->amount = $data->amount;
                $ol_order->payment_method = 'COD';
                $ol_order->status = 'Processing';
                $ol_order->shippingID = 'S001';

                $ol_order->save();
            }
          
        }
       
    }

    public function getOrderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->max('order_no');
        $inc = ++ $order_no;
        return $inc;
    }

    public function getCheckoutItems()
      {
        $checkout_items = DB::table($this->tbl_cart)
        ->where('customerID', session()->get('email'))
        ->get();
        return $checkout_items;
      }

    public function gcashPayment(){

        $source = Paymongo::source()->create([
            'type' => 'gcash',
            'amount' =>  session()->get('checkout-total'),
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('gcashpayment'),
                'failed' => redirect('/payment')->send()
            ]
        ]);
       // dd($source);
      //  dd($source->getRedirect()['checkout_url']);
        return redirect($source->getRedirect()['checkout_url']);
           
       }

       public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }
}
