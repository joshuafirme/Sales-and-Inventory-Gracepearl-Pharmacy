<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use Mail;
use App\Mail\MyMail;
use Luigel\Paymongo\Facades\Paymongo;
use Illuminate\Support\Str;
use App\ProductMaintenance;
use App\PurchaseOrder;

class PurchaseOrderCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_po = "tblpurchaseorder";

    public function index(Request $request)
    {
        //session()->forget('orders');
        $category_param = $request->category;
        $get_all_reorder = $this->getAllReorder(); 
       

        $unit = DB::table($this->table_unit)->get();
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
        //
        $get_all_orders = $this->getAllOrders();
        $reorder_count = $get_all_reorder->count(); 
       
        return view('/inventory/purchase_order', 
            [
            'product' => $get_all_reorder,
            'unit' => $unit,
            'category' => $category,
            'suplr' => $suplr,
            'reorderCount' => $reorder_count,
            'getAllOrders' => $get_all_orders,
            'getCurrentDate' => date('yy-m-d')
            ]);
    }

    public function displayReorders(){
        
        $get_all_reorder = $this->getAllReorder();
        
        if(request()->ajax())
        {       
            return datatables()->of($get_all_reorder)
            ->addColumn('action', function($product){
                $button = '<a class="btn" id="btn-add-order" product-code='. $product->id .' data-toggle="modal" data-target="#purchaseOrderModal"><i class="fa fa-cart-plus"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);            
        }
    }

    public function displayOrders(){
        $get_all_orders = $this->getAllOrders();
        if(request()->ajax())
        {       
            return datatables()->of($get_all_orders)
            ->addColumn('status', function($orders){
                if($orders->status == 'Completed'){
                    $button = '<span class="badge badge-success">Completed</span>';     
                    return $button;
                }
                else if($orders->status == 'Partial'){
                    $button = '<span style="color:#fff;" class="badge badge-warning">Partial</span>';     
                    return $button;
                }
                else if($orders->status == 'Pending'){
                    $button = '<span class="badge" style="background-color:#337AB7; color:#fff;">Pending</span>';     
                    return $button;
                }
            })
            ->rawColumns(['status'])
            ->make(true);           
        }
    }

    public function pay(){

     /*   $source = Paymongo::source()->create([
            'type' => 'gcash',
            'amount' => 100.00,
            'currency' => 'PHP',
            'redirect' => [
                'success' => route('pay'),
                'failed' => route('pay')
            ]
        ]);
       // dd($source);
      //  dd($source->getRedirect()['checkout_url']);
        return redirect($source->getRedirect()['checkout_url']);
        */
    }


    public function sendMail(){
        $data = $this->convertProductDataToHTML();

        $email = Input::input('supplier_email');
        Mail::to($email)
        ->send(new MyMail($data));
        
        // after email sent, it will automatically save orders to database
        $this->recordOrder();
    }

    public function getSupplierEmail($supplier){
        $supplier = DB::table($this->table_suplr)
        ->where('supplierName', $supplier)
        ->value('email');

        return $supplier;
    }

    public function getAllReorder(){
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, supplierName, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->whereColumn('tblproduct.re_order','>=', 'tblproduct.qty')
        ->get();

        return $product;
    }
    
    public function getAllOrders(){
        $product = DB::table($this->table_po)
        ->select("tblpurchaseorder.*", DB::raw('CONCAT('.$this->table_po.'._prefix, '.$this->table_po.'.po_num) AS po_num, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_po . '.product_code')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->orderBy('date', 'desc')
        ->get();

        return $product;
    }

    public function show($product_code){
        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode, unit, supplierName, category_name'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->where('tblproduct.id', $product_code)
        ->get();
 

        return $product;
    }

    public function filterSupplier($supplier){
  
        $orders = session()->get('orders');
        
        $arr = ['data' => $orders];

        return $arr;
    }

    public function addToOrder(){

        $product_code = Input::input('product_code');
        $description = Input::input('description');
        $category = Input::input('category');
        $unit = Input::input('unit');
        $supplier = Input::input('supplier');
        $qty_order = Input::input('qty_order');
        $price = Input::input('price');
        $amount = Input::input('amount');

        $orders = session()->get('orders');
        if(!$orders) {
            $orders = [
                $product_code => [
                        "description" => $description,
                        "category" => $category,
                        "unit" => $unit,
                        "supplier" => $supplier,
                        "qty_order" => $qty_order,
                        "price" => $price,   
                        "amount" => $amount
                    ]
            ];
            
            session()->put('orders', $orders);
            return redirect()->back()->with('success', 'Product added to order successfully!');
        }

        if(isset($orders[$product_code])) {
            $orders[$product_code]['qty_order'] += $qty_order;
            session()->put('orders', $orders);
            return redirect()->back()->with('success', 'Product added to orders successfully!');
        }
        
        $orders[$product_code] = [
    
            "description" => $description,
            "category" => $category,
            "unit" => $unit,
            "supplier" => $supplier,
            "qty_order" => $qty_order,
            "price" => $price,   
            "amount" => $amount
        ];
    
        session()->put('orders', $orders);


        return redirect()->back()->with('success', 'Product added to cart successfully!');
}

public function recordOrder(){
    $sub_total = 0;
    $total_amount = 0;
    $po_num = $this->getPONum();
    if(session()->get('orders')){
        foreach (session()->get('orders') as $product_code => $data) {

            $sub_total = $data['qty_order'] * $data['price'];
            $total_amount += $sub_total;
           
            $po = new PurchaseOrder;
            $po->_prefix = 'PO' . $this->getPrefix();
            $po->po_num = $po_num;
            $po->product_code = $product_code;
            $po->qty_order = $data['qty_order'];
            $po->amount = $sub_total;       
            $po->date = date('yy-m-d');  
            $po->status = 'Pending';    
            $po->save();     
        } 
    }
    // remove request orders after save to PO database
    session()->forget('orders');
}

public function getPONum(){
    $po_num = DB::table($this->table_po)
    ->max('po_num');
    $inc = ++ $po_num;
    return $inc;
}

public function getPrefix(){
    return $date = $this->getMonth() . $this->getDay();
 }

 public function getYear(){
     return $year = date('y');
 }

 public function getMonth(){
     return $month = date('m');
 }

 public function getDay(){
     return $month = date('d');
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

public function convertProductDataToHTML(){

    $output = '
    <div style="width:100%">
    <p style="text-align:right;">Date: '. $this->getDate() .'</p>
    
    <h2 style="text-align:center;">Request Order</h2>

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
    $total_amount = 0;
    $sub_total = 0;
    if(session()->get('orders')){
        foreach (session()->get('orders') as $product_code => $data) {
        
            $sub_total = $data['qty_order'] * $data['price'];
            $total_amount += $sub_total;
        
            $output .='
            <tr>                             
            <td style="border: 1px solid; padding:10px;">'. $product_code .'</td>
            <td style="border: 1px solid; padding:10px;">'. $data['description'] .'</td>
            <td style="border: 1px solid; padding:10px;">'. $data['category'] .'</td> 
            <td style="border: 1px solid; padding:10px;">'. $data['unit'] .'</td>  
            <td style="border: 1px solid; padding:10px;">'. number_format($data['price']) .'</td>  
            <td style="border: 1px solid; padding:10px;">'. $data['qty_order'] .'</td>  
            <td style="border: 1px solid; padding:10px;">'. number_format($sub_total) .' PhP</td>              
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
  <p style="text-align:right;">Total: '. number_format($total_amount) .' PhP</p>
  </div>';

    return $output;
}

public function getDate(){
    $date = date('m-d-yy');
    return $date;
}

}
