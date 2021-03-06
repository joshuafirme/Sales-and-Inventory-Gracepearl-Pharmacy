<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use Session;
use Auth;

class HomePageCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $tbl_cart = "tblcart";

    public function index(){
     // $str = "Hello, world, beautiful, day.";
    //  $cat_arr = explode(', ',$str);
    //  dd($cat_imp = implode('", "', $cat_arr));
    //dd(Session::get('reminder'));
    if(session()->get('is-customer-logged') == 'yes')
    { 
       

    }
    else{

    }

    Auth::loginUsingId(Session::get('user-id'));
        return view('/customer/homepage', 
        [
          'products' => $this->getAllProduct(),
          'maxPrice' => $this->getMaxPrice(),
          'minPrice' => $this->getMinPrice()
          ]);
      }

    public function isReminderShowed()
    {
      return Session::get('reminder');
    }

    public function notShowReminder()
    {
      Session::put('reminder', '0');
    }

    
    public function getAllProduct()
    {
      $limit = Input::input('limit');
      if($limit){
        $product = DB::table('tblproduct AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) as product_code'),'E.id as id_exp', 'P.id as product_id', 'P.image',
               'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'P.with_prescription', 
                 'unit', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin('tblexpiration AS E', 'E.product_code', '=', DB::raw('CONCAT(P._prefix, P.id)'))
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('E.archive_status', 0)
        ->whereRaw('E.exp_date >= CURDATE()')
        ->orderBy('P.with_prescription', 'asc')
        ->limit($limit)
        ->get();
      }
      else{
        $product = DB::table('tblproduct AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) as product_code'),'E.id as id_exp', 'P.id as product_id', 'P.image',
               'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'P.with_prescription', 
                 'unit', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
        ->leftJoin('tblexpiration AS E', 'E.product_code', '=', DB::raw('CONCAT(P._prefix, P.id)'))
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('E.archive_status', 0)
        ->whereRaw('E.exp_date >= CURDATE()')
        ->orderBy('P.with_prescription', 'asc')
        ->limit(8)
        ->get();
      }
     

      return $product->unique('id');         
    }  

    public function searchProduct($search_key)
    {
        $categories = Input::input('categories');
        $min_price = Input::input('min_price');
        $max_price = Input::input('max_price');
        $limit = Input::input('limit');
        $cat_arr = explode(', ',$categories);
        $cat_imp = implode('", "', $cat_arr);

        if(strlen($cat_imp) == 0 || strlen($cat_imp) == null){
          $cat_imp = 'Milk", "Branded", "Generic", "Vitamins", "Galenical", "Cosmetic';
        }

        if($search_key !== ''){
          $product = DB::table('tblproduct AS P')
          ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) as product_code'),'E.id as id_exp', 'P.id as product_id', 'P.image',
                 'P.description',
                   'P.re_order', 
                   'P.orig_price', 
                   'P.selling_price', 
                   'E.qty', 
                   'P.with_prescription', 
                   'unit', 
                   'category_name', 
                   DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
          ->leftJoin('tblexpiration AS E', 'E.product_code', '=', DB::raw('CONCAT(P._prefix, P.id)'))
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
          ->where('E.archive_status', 0)
              ->whereRaw('E.exp_date >= CURDATE()')
              ->where('description', 'LIKE', '%'.$search_key.'%')
              ->whereRaw('C.category_name IN ("'.$cat_imp.'")')
              ->whereBetween('selling_price', [$min_price, $max_price])
              ->orderBy('P.with_prescription', 'asc')
              ->limit($limit)
              ->get();
        }
        else{
          $product = DB::table('tblproduct AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) as product_code'),'E.id as id_exp', 'P.id as product_id', 'P.image',
               'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'P.with_prescription', 
                 'unit', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
          ->leftJoin('tblexpiration AS E', 'E.product_code', '=', DB::raw('CONCAT(P._prefix, P.id)'))
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
          ->whereRaw('E.exp_date >= CURDATE()')
          ->whereRaw('C.category_name IN ("'.$cat_imp.'")')
          ->orderBy('P.with_prescription', 'asc')
          ->limit($limit)
          ->get();
        }
        return $product->unique('id');         
    } 

    public function getQty($product_code){
      return DB::table($this->table_exp)
        ->where('product_code', $product_code)
        ->sum('qty');
    }

    public function getMaxPrice(){
      $price = DB::table($this->table_prod)
      ->max('selling_price');

      return $price;      
    } 

    public function getMinPrice(){
      $price = DB::table($this->table_prod)
      ->min('selling_price');

      return $price;      
    } 

    public function termsAndCondition(){
      return view('customer/layouts/terms_and_condition');
    }
   
}
