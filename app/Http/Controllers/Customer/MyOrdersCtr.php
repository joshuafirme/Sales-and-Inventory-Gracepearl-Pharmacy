<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\OnlineOrder;
use Auth;

class MyOrdersCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cart = "tblcart";
    private $tbl_cat = "tblcategory";
    private $tbl_unit = "tblunit";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";

    public function index()
    {

        $this->isLoggedIn();
        return view('customer/myorders',[
            'orders' => $this->getMyOrders(),
            'order_no' => $this->orderNo()
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

    public function cancelOrder($order_no){

      $remarks = Input::input('remarks');
        DB::table($this->tbl_ol_order)
        ->where([
            ['order_no', $order_no],
        ])->update([
          'status' => 'Cancelled',
          'remarks' => $remarks,
          'updated_at' => date('Y-m-d h:m:s')
        ]);
    }

    public function orderNo(){
      $user_id = $this->getUserIDWithPrefix();
        $order_no = DB::table($this->tbl_ol_order)
        ->select(DB::raw('CONCAT('.$this->tbl_ol_order.'._prefix, '.$this->tbl_ol_order.'.order_no) AS pr_order_no'), 'order_no')
        ->where('email', $user_id)
        ->whereNotIn('status', ['Cancelled'])
        ->distinct('order_no')
        ->orderBy('order_no', 'desc')
        ->get();
        
      return $order_no;
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
