<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\Sales;
use Illuminate\Http\Request;
use App\Classes\UserAccessRights;
use App\Classes\CashieringInvoice;
use App\Classes\Date;

class SalesCtr extends Controller
{
    private $table_sales = "tblsales";
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_emp = "tblemployee";
    private $table_unit = "tblunit";
    private $module = "Sales";

    public function index()
    {
       // dd(session()->get('cart'));
      //  session()->forget('cart');
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $getCurrenTransNo = $this->getCurrentTransacNo();
        return view('/sales/cashiering', ['getTransNo' => $getCurrenTransNo]);
   
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
                "category" => $p->category_name,  
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

    public function void()
    {
        $product_code = Input::input('product_code');
        $cart = session()->get('cart');
        if(isset($cart[$product_code])){
            unset($cart[$product_code]);  
        }
        session()->put('cart', $cart);
        return redirect()->back();
    }

    public function credentialBeforeVoid(){

        $username = Input::input('username');
        $password = Input::input('password');

        $emp = DB::table($this->table_emp)
        ->where([
            ['username', $username],
            ['password', $password],
            ['position', 'Administrator']
        ])
        ->get();
        
        

        if($emp->count() > 0){
            return 'success';
        }
        else{
            return 'invalid';
        }
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

    public function getDate(){   
        $d = new Date;
        return $d->getDate();
    }
     
    public function getYear(){
        return $year = date('yy')-100;
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $day = date('d');
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
    //    $senior_name = Input::input('senior_name');
      //  $sales_inv_no = $this->getSalesInvNo();

        if($isSenior == 'yes'){
            $this->updateSales($sales_inv_no);
         //   $this->recordSeniorInfo($senior_name, $sales_inv_no);
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
        return $pdf->stream('Invoice-#'.$this->getSalesInvNo().'.pdf');
    }

    public function salesInvoice(){

       $c = new CashieringInvoice;
       return $c->getSalesInvoice();
    }


}
