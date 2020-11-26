<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use Mail;
use App\Mail\MyMail;
use Luigel\Paymongo\Facades\Paymongo;
use App\ProductMaintenance;

class PurchaseOrderCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";

    public function index(Request $request)
    {
        //session()->forget('orders');
        $category_param = $request->category;
        $product = $this->getAllReorder(); 
        $reorder_count = $product->count(); 

        $unit = DB::table($this->table_unit)->get();
        $category = DB::table($this->table_cat)->get();
        $suplr = DB::table($this->table_suplr)->get();
        
       
        return view('/inventory/purchase_order', 
            [
            'product' => $product,
            'unit' => $unit,
            'category' => $category,
            'suplr' => $suplr,
            'reorderCount' => $reorder_count
            ]);
    }

public function gcashPayment(){

    $gcashSource = Paymongo::source()->create([
        'type' => 'gcash',
        'amount' => 100.00,
        'currency' => 'PHP',
        'redirect' => [
            'success' => route('/inventory/purchaseorder'),
            'failed' => route('/inventory/purchaseorder')
        ]
    ]);
    //dd($gcashSource);

    return $gcashSource;
}




    public function sendMail(){
        $data = $this->convertProductDataToHTML();

        $email = Input::input('supplier_email');
        Mail::to($email)
        ->send(new MyMail($data));
    }

    public function getSupplierEmail($supplier_id){
        $supplier = DB::table($this->table_suplr)
        ->where('id', $supplier_id)
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

    public function addToOrder(){

        $product_code = Input::get('product_code');
        $description = Input::get('description');
        $category = Input::get('category');
        $unit = Input::get('unit');
        $supplier = Input::get('supplier');
        $qty_order = Input::get('qty_order');
        $price = Input::get('price');
        $amount = Input::get('amount');

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
