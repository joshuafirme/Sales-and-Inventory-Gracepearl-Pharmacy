<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;

class CartCtr extends Controller
{
  private $tbl_prod = "tblproduct";
  private $tbl_cart = "tblcart";
  private $tbl_cat = "tblcategory";
  private $tbl_suplr = "tblsupplier";
  private $tbl_unit = "tblunit";

    public function index(){
        $this->isLoggedIn();

        $cart = $this->getCartItems();
        
        return view('/customer/cart',[
          'cart' => $cart, 
          'subtotalAmount' => $this->getSubtotalAmount()
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

      public function addToCart(){

        $product_code = Input::input('product_code');
        $price = $this->getPrice($product_code);
  
        if($this->isProductExists($product_code) == true)
        {
          // add amount and qty by 1
          DB::table($this->tbl_cart)
          ->where([
            ['customerID', session()->get('email')],
            ['product_code', $product_code]
          ])
            ->update(array(
              'amount' => DB::raw('amount + '. $price .''),
              'qty' => DB::raw('qty + '. 1)));
          
         
        }
        else
        {
          DB::table($this->tbl_cart)->insert(
            [
            'customerID' => session()->get('email'),
            'product_code' => $product_code, 
            'qty' => 1,
            'amount' => $price
            ]);
        }
        
     
      }
  
      public function isProductExists($product_code){
          $cart = DB::table($this->tbl_cart)
          ->where([
            ['customerID',  session()->get('email')],
            ['product_code', $product_code]
          ])->get();
  
          if($cart->count() > 0){
            return true;
          }
          else{
            return false;
          }
      }

      public function getPrice($product_code){
          $price = DB::table($this->tbl_prod)
          ->where(DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), $product_code)
          ->value('selling_price');

          return $price;
      }

      public function getSubtotalAmount()
      {
        $amount = DB::table($this->tbl_cart)
          ->where('customerID', '=', session()->get('email'))
          ->sum('amount');
         

        return $amount;
      }

      public function removeFromCart()
      {
        $product_code = Input::input('product_code');

        DB::table($this->tbl_cart) 
          ->where([
            ['customerID', session()->get('email')],
            ['product_code', $product_code]
          ])->delete();
      }

      public function updateQtyAndAmount()
      {
        $product_code = Input::input('product_code');
        $qty = Input::input('qty');
        $selling_price = $this->getPrice($product_code);
        // compute amount and increment qty
        DB::table($this->tbl_cart)
        ->where([
          ['customerID',  session()->get('email')],
          ['product_code', $product_code]
        ])
        ->update(array(
            'amount' => DB::raw($selling_price * $qty),
            'qty' => $qty));
     
      }
}
