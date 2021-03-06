<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\OnlineOrder;
use App\OrderDiscount;
use Auth;

class CheckoutCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cart = "tblcart";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";
    private $tbl_ship_add_maintenance = "tblship_add_maintenance";

    public function index(){
     // session()->forget('buynow-item');
     //   dd(session()->get('buynow-item'));
     
        session()->forget('source');
    
        $this->isLoggedIn();
        
        $cart = $this->getCartItems();

        $item_session = session()->get('buynow-item');
        if($item_session){
          $cart = null;
        }
 
        return view('/customer/checkout',[
            'cart' => $cart, 
        ]);
    }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }

    public function forgetDiscount(){
      session()->get('checkout-discount');
    }

    public function countCart(){
        $cart = $this->getCartItems();
        return $count = $cart->count();
      
      }

      public function getCartItems()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $cart = DB::table($this->tbl_cart)
          ->select('tblcart.*','product_code', 'description', 'tblcart.qty', 'amount', 'unit', 'category_name', 'image')
          ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_cart . '.product_code')
          ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
          ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
          ->where('customerID', $user_id_prefix)
          ->get();

        return $cart;
      }

      public function getShippingFee(){

        $user_id = $this->getUserIDWithPrefix();
        $data = DB::table('tblshipping_add')
                            ->where('user_id', $user_id)
                            ->first();

        $fee = DB::table($this->tbl_ship_add_maintenance)
                  ->where([
                      ['municipality', $data->municipality],
                      ['brgy', $data->brgy]
                  ])
                  ->value('shipping_fee');

        session()->put('after-payment-shipping-fee', $fee);

        return $fee;
     }

      public function getSubtotalAmount()
      {
        $buynow_items = session()->get('buynow-item');

        if($buynow_items)
        {
          foreach($buynow_items as $product_code => $data)
          {
            $amount = $data['amount'];
          }
         
          session()->put('checkout-total', $amount);
          return $amount;

        }
        else{
          $order_no = session()->get('order-no');
          $user_id = $this->getUserIDWithPrefix();

          if($order_no)
          {
            $amount = DB::table($this->tbl_ol_order)
            ->where([
                ['email',  $user_id],
                ['order_no', $order_no]
            ])
              ->sum('amount');  
          }
          else
          {
            $amount = DB::table($this->tbl_cart)
            ->where([
                ['customerID',  $user_id]
            ])
              ->sum('amount');  
          }
          $discount = session()->get('checkout-discount');
          $amount_discounted = $amount - $discount;
          session()->put('checkout-total', $amount_discounted);
        }
        
        
        return $amount_discounted;
      }


      public function placeOrder()
      {
        $shipping_fee = Input::input('shipping_fee');
        $order_no = $this->getOrderNo();

        $item = session()->get('buynow-item');
        if($item)
        {
          foreach ($item as $product_code => $data) {
              $ol_order = new OnlineOrder;
              $ol_order->_prefix = 'O'.date('ymd');
              $ol_order->order_no = $order_no;
              $ol_order->email = $this->getUserIDWithPrefix();
              $ol_order->product_code = $product_code;
              $ol_order->qty = $data['qty'];
              $ol_order->amount = $data['amount'];
              $ol_order->status = 'Payment pending';
              $ol_order->shippingID = 'S001';

              session()->put('order-no', $order_no);

              $ol_order->save();
          }
        }
        else
        {
          if($this->getCheckoutItems()){
            
            foreach ($this->getCheckoutItems() as $data){
                $ol_order = new OnlineOrder;
                $ol_order->_prefix = 'O'.date('ymd');
                $ol_order->order_no = $order_no;
                $ol_order->email = $data->customerID;
                $ol_order->product_code = $data->product_code;
                $ol_order->qty = $data->qty;
                $ol_order->amount = $data->amount;
                $ol_order->status = 'Payment pending';
                $ol_order->shippingID = 'S001';
  
                session()->put('order-no', $order_no);
  
                $ol_order->save();
            }
            
          }
        }
        
        session()->forget('buynow-item');

        if((float)$shipping_fee !== 0){
          $this->storeShippingFee($order_no, $shipping_fee);
        }
        
        $user_id = $this->getUserIDWithPrefix();
        $session_discount = session()->get('checkout-discount');

        if($session_discount){
          $this->storeDiscount($user_id, $order_no, $session_discount);
        }

        DB::table($this->tbl_cart)->delete();
      }

      public function storeShippingFee($order_no, $shipping_fee){
        DB::table('tblorder_shipping_fee')
           ->insert([
              'order_no' => $order_no,
              'shipping_fee' => $shipping_fee,
              'created_at' => date('Y-m-d h:m:s'),
           ]);
      }

      public function storeDiscount($user_id, $order_no, $discount){
        $order_disc = new OrderDiscount;
        $order_disc->user_id = $user_id;
        $order_disc->order_no = $order_no;
        $order_disc->discount_amount = $discount;
        $order_disc->save();
      }

      public function getCheckoutItems()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $checkout_items = DB::table($this->tbl_cart)
        ->where('customerID', $user_id_prefix)
        ->get();
        return $checkout_items;
      }

      public function getOrderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->max('order_no');
        $inc = ++ $order_no;
        return $inc;
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
