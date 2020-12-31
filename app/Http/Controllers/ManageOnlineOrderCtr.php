<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\OnlineOrder;

class ManageOnlineOrderCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_ol_order = "tblonline_order";
    private $tbl_cust_acc = "tblcustomer_account";

    public function index(){
       // session()->forget('order-total-amount');
        return view('/manageonlineorder/manage_online_order');
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
                $button = '<a class="btn btn-sm" id="btn-show-items" order-no='. $ol_order->order_num .' 
                 title="View order"><i class="fas fa-eye"></i></a>';

                $button .= '<a class="btn btn-sm" id="fa-gen-sales-inv" order-no='. $ol_order->order_num .' 
                title="Generate sales invoice"><i class="fas fa-print"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);                         
        }
    }

    public function getPendingOrder(){

        $orders = DB::table($this->tbl_ol_order.' AS O')
        ->orderBy('created_at', 'asc')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, O.email'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', 'CA.email', '=', 'O.email')
        ->where('status', 'Payment pending')
        ->orderBy('O.order_no', 'desc')
        ->get();   

        return $orders->unique('order_no');    
    }

    public function getProcessingOrder(){

        $orders = DB::table($this->tbl_ol_order.' as O')
        ->orderBy('created_at', 'asc')
        ->select('O.*',DB::raw('CONCAT(O._prefix, O.order_no) AS order_num, fullname, phone_no, O.email'))
        ->leftJoin($this->tbl_cust_acc.' AS CA', 'CA.email', '=', 'O.email')
        ->where('status', 'Processing')
        ->orderBy('O.order_no', 'desc')
        ->get();   

        return $orders->unique('order_no');    
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

    public function generateSalesInvoice(){

        $output = $this->salesInvoiceHTML();
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A5', 'portrait');
    
        return $pdf->stream();
    }

    public function salesInvoiceHTML(){

        $output = '
        <style>
        @page { margin: 10px; }
        body{ font-family: sans-serif; }
        th{
            border: 1px solid;
        }
        td{
            font-size: 14px;
            border: 1px solid;
            padding-right: 2px;
            padding-left: 2px;
        }

        .p-name{
            text-align:center;
            margin-bottom:5px;
        }

        .address{
            text-align:center;
            margin-top:0px;
        }

        .p-details{
            margin:0px;
        }

        .ar{
            text-align:right;
        }

        .al{
            text-left:right;
        }

        .align-text{
            text-align:center;
        }

        .align-text td{
            text-align:center;
        }

        .w td{
            width:20px;
        }

   

        .b-text .line{
            margin-bottom:0px;
        }

        .b-text .b-label{
            font-size:12px;
            margin-top:-7px;
            margin-right:12px;
            font-style:italic;
        }


         </style>
        <div style="width:100%">
        
        <h1 class="p-name">GRACE PEARL PHARMACY</h1>
        <p class="p-details address">F. Alix St., Cor. F. Castro St., Brgy III, Nasugbu, Batangas</p>
        <p class="p-details address">MARIA ALONA S. CALDERON - Prop.</p>
        <p class="p-details address">VAT Reg: TIN 912-068-468-002</p>
        <h3 style="text-align:center;">SALES INVOICE</h3>

     
    
        <table width="100%" style="border-collapse:collapse; border: 1px solid;">                
        <thead>
          <tr>
              <th>Qty</th>  
              <th>Unit</th>    
              <th>Description</th>   
              <th>Unit Price</th>      
              <th>Amount</th>   
      </thead>
      <tbody>
        ';
        if(session()->get('order')){
            foreach (session()->get('order') as $product_code => $data) {
            
              
            
                $output .='
            <tr class="align-text">                             
                <td>'. $data['qty'] .'</td>  
                <td>'. $data['unit'] .'</td>  
                <td>'. $data['description'] .'</td>
                <td>'. number_format($data['unit_price']) .'</td>   
                <td>'. number_format($data['amount']) .'</td>              
            </tr>

          

              ';
            
            } 
        }
        else{
            echo "No data found";
        }
        
          
     $output .='
        <tr>
            <td style="text-align:right;" colspan="4">Total Sales (VAT Inclusive) </td>
            <td class="align-text">'. number_format(session()->get('order-total-amount')) .'</td>
        </tr>

        <tr>
            <td class="ar" colspan="4">Less: VAT </td>
            <td ></td>
        </tr>

        <tr >
            <td class="ar" colspan="2">VATable Sales </td>
            <td ></td>
            <td class="ar">Amount: Net of VAT</td>
            <td ></td>
        </tr>

        <tr>
            <td class="ar" colspan="2">VAT-Exempt Sales</td>
            <td ></td>
            <td class="ar">Less:SC/PWD Discount</td>
            <td ></td>
        </tr>

        <tr>
            <td class="ar" colspan="2">Zero Rated Sales</td>
            <td ></td>
            <td class="ar">Amount Due</td>
            <td ></td>
        </tr>

        <tr>
            <td class="ar" colspan="2">VAT Amount</td>
            <td ></td>
            <td class="ar">Add: VAT</td>
            <td ></td>
        </tr>

        <tr>
            <td style="text-align:right;" colspan="4">Total Amount Due </td>
            <td class="align-text">'. number_format(session()->get('order-total-amount')) .'</td>
        </tr>

        </tbody>
    </table>
    
    <div class="b-text">
        <p class="ar line">----------------------------------------</p>
        <p class="ar b-label">Cashier/Authorized Representative</p>
    </div>
</div>';
    
        return $output;
    }

    public function getDate(){
        $date = date('yy-m-d');
        return $date;
    }
}
