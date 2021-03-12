<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use Session;
use Stripe;
use Auth;

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

    public function stripeSuccess(){
        return view('customer/layouts/stripe_success_payment');
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
        $order = $this->getOrderDetails($this->getOrderNo() -1);

        $sales_inv_no = $this->getSalesInvNo();
        $trans_no = $this->getTransactionNo();
        for($i = 0; $i < $order->count(); $i++){
            $this->recordSales(
                $trans_no,
                $sales_inv_no,
                $order[$i]->product_code,
                $order[$i]->qty,
                $order[$i]->amount,
                $card_type
            );    
        }
        $this->updateInventory($order[0]->product_code, $order[0]->qty);
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

    public function recordSales($trans_no,$product_code, $qty, $amount, $payment_method){
        DB::table('tblsales')
            ->insert([
                '_prefix' => date('Ymd'),
                'transactionNo' => $trans_no,
                'sales_inv_no' => $this->getSalesInvNo(),
                'product_code' => $product_code,
                'qty' => $qty,
                'amount' => $amount,
                'payment_method' => $payment_method,
                'date' => date('Y-m-d'),
                'order_from' => 'Online',
                'created_at' => date('Y-m-d h:m:s'),
                'updated_at' => date('Y-m-d h:m:s')
            ]);
    }

    public function getTransactionNo(){
        $trans_no = DB::table('tblsales')
        ->max('transactionNo');
        $inc = ++ $trans_no;
        return str_pad($inc, 5, '0', STR_PAD_LEFT);
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
