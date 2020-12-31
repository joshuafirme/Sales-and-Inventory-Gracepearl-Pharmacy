<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\Sales;
use Illuminate\Http\Request;

class SalesCtr extends Controller
{
    private $table_sales = "tblsales";
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_emp = "tblemployee";
    private $table_unit = "tblunit";
    private $this_module = "Sales";

    public function index()
    {
    //     session()->forget('cart');
        if(!($this->isUserAuthorize())){
            dd('You are not authorized to access this module, please ask the administrator');
        }

        $getCurrenTransNo = $this->getCurrentTransacNo();
        return view('/sales/cashiering', ['getTransNo' => $getCurrenTransNo]);
   
    }
    

    public function isUserAuthorize(){
        $emp = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('auth_modules');

        $modules = explode(", ",$emp);

        if (!(in_array($this->this_module, $modules)))
        {
            return false;
        }
        else{
            return true;
        }
    }

    public function store(Request $request)
    {
        $product = new ProductMaintenance;

        $product->_prefix = $this->getPrefix();
        $product->description = $request->input('description');
        $product->categoryID = $request->input('categoryID');
        $product->supplierID = $request->input('supplierID');
        $product->qty = $request->input('qty');
        $product->re_order = $request->input('re_order');
        $product->orig_price = $request->input('orig_price');
        $product->selling_price = $request->get('selling_price');
        $product->exp_date = $request->input('exp_date');

        if(request()->hasFile('image')){
            request()->validate([
                'image' => 'file|image|max:5000',
            ]);
        }

        $product->save();
        $this->storeImage($product);

        return redirect('/maintenance/product')->with('success', 'Data Saved');
    }

    
    public function search($search_key)
    {
        if($search_key){
            $product = DB::table($this->table_prod)
            ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) as productCode'))
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->where(DB::raw('CONCAT(tblproduct._prefix, tblproduct.id)'), 'LIKE', '%'.$search_key.'%') // CONCAT 
            ->orWhere('description', 'LIKE', '%'.$search_key.'%')
            ->where('qty', '>=', 0)
            ->get();

            return $product;
        }
    
       
    }
    // add product to cart
    public function addToCart(){
            $product_code = Input::input('product_code');
            $qty_order = Input::input('qty_order');
            $total = Input::input('total');
            $date = $this->getDate();
            
            $p = $this->getProductInfo($product_code);
          
            $cart = session()->get('cart');
            if(!$cart) {
                $cart = [
                    $product_code => [             
                            "description" => $p->description,
                            "qty" => $qty_order,
                            "unit" => $p->unit,  
                            "unit_price" => $p->selling_price,  
                            "amount" => $total,
                            "date" => $date
                        ]
                ];
                
                session()->put('cart', $cart);
                return redirect()->back();
            }
 
            if(isset($cart[$product_code])) {
                $cart[$product_code]['qty'] += $qty_order;
                session()->put('cart', $cart);
                return redirect()->back();
            }
            
            $cart[$product_code] = [
                "description" => $p->description,
                "qty" => $qty_order,
                "unit" => $p->unit,  
                "unit_price" => $p->selling_price,  
                "amount" => $total,
                "date" => $date             
            ];
        
            session()->put('cart', $cart);
            return redirect()->back();
    }

    public function getProductInfo($product_code){

        $product = DB::table($this->table_prod)
        ->select("tblproduct.*", 'category_name', 'supplierName', 'unit')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->where(DB::raw('CONCAT(tblproduct._prefix, tblproduct.id)'), $product_code)
        ->first();

        return $product;
    }


    // remove item from cart
    public function void($product_code){
        $cart[$product_code]['qty'] --;
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function getCurrentTransacNo(){

        $transNo = DB::table($this->table_sales)
        ->max('transactionNo');

        $data = session()->get('transNo');
        $data += $transNo;
        $data++;
        session()->put('transNo', $data);

        return $this->getPrefix() . str_pad(session()->get('transNo'), 7,"0",STR_PAD_LEFT);
    }

    public function getPrefix(){
       return $date = $this->getYear() . $this->getMonth() . $this->getDay();
    }

    public function getYear(){
        return $year = date('yy');
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $month = date('d');
    }

    public function getSalesInvNo(){
        $sales_inv_no = DB::table($this->table_sales)
        ->max('sales_inv_no');
        $inc = ++ $sales_inv_no;
        return str_pad($inc, 5, '0', STR_PAD_LEFT);
    }

    public function isInvoiceExist($sales_inv_no){
        $invoice = DB::table($this->table_sales)
        ->where('sales_inv_no', $sales_inv_no);
        if($invoice->count() > 0){
            $s = 'yes';
        }
        else{
            $s = 'no';
        }
        return $s;
    }

    public function process(){

        $isSenior = Input::input('senior_chk');
        $sales_inv_no = Input::input('sales_inv_no');
        $senior_name = Input::input('senior_name');
      //  $sales_inv_no = $this->getSalesInvNo();

        if($isSenior == 'yes'){
            $this->updateSales($sales_inv_no);
            $this->recordSeniorInfo($senior_name, $sales_inv_no);
        }
        else if($isSenior == 'no'){
            $this->updateSales($sales_inv_no);
        }
       
        
        return redirect()->back();
    }

    public function forgetCart(){
        session()->forget('cart');
    }

    public function updateSales($sales_inv_no){

        $total_amount = 0;
        $sub_total = 0;

        if(session()->get('cart')){
            foreach (session()->get('cart') as $product_code => $data) {
            
                $sub_total = $data['qty'] * $data['unit_price'];
                $total_amount += $sub_total;
                $sales = new Sales;
                $sales->_prefix = $this->getPrefix();
                $sales->sales_inv_no = $sales_inv_no;
                $sales->product_code = $product_code;
                $sales->qty = $data['qty'];
                $sales->amount = $sub_total;       
                $sales->date = $data['date'];     
                $sales->employeeID = 20001;   
                $sales->order_from = "Walk-in";   
                $sales->save();   
                
                $this->updateInventory($sales->product_code, $sales->qty);
            } 
        }
        else{
            echo "No data found";
        }
    }

    public function updateInventory($product_code, $qty){
        
        DB::table($this->table_prod)
        ->where(DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), $product_code)
        ->update(array(
            'qty' => DB::raw('qty - '. $qty .'')));
    }

    public function checkQty($product_code){
        
        $qty = DB::table($this->table_prod)
        ->where(DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), $product_code)
        ->value('qty');

    }

    public function recordSeniorInfo($senior_name, $sales_inv_no){
        DB::table('tblsenior_citizen')->insert(
            [
                'sales_inv_no' => $sales_inv_no,
                'name' => $senior_name   
            ]
        );
    }

    public function pdf(){

        $output = $this->salesInvoice();
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A5', 'portrait');
        return $pdf->stream('Sales Invoice');
    }

    public function salesInvoice(){

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
        $total_amount = 0;
        $sub_total = 0;
        if(session()->get('cart')){
            foreach (session()->get('cart') as $product_code => $data) {
            
                $sub_total = $data['qty'] * $data['unit_price'];
                $total_amount += $sub_total;
            
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
            <td class="align-text">'. number_format($total_amount) .'</td>
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
            <td class="align-text">'. number_format($total_amount) .'</td>
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
