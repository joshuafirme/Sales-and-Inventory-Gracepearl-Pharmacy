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
  private $tbl_cust_acc = "tblcustomer_account";
  private $tbl_cust_ver = "tblcustomer_verification";

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
        $user_id_prefix = $this->getUserIDWithPrefix();
        $cart = DB::table($this->tbl_cart)
          ->select('tblcart.*','product_code', 'description', 'tblcart.qty', 'amount', 'unit', 'category_name', 'image')
          ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_cart . '.product_code')
          ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
          ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
          ->where('customerID', $user_id_prefix)
          ->orderBy('tblcart.id', 'desc')
          ->get();

        return $cart;
      }

      public function addToCart()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $product_code = Input::input('product_code');
        $price = $this->getPrice($product_code);
  
        if($this->isProductExists($product_code) == true)
        {
          // add amount and qty by 1
          DB::table($this->tbl_cart)
          ->where([
            ['customerID', $user_id_prefix],
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
            'customerID' => $user_id_prefix,
            'product_code' => $product_code, 
            'qty' => 1,
            'amount' => $price
            ]);
        }
        
     
      }
  
      public function isProductExists($product_code){
          $user_id_prefix = $this->getUserIDWithPrefix();
          $cart = DB::table($this->tbl_cart)
          ->where([
            ['customerID', $user_id_prefix],
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
        $user_id_prefix = $this->getUserIDWithPrefix();

        $amount = DB::table($this->tbl_cart)
          ->where('customerID', $user_id_prefix)
          ->sum('amount');  
      //  session()->put('checkout-total', $amount);

        return $amount;
      }

      public function getTotalDueWithDiscount()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();

        $amount = DB::table($this->tbl_cart)
          ->where('customerID', $user_id_prefix)
          ->sum('amount');  

        $verification = $this->checkVerification();

        if($verification == 'Verified Senior Citizen')
        {
          $discount = $this->seniorGenericItemDiscount();
        }
        else if($verification == 'Verified Senior PWD')
        {
          $discount = $this->pwdGenericItemDiscount();
        }
        else{
          session()->put('checkout-total', $amount);
          return $amount;
        }
       
        $total = $amount - $discount;
        session()->put('checkout-discount', $discount);

        if($amount == 0){
          session()->put('checkout-total', $total);
        }
        session()->put('checkout-total', $total);
        return $total;
      }

      public function seniorGenericItemDiscount()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $discount_percentage = $this->getSeniorCitizenDiscount();

        $amount = DB::table($this->tbl_cart.' as CART')
          ->leftJoin($this->tbl_prod.' as P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'CART.product_code')
          ->leftJoin($this->tbl_cat.' as C', 'C.id', '=', 'P.categoryID')
          ->where([
            ['CART.customerID', $user_id_prefix],
            ['C.category_name', 'Generic']
          ])
          ->sum('CART.amount');
        $discount = $discount_percentage * $amount;  
        return $discount;
      }

      public function pwdGenericItemDiscount()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $discount_percentage = $this->getPWDDiscount();

        $amount = DB::table($this->tbl_cart.' as CART')
          ->leftJoin($this->tbl_prod.' as P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'CART.product_code')
          ->leftJoin($this->tbl_cat.' as C', 'C.id', '=', 'P.categoryID')
          ->where([
            ['CART.customerID', $user_id_prefix],
            ['C.category_name', 'Generic']
          ])
          ->sum('CART.amount');
        $discount = $discount_percentage * $amount;  
        return $discount;
      }

      public function getPWDDiscount(){
        $discount = DB::table('tbldiscount')->value('pwd_discount');
        return $discount;
    }

    public function getSeniorCitizenDiscount(){
        $discount = DB::table('tbldiscount')->value('sc_discount');
        return $discount;
    }

    public function checkVerification(){

      $user_id = $this->getUserIDWithPrefix();
      
      if($user_id){
          $cust_ver =  DB::table($this->tbl_cust_ver)
          ->where('user_id', $user_id)
          ->value('status'); 

          if($cust_ver){
              switch ($cust_ver) {
                  case 'Verified':
                      return 'Verified';
                      break;
                  case 'Verified Senior Citizen':
                      return 'Verified Senior Citizen';
                      break; 
                  case 'Verified PWD':
                      return 'Verified PWD';
                      break; 
                  default:
                    return 'For validation';
                }
          }  
          else{
              return null;
          } 
      }      
  }

      public function removeFromCart()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $product_code = Input::input('product_code');

        DB::table($this->tbl_cart) 
          ->where([
            ['customerID', $user_id_prefix],
            ['product_code', $product_code]
          ])->delete();
      }

      public function updateQtyAndAmount()
      {
        $user_id_prefix = $this->getUserIDWithPrefix();
        $product_code = Input::input('product_code');
        $qty = Input::input('qty');
        $selling_price = $this->getPrice($product_code);
        // compute amount and increment qty
        DB::table($this->tbl_cart)
        ->where([
          ['customerID', $user_id_prefix],
          ['product_code', $product_code]
        ])
        ->update(array(
            'amount' => DB::raw($selling_price * $qty),
            'qty' => $qty));
     
      }

      public function getUserIDWithPrefix()
      {
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
