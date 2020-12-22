<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\OnlineOrder;

class MyOrdersCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cart = "tblcart";
    private $tbl_cat = "tblcategory";
    private $tbl_unit = "tblunit";
    private $tbl_ol_order = "tblonline_order";

    public function index()
    {

        $this->isLoggedIn();
        return view('customer/myorders',[
            'orders' => $this->getMyOrders(),
            'order_no' => $this->orderNo()
          //  'placedOn' => $this->placedOn()
        ]);
    }

    public function getMyOrders(){

        $orders = DB::table($this->tbl_ol_order)
        ->select($this->tbl_ol_order.'.*',DB::raw('CONCAT('.$this->tbl_ol_order.'._prefix, '.$this->tbl_ol_order.'.order_no) AS order_no, unit, category_name, image, description'))
        ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_ol_order . '.product_code')
        ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
        ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')

        ->get();     
        return $orders;
      }

    public function orderNo(){
        $order_no = DB::table($this->tbl_ol_order)
        ->select(DB::raw('CONCAT('.$this->tbl_ol_order.'._prefix, '.$this->tbl_ol_order.'.order_no) AS pr_order_no'), 'order_no')
        ->where('email', session()->get('email'))
        ->distinct('order_no')
        ->orderBy('order_no', 'desc')
        ->get();
        
      return $order_no;
    }

    public function placedOn(){
        $q = DB::table($this->tbl_ol_order)
        ->select('created_at')
        ->distinct('order_no')
        ->orderBy('order_no', 'desc')
        ->get();
        dd($q);
       return $q;
    

 
  }

    public function isLoggedIn(){
        if(session()->get('is-customer-logged') !== 'yes'){
   
           return redirect()->to('/customer-login')->send();
        }
    }
}
