<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Support\Str;
use App\OnlineOrder;
use Session;
use Auth;

class PaymentCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cart = "tblcart";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";

    public function index()
    {
       // dd($this->getOrderDetails('00001'));
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

// COD---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function cashOnDelivery(){

        $order_no = session()->get('order-no');

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

        $order = $this->getOrderDetails($order_no);

        for($i = 0; $i < $order->count(); $i++){
            $this->recordSales(
                $order[$i]->product_code,
                $order[$i]->qty,
                $order[$i]->amount,
                'COD'
            );    
        }
        $this->forgetOrder();  
    }

    
    public function getShippingFee(){

        $user_id = $this->getUserIDWithPrefix();
        $data = DB::table('tblshipping_add')
                            ->where('user_id', $user_id)
                            ->first();

        $fee = DB::table('tblship_add_maintenance')
                  ->where([
                      ['municipality', $data->municipality],
                      ['brgy', $data->brgy]
                  ])
                  ->value('shipping_fee');
        return $fee;
     }

// GCash Payment---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    public function gcashPayment()
    {     
        $source_ss = session()->get('source');
        $shipping_fee = $this->getShippingFee();
        $amount = Session::get('checkout-total') + $shipping_fee;    
        
        if(!$source_ss) {
        $source = Paymongo::source()->create([
            'type' => 'gcash',
            'amount' => number_format($amount,2,'.',','),
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
            return redirect('/')->send();
        }
    }

    public function updatePaymentToGcash(){

        $order_no = session()->get('order-no'); 
        $payment_method = 'GCash';

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
            'payment_method' => $payment_method,
            'status' => 'Processing'
        ]);

        $order = $this->getOrderDetails($order_no);

        for($i = 0; $i < $order->count(); $i++){
            $this->recordSales(
                $order[$i]->product_code,
                $order[$i]->qty,
                $order[$i]->amount,
                $payment_method
            );    
        }
        $this->updateInventory($order[0]->product_code, $order[0]->qty);
    }

    
    public function recordSales($product_code, $qty, $amount, $payment_method){
        DB::table('tblsales')
            ->insert([
                '_prefix' => date('Ymd'),
                'sales_inv_no' => $this->getSalesInvNo(),
                'product_code' => $product_code,
                'qty' => $qty,
                'amount' => $amount,
                'payment_method' => $payment_method,
                'date' => date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 days')),
                'order_from' => 'Online',
                'created_at' => date('Y-m-d', strtotime(date('Y-m-d h:m:s'). ' - 1 days')),
                'updated_at' => date('Y-m-d', strtotime(date('Y-m-d h:m:s'). ' - 1 days'))
            ]);
    }

    public function updateInventory($product_code, $qty){   
        DB::table('tblexpiration')
        ->where('product_code', $product_code)
        ->update(array(
            'qty' => DB::raw('qty - '. $qty .'')));
    }

    public function getSalesInvNo(){
        $sales_inv_no = DB::table('tblsales')
        ->max('sales_inv_no');
        $inc = ++ $sales_inv_no;
        return str_pad($inc, 5, '0', STR_PAD_LEFT);
    }

    public function getOrderDetails($order_no){
        return DB::table($this->tbl_ol_order)
        ->where('order_no', $order_no)
        ->get();
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

    public function getUserIDWithPrefix()
    {
        $session_phone_no = session()->get('phone_no');
        $session_email = session()->get('email');

        $id =  DB::table($this->tbl_cust_acc)
        ->select(DB::raw('CONCAT('.$this->tbl_cust_acc.'._prefix, '.$this->tbl_cust_acc.'.id) as user_id'))
        ->where('id',  Auth::id())    
        ->first();  
        return $id->user_id;          
        
    }

}
