<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\Sales;
use App\OrderDiscount;
use App\Cashiering;
use Illuminate\Http\Request;
use App\Classes\UserAccessRights;
use App\Classes\CashieringInvoice;
use App\Classes\Date;

class SalesCtr extends Controller
{
    private $table_sales = "tblsales";
    private $table_prod = "tblproduct";
    private $table_exp = "tblexpiration";
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
        return view('/sales/cashiering', [
            'getTransNo' => $getCurrenTransNo,
            'getProduct' => $this->getCashieringProduct(),
            'getTotalAmount' => $this->getTotalAmount()
            ]);
   
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
            $product = DB::table($this->table_exp.' AS E')
            ->select("E.*",
                     'P.description',
                     'P.re_order', 
                     'P.orig_price', 
                     'P.selling_price', 
                     'E.qty', 
                     'category_name', 
                     DB::raw('DATE_FORMAT(E.exp_date,"%d-%m-%Y") as exp_date'))
                ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'E.product_code')
                ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
                ->where('E.archive_status', 0)               
                ->where('E.qty', '>', 0)
               // ->where('E.product_code', 'LIKE', '%'.$search_key.'%') // CONCAT 
                ->where('P.description', 'LIKE', '%'.$search_key.'%')
                ->orderBy('E.exp_date') // First expiry first out
                ->get();

            return $product;
        }
    
       
    }
 
    
    public function addToCart(){
  
            $product_code = Input::input('product_code');
            $qty = Input::input('qty_order');
            $total = Input::input('total');
           
            if($this->isProductExists($product_code)){
                DB::table('tblcashiering')
                ->where('product_code', $product_code)
                ->update(array(
                    'amount' => DB::raw('amount + '. $total),
                    'qty' => DB::raw('qty + '. $qty)));
            }
            else{
                $c = new Cashiering;
                $c->product_code = $product_code;
                $c->qty = $qty;
                $c->amount = $total;
                $c->save();
            }
    }

    public function isProductExists($product_code){
        $p = DB::table('tblcashiering')->where('product_code', $product_code);
        if($p->count() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getTotalAmount(){
        return DB::table('tblcashiering')->sum('amount');
    }

    public function getGenericTotalAmount(){
        return DB::table('tblcashiering as CS')
                ->leftJoin($this->table_prod.' AS P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'CS.product_code')
                ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
                ->where('C.category_name', 'Generic')
                ->sum('amount');
    }

    public function void()
    {
        $product_code = Input::input('product_code');
        DB::table('tblcashiering')->where('product_code', $product_code)->delete();
    }

    public function process(){
        session()->forget('walkin-discount');
        $sales_inv_no = Input::input('sales_inv_no'); 
        $discount = Input::input('less_discount'); 
        $payment_method = Input::input('payment_method'); 

        if($discount){
            $this->storeDiscount($discount, $sales_inv_no);
        }

        foreach($this->getCashieringProduct() as $data){
            $sales = new Sales;
            $sales->_prefix = $this->getPrefix();
            $sales->sales_inv_no = $sales_inv_no;
            $sales->product_code = $data->product_code;
            $sales->qty = $data->qty;
            $sales->amount = $data->amount;       
            $sales->date = date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 days')); 
            $sales->payment_method = $payment_method;    
          //  $sales->employeeID = 20001;   
            $sales->order_from = "Walk-in";   
            $sales->save(); 
            
            $this->updateInventory($sales->product_code, $sales->qty);
        }
 
    }

    public function storeDiscount($discount, $sales_inv_no){
        session()->put('walkin-discount', $discount);
        DB::table('tblorder_discount')
            ->insert([
                'discount_amount' => $discount,
                'sales_inv_no' => $sales_inv_no,
                'created_at' => date('Y-m-d h:m:s')
            ]);
      }

    public function getCashieringProduct(){

        $product = DB::table('tblcashiering as CS')
        ->select("CS.*", 'description', 'selling_price', 'category_name', 'unit')
        ->leftJoin($this->table_prod.' as P', DB::raw('CONCAT(P._prefix, P.id)'), '=', 'CS.product_code')
        ->leftJoin($this->table_cat.' AS C', 'C.id', '=', 'P.categoryID')
        ->leftJoin($this->table_unit.' AS U', 'U.id', '=', 'P.unitID')
        ->get();

        return $product;
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

 /*   public function process(){

        $sales_inv_no = Input::input('sales_inv_no'); 
        $discount = Input::input('less_discount'); 
        $this->updateSales($sales_inv_no);

        if($discount){
            $this->storeDiscount($discount);
        }
 
        return redirect()->back();
    }

    public function forgetCart(){
        session()->forget('cart');
    }*/

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
        
        DB::table($this->table_exp)
        ->where('product_code', $product_code)
        ->update(array(
            'qty' => DB::raw('qty - '. $qty .'')));
    }

    public function checkQty($product_code){
        
        $qty = DB::table($this->table_prod.' as P')
        ->where(DB::raw('CONCAT(P._prefix, P.id)'), $product_code)
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
       return $c->getSalesInvoice($this->getCashieringProduct(), session()->get('walkin-discount'));
    }



}
