<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;

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
        return view('/customer/homepage', 
        [
          'products' => $this->getAllProduct(),
          'maxPrice' => $this->getMaxPrice(),
          'minPrice' => $this->getMinPrice()
          ]);
      }

    
    public function getAllProduct()
    {
      $limit = Input::input('limit');
      if($limit){
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('exp_date >= CURDATE()')
        ->limit($limit)
        ->get();
      }
      else{
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->whereRaw('exp_date >= CURDATE()')
        ->limit(8)
        ->get();
      }
     

      return $product;      
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

        if($search_key){
          $product = DB::table($this->table_prod.' AS P')
          ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
          ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
          ->whereRaw('exp_date >= CURDATE()')
          ->where('description', 'LIKE', '%'.$search_key.'%')
          ->whereRaw('C.category_name IN ("'.$cat_imp.'")')
          ->whereBetween('selling_price', [$min_price, $max_price])
          ->limit($limit)
          ->get();
        }
        else{
          $product = DB::table($this->table_prod.' AS P')
          ->select("P.*", DB::raw('CONCAT(P._prefix, P.id) AS product_code, unit, category_name, supplierName'))
          ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
          ->whereRaw('exp_date >= CURDATE()')
          ->whereRaw('C.category_name IN ("'.$cat_imp.'")')
          ->limit($limit)
          ->get();
        }
        return $product;         
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
   
}
