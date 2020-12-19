<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use Stripe;

class StripePaymentCtr extends Controller
{
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
                    "description" => "Sales and Inventory Test payment" 
            ]);
            session()->forget('checkout-total');
  
            Session::flash('success', 'Payment successful!');
            
            return back();
        }

        
    }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }
}
