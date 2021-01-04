<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use Session;
use Stripe;

class StripePaymentCtr extends Controller
{
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";

    public function stripe()
    {
        $this->isLoggedIn();
        return view('customer/stripe');
    }
  
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {

        if(session()->get('checkout-total'))
        {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            Stripe\Charge::create ([
                    "amount" => session()->get('checkout-total') * 100,
                    "currency" => "php",
                    "source" => $request->stripeToken,
                    "description" => "Gracepearl Pharmacy Test payment" 
            ]);
            $this->updateStatus($request->input('card-number'));
            session()->forget('checkout-total');
            
            Session::flash('success', 'Payment successful!');
            
            return back();
        }

        
    }

    public function updateStatus($card_number){
        $card_type = $this->cardType($card_number);
        $user_id = $this->getUserIDWithPrefix();
        DB::table($this->tbl_ol_order)
        ->where([
            ['email',  $user_id],
            ['order_no',  $this->getOrderNo() -1 ]
        ])
        ->update([
            'payment_method' => $card_type,
            'status' => 'Processing'
        ]); 
    }

    public function cardType($card_number)
    {
        switch (substr($card_number, 0,2)) {
            case '42':
                return 'Visa';
                break;
            case '40':
                return 'Visa';
                break; 
            case '55':
                return 'Mastercard';
                break; 
            case '37':
                return 'American Express';
                break; 
            case '60':
                return 'Discover';
                break;                 
             default:
              return "N/A";
          }
    }

    public function getOrderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->max('order_no');
        return ++ $order_no;
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
