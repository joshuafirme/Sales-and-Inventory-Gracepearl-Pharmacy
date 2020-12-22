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

    public function index(){
        $this->isLoggedIn();
        
        $cart = $this->getCartItems();
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
        $cart = DB::table($this->tbl_cart)
          ->select('tblcart.*','product_code', 'description', 'tblcart.qty', 'amount', 'unit', 'category_name', 'image')
          ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_cart . '.product_code')
          ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
          ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
          ->where('customerID', session()->get('email'))
          ->orderBy('tblcart.id')
          ->get();

        return $cart;
      }

      public function getSubtotalAmount()
      {
        $amount = DB::table($this->tbl_cart)
          ->where('customerID', '=', session()->get('email'))
          ->sum('amount');  

        session()->put('checkout-total', $amount);
        
        return $amount;
      }

      public function placeOrder()
      {
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
              $ol_order->status = 'Payment pending';
              $ol_order->shippingID = 'S001';

              $ol_order->save();
          }
        //  DB::table($this->tbl_cart)->delete();
        }
        else{
          
        }
      }

      public function getCheckoutItems()
      {
        $checkout_items = DB::table($this->tbl_cart)
        ->where('customerID', session()->get('email'))
        ->get();
        return $checkout_items;
      }

      public function buyNow($product_code)
      {
        session()->put('buy-now-pcode', $product_code);
      }

      public function getOrderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->max('order_no');
        $inc = ++ $order_no;
        return $inc;
    }

}
