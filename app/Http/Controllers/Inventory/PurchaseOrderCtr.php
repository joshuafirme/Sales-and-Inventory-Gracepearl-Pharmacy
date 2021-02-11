<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use Mail;
use App\Mail\MyMail;
use App\ProductMaintenance;
use App\PurchaseOrder;
use App\Classes\UserAccessRights;
use App\Classes\Date;

class PurchaseOrderCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_exp = "tblexpiration";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_po = "tblpurchaseorder";
    private $module = "Inventory";

    public function index(Request $request)
    {
       // session()->forget('purchase-orders');
      //  session()->forget('po-supplier');
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $category_param = $request->category;
        $get_all_reorder = $this->getAllReorder(); 
       

        $unit = DB::table($this->table_unit)->get();
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        //
      //  $get_all_orders = $this->getAllOrders();
        $reorder_count = $get_all_reorder->count(); 
       
        return view('/inventory/purchase_order', 
            [
            'product' => $get_all_reorder,
            'unit' => $unit,
            'category' => $category,
            'suplr' => $suplr,
            'reorderCount' => $reorder_count,
            'currentDate' => date('Y-m-d'),
            'PORequest' => $this->getPORequest()
            ]);
    }

    public function displayReorders(Request $request){

        if(request()->ajax())
        {       
            if($request->supplier){
                return datatables()->of($this->getReorderBySupplier($request->supplier))
                ->addColumn('action', function($product){
                    $button = '<a class="btn btn-sm" id="btn-add-order" product-code='. $product->id .' data-toggle="modal" data-target="#purchaseOrderModal">
                    <i class="fa fa-cart-plus"></i></a>';
    
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);   
            }
                    
        }
    }

    public function displayOrders(Request $request){

        $get_all_orders = $this->getAllOrders($request->date_from, $request->date_to, $request->supplier);

        if(request()->ajax())
        {       
            return datatables()->of($get_all_orders)
            ->addColumn('status', function($orders){
                if($orders->status == 'Pending'){
                    $button = '<span class="badge" style="background-color:#337AB7; color:#fff;">Pending</span>';     
                    return $button;
                }
            })
            ->rawColumns(['status'])
            ->make(true);           
        }
    }


    public function getAllReorder(){
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->where('E.archive_status', 0)
        ->whereColumn('P.re_order','>=', 'E.qty')
        ->get();

        return $product;
    }

    public function getReorderBySupplier($supplier){
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
            ->where('E.archive_status', 0)
        ->whereColumn('P.re_order','>=', 'E.qty')
        ->where('P.supplierID', $supplier)
        ->get();

        return $product;
    }
    
    public function getAllOrders($date_from, $date_to, $supplier){
        return DB::table($this->table_po.' AS PO')
        ->select("PO.*", DB::raw('CONCAT(PO._prefix, PO.po_num) AS po_num, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
        ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PO.product_code')
        ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
      //  ->whereBetween('PO.date', [$date_from, date('Y-m-d', strtotime($date_to. ' + 1 days'))])
        ->whereBetween('PO.date', [$date_from, $date_to])
        ->where('S.supplierName', $supplier)
        ->where('PO.status', 'Pending')
        ->get();
    }

    public function show($product_code){
        $product = DB::table($this->table_exp.' AS E')
        ->select("E.*", 'E.product_code',
                 'P.description',
                 'P.re_order', 
                 'P.orig_price', 
                 'P.selling_price', 
                 'E.qty', 
                 'unit', 
                 'supplierName', 
                 'category_name', 
                 DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
            ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
            ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
            ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
            ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->where('E.id', $product_code)
        ->get();
 

        return $product;
    }

    public function filterSupplier($supplier){
  
        $orders = session()->get('orders');
        
        $arr = ['data' => $orders];

        return $arr;
    }


    public function sendMail(){
        $data = $this->convertProductDataToHTML();

        $this->recordOrder();
        $email = Input::input('supplier_email');
        Mail::to($email)
        ->send(new MyMail($data));
        // after email sent, it will automatically save orders to database
    }

    public function getSupplierEmail($supplier){
        $supplier = DB::table($this->table_suplr)
        ->where('supplierName', $supplier)
        ->value('email');

        return $supplier;
    }       


public function addToOrder(){

    $product_code = Input::input('product_code');
    $qty_order = Input::input('qty_order');
    $amount = Input::input('amount');
    $supplier = Input::input('supplier');

    session()->put('po-supplier', $supplier);

    if($this->isProductExists($product_code)){
        DB::table('tblpo_request')
        ->where('product_code', $product_code)
        ->update(array(
            'amount' => DB::raw('amount + '. $amount),
            'qty' => DB::raw('qty + '. $qty_order)));
    }
    else{
        DB::table('tblpo_request')
            ->insert([
                'product_code' => $product_code,
                'qty' => $qty_order,
                'amount' => $amount
            ]);
    }      
}

public function isProductExists($product_code){
    $p = DB::table('tblpo_request')->where('product_code', $product_code);
    if($p->count() > 0){
        return true;
    }
    else{
        return false;
    }
}

public function getTotalAmount(){
    return DB::table('tblpo_request')->sum('amount');
}


public function removeProduct($product_code)
{
    DB::table('tblpo_request')->where('product_code', $product_code)->delete();
    $po_req = DB::table('tblpo_request');
    if($po_req->count() == 0){
        session()->forget('po-supplier');
    }
}

public function getPORequest(){

    $product = DB::table('tblpo_request as PR')
    ->select("PR.*", 'description', 'selling_price', 'category_name', 'unit', 'supplierName')
    ->leftJoin($this->table_prod.' as P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'PR.product_code')
    ->leftJoin($this->table_suplr.' AS S', 'S.id', '=', 'P.supplierID')
    ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
    ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
    ->get();

    return $product;
}

public function getDate(){   
    $d = new Date;
    return $d->getDate();
}

public function recordOrder(){
    $sub_total = 0;
    $total_amount = 0;
    $po_num = $this->getPONum();
    $po_request = $this->getPORequest();

    if($po_request){
        foreach ($po_request as $data) {
           
            $po = new PurchaseOrder;
            $po->_prefix = 'PO' . $this->getPrefix();
            $po->po_num = $po_num;
            $po->product_code = $data->product_code;
            $po->qty_order = $data->qty;
            $po->amount = $data->amount;       
            $po->date = $this->getDate();  
            $po->status = 'Pending';    
            $po->save();     
        } 
    }
    DB::table('tblpo_request')->delete();

    // remove request orders after save to PO database
    session()->forget('purchase-orders');
    session()->forget('po-supplier');
}

public function getPONum(){
    $po_num = DB::table($this->table_po)
    ->max('po_num');
    $inc = ++ $po_num;
    return $inc;
}

public function getPrefix(){
    return $date = date('Y') . date('m');
 }

public function pdf(){

    $output = $this->convertProductDataToHTML();

    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($output);
    $pdf->setPaper('A4', 'landscape');

    return $pdf->stream();
}

public function downloadOrderPDF(){

    $output = $this->convertProductDataToHTML();

    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($output);
    $pdf->setPaper('A4', 'landscape');

    return $pdf->download();
}

public function getPOSupplier(){
    return session()->get('po-supplier');
}

public function convertProductDataToHTML(){
    $po = $this->getPORequest();
    $po_supplier = session()->get('po-supplier');
    $output = '
    <div style="width:100%">
    <p style="text-align:right;">Date: '. $this->getDate() .'</p>
    <h1 style="text-align:center;">'. $po_supplier .'</h1>
    <h3 style="text-align:center;">Purchase Order</h3>

    <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                  
        <thead>
            <tr>
                <th style="border: 1px solid;">Product Code</th>
                <th style="border: 1px solid;">Description</th>     
                <th style="border: 1px solid;">Category</th>
                <th style="border: 1px solid;">Unit</th>
                <th style="border: 1px solid;">Unit Price</th>   
                <th style="border: 1px solid;">Qty Order</th>   
                <th style="border: 1px solid;">Amount</th>   
        </thead>
        <tbody>
            ';

        if($po){
            foreach ($po as $product_code => $data) {
            
                $output .='
                <tr>                             
                <td style="border: 1px solid; padding:10px;">'. $data->product_code .'</td>
                <td style="border: 1px solid; padding:10px;">'. $data->description .'</td>
                <td style="border: 1px solid; padding:10px;">'. $data->category_name .'</td> 
                <td style="border: 1px solid; padding:10px;">'. $data->unit .'</td>  
                <td style="border: 1px solid; padding:10px;">'. number_format($data->selling_price,2,'.',',') .'</td>  
                <td style="border: 1px solid; padding:10px;">'. $data->qty .'</td>  
                <td style="border: 1px solid; padding:10px;">'. number_format($data->amount,2,'.',',') .' PhP</td>              
            </tr>
            ';
            
            } 
        }
        else{
            echo "No data found";
        }
    
      
        $output .='
        </tbody>
    </table>

        <p style="text-align:right;">Total: <b>'. number_format($this->getTotalAmount(),2,'.',',') .' PhP</b></p>
        </div>';

    return $output;
}



}
