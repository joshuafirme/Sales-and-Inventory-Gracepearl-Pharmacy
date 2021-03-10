<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\OnlineOrder;
use App\Classes\UserAccessRights;
use App\Classes\OrderInvoice;
use Session;

class ManageOnlineOrderCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";
    private $tbl_cust_ver = "tblcustomer_verification";
    private $tbl_ship_add = "tblshipping_add";
    private $module = "Manage Online Order";

    public function index(){  
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            return view('/layouts.not_auth');
        }
        return view('/manageonlineorder/manage_online_order',['currentDate' => date('Y-m-d')]);
    }

    public function displayPendingOrder(){
        $ol_order = $this->getPendingOrder();
        
        if(request()->ajax())
        {
            return datatables()->of($ol_order)
            ->addColumn('action', function($ol_order){
                $button = '<a class="btn btn-sm" id="btn-show-items" order-no='. $ol_order->order_no .' 
                 title="View order" style="color: #00A0E9;">Cancel</a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);                         
        }
    }

    public function displayProcessingOrder(){
        $ol_order = $this->getProcessingOrder();
        
        if(request()->ajax())
        {
            return datatables()->of($ol_order)
            ->addColumn('action', function($ol_order){
                $button = '<a class="btn btn-sm" id="btn-show-processing" btn-text="Pack" order-no='. $ol_order->order_num .' user-id='.$ol_order->user_id.'  order-id='. $ol_order->order_no .'
                 title="View order"><i class="fas fa-eye"></i></a>';

             //   $button .= '<a class="btn btn-sm" id="fa-gen-sales-inv" order-no='. $ol_order->order_num .'
             //   title="Generate sales invoice"><i class="fas fa-print"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);                         
        }
    }

    public function displayPackedOrder(){
        $packed_order = $this->getPackedOrder();
        
        if(request()->ajax())
        {
            return datatables()->of($packed_order)
            ->addColumn('action', function($packed_order){
             //   $button = '<a class="btn btn-sm" id="fa-gen-sales-inv" order-no='. $packed_order->order_num .' 
            //    title="Generate sales invoice"><i class="fas fa-print"></i></a>';
            $button = '<a class="btn btn-sm" id="btn-show-pack" btn-text="Dispatch" order-no='. $packed_order->order_num .' user-id='.$packed_order->user_id.'  order-id='. $packed_order->order_no .'
            title="View order"><i class="fas fa-eye"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);                         
        }
    }
    
    public function displayDispatchOrder(){
        $d = $this->getDispatchOrder();
        
        if(request()->ajax())
        {
            return datatables()->of($d)
            ->addColumn('action', function($d){
             //   $button = '<a class="btn btn-sm" id="fa-gen-sales-inv" order-no='. $d->order_num .' 
            //    title="Generate sales invoice"><i class="fas fa-print"></i></a>';
            $button = '<a class="btn btn-sm" id="btn-show-dispatch" btn-text="Delivered" order-no='. $d->order_num .' user-id='.$d->user_id.'  order-id='. $d->order_no .'
            title="View order"><i class="fas fa-eye"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);                         
        }
    }

    public function displayDeliveredOrder(Request $request){

        $d = $this->getDeliveredOrder($request->date_from, $request->date_to);
        
        if(request()->ajax())
        {
            return datatables()->of($d)
            ->make(true);                         
        }
    }
    
    public function displayCancelledOrder(Request $request){

        $c = $this->getCancelledOrder($request->date_from, $request->date_to);
        
        if(request()->ajax())
        {
            return datatables()->of($c)
            ->make(true);                         
        }
    }

    public function getPendingOrder(){

        $orders = DB::table($this->tbl_ol_order.' AS O')
        ->orderBy('created_at', 'asc')
        ->select('O.*', DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, CA.email'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'O.email')
        ->where('status', 'Payment pending')
        ->orderBy('O.order_no', 'desc')
        ->get();   

        return $orders->unique('order_no');    
    }

    public function getProcessingOrder(){

        $orders = DB::table($this->tbl_ol_order.' as O')
        ->orderBy('created_at', 'asc')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, CA.email, O.email as user_id'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'O.email')
        ->where('status', 'Processing')
        ->orderBy('O.id', 'desc')
        ->get();   

        return $orders->unique('order_no');    
    }

    public function getPackedOrder(){

        $orders = DB::table($this->tbl_ol_order.' as O')
        ->orderBy('created_at', 'asc')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, CA.email, O.email as user_id'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'O.email')
        ->where('status', 'Packed')
        ->orderBy('O.id', 'desc')
        ->get();   

        return $orders->unique('order_no');    
    }

    public function getDispatchOrder(){

        $orders = DB::table($this->tbl_ol_order.' as O')
        ->orderBy('created_at', 'asc')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, CA.email, O.email as user_id'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'O.email')
        ->where('status', 'Dispatch')
        ->orderBy('O.id', 'desc')
        ->get();   

        return $orders->unique('order_no');    
    }

    public function getDeliveredOrder($date_from, $date_to){

        $o = DB::table($this->tbl_ol_order.' as O')
        ->orderBy('created_at', 'asc')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, CA.email, O.email as user_id'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'O.email')
        ->where('status', 'Delivered')
        ->whereBetween('O.updated_at', [$date_from, date('Y-m-d', strtotime($date_to. ' + 1 days'))])
        ->orderBy('O.id', 'desc')
        ->get();   

        return $o->unique('order_no');    
    }

    public function getCancelledOrder($date_from, $date_to){

        $o = DB::table($this->tbl_ol_order.' as O')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, CA.email, O.email as user_id'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', DB::raw('CONCAT(CA._prefix, CA.id)'), '=', 'O.email')
        ->where('status', 'Cancelled')
        ->whereBetween('O.updated_at', [$date_from, date('Y-m-d', strtotime($date_to. ' + 1 days'))])
        ->orderBy('O.updated_at', 'desc')
        ->get();   

        return $o->unique('order_no');    
    }


    public function showOrderItems($order_no){
    
        $items = DB::table($this->tbl_ol_order.' AS O')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, O.email, description, selling_price, O.qty, O.amount, unit, category_name'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', 'CA.email', '=', 'O.email')
        ->leftJoin($this->tbl_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'O.product_code')
        ->leftJoin($this->tbl_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->tbl_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where(DB::raw('CONCAT(O._prefix, O.order_no)'), $order_no)
        ->get();  

        session()->forget('order');
        $order = session()->get('order');

        $total = 0;
        for($i = 0; $i < $items->count(); $i++){
            
            if(!$order){
                $order = [
                    $items[$i]->product_code => [  
                            "description" => $items[$i]->description,
                            "category" => $items[$i]->category_name,
                            "qty" => $items[$i]->qty,
                            "unit" => $items[$i]->unit,  
                            "unit_price" => $items[$i]->selling_price,  
                            "amount" => $items[$i]->amount
                    ]
                ];
            }

            $order[$items[$i]->product_code] = [   
                        "description" => $items[$i]->description,
                        "category" => $items[$i]->category_name,
                        "qty" => $items[$i]->qty,
                        "unit" => $items[$i]->unit,  
                        "unit_price" => $items[$i]->selling_price,  
                        "amount" => $items[$i]->amount
            ];
            
            $total = $total + $items[$i]->amount;
           
        } 
        session()->put('order-total-amount', $total);

        session()->put('order', $order);

        return session()->get('order');
    }

   

    public function generateSalesInvoice($user_id, $discount, $shipping_fee){

        Session::put('order-discount', $discount);
        Session::put('order-shipping-fee', $shipping_fee);
        Session::put('order-user-id', $user_id);

        $shipping_address = $this->getShippingInfo($user_id);

        $output = $this->salesInvoiceHTML($shipping_address);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A5', 'portrait');
    
        return $pdf->stream();
    }

    public function salesInvoiceHTML($shipping_address){
        $s = new OrderInvoice;
        return $s->getSalesInvoiceHtml($shipping_address);
    }

    public function getDiscount($order_id){

        return DB::table('tblorder_discount')
                    ->where('order_no', $order_id)
                    ->value('discount_amount'); 
    }
    
    public function getShippingFee($order_id){

        $fee = DB::table('tblorder_shipping_fee')
                    ->where('order_no', $order_id)
                    ->pluck('shipping_fee'); 
        return $fee->unique('order_no');
    }

    public function getOrderTotalAmount($order_id){
        
        $fee = $this->getShippingFee($order_id);
        $discount = $this->getDiscount($order_id);

        $subtotal = DB::table('tblonline_order')
                    ->where('order_no', $order_id)
                    ->sum('amount'); 
        $disc = $discount > 0 ? $discount : 0;
        return ($subtotal + $fee[0]) - $disc;
    }


    public function getCustomerInfo($user_id){

        return DB::table($this->tbl_cust_acc.' as C')
                    ->where(DB::raw('CONCAT(C._prefix, C.id)'), $user_id)
                    ->get(); 
    }
    
    public function getShippingInfo($user_id){      
        return DB::table($this->tbl_ship_add)
            ->where('user_id', $user_id)
            ->get();           
    }

    public function verificationInfo($user_id){

        
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
                      return 'Not Verified';
                  }
            }  
            else{
                return null;
            } 
        }      
    }


    public function packItems($order_no){
        $user_id = Input::input('user_id');
        DB::table($this->tbl_ol_order.' as O')
        ->where([
            ['email',  $user_id],
            [DB::raw('CONCAT(O._prefix, O.order_no)'),  $order_no]
        ])
        ->update([
            'status' => 'Packed'
        ]); 
   
    }

    public function dispatchItems($order_no){
        $user_id = Input::input('user_id');
        DB::table($this->tbl_ol_order.' as O')
        ->where([
            ['email',  $user_id],
            [DB::raw('CONCAT(O._prefix, O.order_no)'),  $order_no]
        ])
        ->update([
            'status' => 'Dispatch'
        ]); 
   
    }

    public function deliveredItems($order_no){
        $user_id = Input::input('user_id');
        DB::table($this->tbl_ol_order.' as O')
        ->where([
            ['email',  $user_id],
            [DB::raw('CONCAT(O._prefix, O.order_no)'),  $order_no]
        ])
        ->update([
            'status' => 'Delivered'
        ]); 
   
    }

    public function bulkDispatch($order_no){

        $order_no_arr = explode(", ", $order_no);
        for($i = 0; $i < count($order_no_arr); $i++) {

            DB::table($this->tbl_ol_order.' as O')
            ->where(DB::raw('CONCAT(O._prefix, O.order_no)'), $order_no_arr[$i])
            ->update([
                'status' => 'Dispatch'
                ]);
        }
    }

    public function bulkDelivered($order_no){

        $order_no_arr = explode(", ", $order_no);
        for($i = 0; $i < count($order_no_arr); $i++) {

            DB::table($this->tbl_ol_order.' as O')
            ->where(DB::raw('CONCAT(O._prefix, O.order_no)'), $order_no_arr[$i])
            ->update([
                'status' => 'Delivered',
                'updated_at' => date("Y-m-d h:m:s")
                ]);    
        }
    }

    public function getDate(){
        $date = date('Y-m-d');
        return $date;
    }

    
}
