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
      //  dd(session()->get('order-no'));
        $this->isLoggedIn();
        return view('customer/payment');
    }

    public function afterPayment(){
       
        return view('customer/layouts/after_payment');
    }

    public function getOrderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->max('order_no');
        return ++ $order_no;
    }

    public function forgetOrder(){
        session()->forget('order-no');
    }

    public function cashOnDelivery(){

        $order_no = session()->get('order-no');
        //kung walang laman ang session
        if(!$order_no){
           $order_no = $this->getOrderNo() -1;
        }

        $user_id = $this->getUserIDWithPrefix();
        DB::table($this->tbl_ol_order)
        ->where([
            ['email',  $user_id],
            ['order_no', $order_no]
        ])
        ->update([
            'payment_method' => 'COD',
            'status' => 'Processing'
        ]); 
        $this->forgetOrder();  
    }

    public function gcashPayment()
    {     
        $source_ss = session()->get('source');
        $amount = session()->get('checkout-total');    
        
        if(!$source_ss) {
        $source = Paymongo::source()->create([
            'type' => 'gcash',
            'amount' => $amount,
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('gcashpayment'),
                'failed' => route('gcashpayment')
            ]
        ]);
            $source_ss = [
                    'source_id' => $source->id,            
                    'amount' => $source->amount,
                    'status' => $source->status           
            ];
            
            session()->put('source', $source_ss);

        $this->forgetOrder(); 

        return redirect($source->getRedirect()['checkout_url']);      
        }
        else{
            Paymongo::payment()
            ->create([
                'amount' => $source_ss['amount'],
                'currency' => 'PHP',
                'description' => 'Gracepearl Test Payment',
                'statement_descriptor' => 'Test',
                'source' => [
                    'id' => $source_ss['source_id'],
                    'type' => 'source'
                ]
            ]);
            $this->updatePaymentToGcash();   
                 
            // kalimutan ang source at mag move on :)
            session()->forget('source');
            return redirect('/homepage')->send();
        }
    }

    public function updatePaymentToGcash(){

        $order_no = session()->get('order-no'); 

        //kapag walang laman ang session
        if(!$order_no){
            $order_no = $this->getOrderNo() -1;
        }
        $user_id = $this->getUserIDWithPrefix();
        DB::table($this->tbl_ol_order)
        ->where([
            ['email',  $user_id],
            ['order_no', $order_no]
        ])
        ->update([
        'payment_method' => 'GCash',
        'status' => 'Processing'
        
        ]); 
    }

    public function payNow($order_no){
        $amount = Input::input('amount');
        session()->put('checkout-total', $amount); 
        session()->put('order-no', $order_no); 
    }

    public function updatePayment(){
        $user_id = $this->getUserIDWithPrefix();
        DB::table($this->tbl_ol_order)
        ->where([
            ['email',  $user_id],
            ['order_no',  $this->getOrderNo() -1 ]
        ])
        ->update([
        'payment_method' => 'GCash',
        'status' => 'Processing'
        
        ]);   
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
