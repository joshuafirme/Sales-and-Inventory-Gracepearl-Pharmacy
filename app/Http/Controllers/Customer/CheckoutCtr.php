<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\OnlineOrder;

class CheckoutCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cart = "tblcart";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";

    public function index(){
     // session()->forget('buynow-item');
     //   dd(session()->get('buynow-item'));
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

      public function getSubtotalAmount()
      {
        $order_no = session()->get('order-no');
        $user_id = $this->getUserIDWithPrefix();
        $amount = DB::table($this->tbl_ol_order)
        ->where([
            ['email',  $user_id],
            ['order_no', $order_no]
        ])
          ->sum('amount');  

        session()->put('checkout-total', $amount);
        
        return $amount;
      }

      public function placeOrder()
      {
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
            DB::table($this->tbl_cart)->delete();
          }
        }
       
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
