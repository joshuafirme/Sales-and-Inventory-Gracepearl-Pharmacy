<?php

namespace App\Http\Controllers;
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

    public function index()
    {
        //session()->forget('cart');
        //dd(session()->get('cart'));
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
            ->orWhere('qty', '>=', 0)
            ->get();

            return $product;
        }
    
       
    }
    // add product to cart
    public function addToCart(){
            $product_code = Input::input('product_code');
            $description = Input::input('description');
            $qty_order = Input::input('qty_order');
            $price = Input::input('price');
            $total = Input::input('total');
            $date = $this->getDate();

            $cart = session()->get('cart');
            if(!$cart) {
                $cart = [
                    $product_code => [
                            "description" => $description,
                            "qty" => $qty_order,
                            "unit_price" => $price,   
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
        
                "description" => $description,
                "qty" => $qty_order,
                "unit_price" => $price,   
                "amount" => $total,
                "date" => $date
            ];
        
            session()->put('cart', $cart);
            return redirect()->back();
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
       
        session()->forget('cart');
        return redirect()->back();
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

    public function getDate(){
        $date = date('yy-m-d');
        return $date;
    }
}
