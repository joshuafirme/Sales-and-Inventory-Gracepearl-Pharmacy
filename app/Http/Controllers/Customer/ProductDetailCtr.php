<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;

class ProductDetailCtr extends Controller
{
  private $table_prod = "tblproduct";
  private $table_cat = "tblcategory";
  private $table_unit = "tblunit";
  private $table_exp = "tblexpiration";

    public function getProductDetails($product_code){


        $details = DB::table($this->table_prod.' AS P')
          ->select('E.qty', 'unit', 'category_name', 'description', 'image', 'selling_price', 'with_prescription','highlights',
            DB::raw('CONCAT(P._prefix, P.id) AS product_code'))
          ->leftJoin($this->table_exp.' AS E', 'E.product_code', '=', DB::raw('CONCAT(P._prefix, P.id)'))
          ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
          ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
          ->where(DB::raw('CONCAT(P._prefix, P.id)'), $product_code)
          ->get();

         
        
        return view('customer/product_detail',['product' => $details->unique('id'), 'qty' =>  $this->getQty($product_code)]);      
      } 

      public static function getQty($product_code){
        return DB::table('tblexpiration')
          ->where('product_code', $product_code)
          ->sum('qty');
      }

      public function buyNow()
      {
        $product_code = Input::input('product_code');
        $qty = Input::input('qty');
        $amount = Input::input('amount');

        $p_data = $this->getProduct($product_code);
  
        session()->forget('buynow-item');

        $item = session()->get('buynow-item');
        if(!$item) {
            $item = [ 
              $product_code => [       
                'description' => $p_data->description, 
                'unit' => $p_data->unit, 
                'category' => $p_data->category_name, 
                'image' => $p_data->image, 
                'qty' => $qty,
                'amount' => $amount      
              ]                     
                       
            ];
            
            session()->put('buynow-item', $item);
            return $item;
         //   return redirect()->back();
        }
      }

      public function forgetBuyNow(){
        session()->forget('buynow-item');
      }

      public function getProduct($product_code)
      {
        $product = DB::table($this->table_prod.' AS P')
        ->select("P.*", 'description', 'unit', 'category_name', 'image')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where(DB::raw('CONCAT(P._prefix, P.id)'), $product_code)
        ->first();

        return $product;          
      }
}
