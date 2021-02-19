<?php
namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Input;
use App\Sales;
use Illuminate\Http\Request;
use App\Classes\UserAccessRights;

class SalesReportCtr extends Controller
{

    private $table_sales = "tblsales";
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $module = "Sales";

    public function index(Request $request)
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }
               
        $category_name = DB::table($this->table_cat)->get();
        
        if(request()->ajax()){   
            if($request->category == 'All'){
                return datatables()->of($this->getSalesByDate($request->date_from, $request->date_to))
                ->make(true);  
            } 
            else{ 
                return datatables()->of($this->getSalesByDateAndCategory($request->date_from, $request->date_to, $request->category))
                ->make(true); 
            }  
           
        }
        return view('/sales/sales_report', 
        [
            'currentDate' => $this->getDate(),
            'category' => $category_name
        ]);     
    }

    public function computeSales(){

        $date_from = Input::input('date_from');
        $date_to = Input::input('date_to');
        $category = Input::input('category');
    
        return $this->getSales($date_from, $date_to, $category);
        
    }

    public function getTotalDiscount($date_from, $date_to)
    {
        return DB::table('tblorder_discount')
                ->sum('discount_amount');
            //    ->whereBetween('DATE(created_at)', [$date_from, date('Y-m-d', strtotime($date_to. ' + 1 days'))]);     
    }

    public function getTotalShippingFee($date_from, $date_to)
    {
        return DB::table('tblorder_shipping_fee')
                ->sum('shipping_fee');
              //  ->whereBetween('DATE(created_at)', [$date_from, date('Y-m-d', strtotime($date_to. ' + 1 days'))]);     
    }

     public function getSales($date_from, $date_to, $category){

        if($category == 'All'){
            $total_sales = DB::table($this->table_sales)
            ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, category_name'))
            ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->whereBetween('date', [$date_from, $date_to])
            ->sum('amount');
        }
        else{
            $total_sales = DB::table($this->table_sales)
            ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, category_name'))
            ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->whereBetween('date', [$date_from, $date_to])
            ->where('category_name', $category)
            ->sum('amount');
        }

        $total_discount = $this->getTotalDiscount($date_from, $date_to);
        $total_fee = $this->getTotalShippingFee($date_from, $date_to);
        return $total_sales + $total_discount + $total_fee;

     }

    public function getAllSales(){
       // dd('test');
        $product = DB::table($this->table_sales)
        ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, description, unit, supplierName, category_name'))
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->orderBy('date', 'desc')
        ->get();

        return $product;
    }

    public function getSalesByDateAndCategory($date_from, $date_to, $category){
        // dd('test');
         $product = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo,  DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
         ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
         ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
         ->whereBetween('date', [$date_from, $date_to])
         ->where('category_name', $category)
         ->get();
 
         return $product;
     }

     public function getSalesByDate($date_from, $date_to){
        // dd('test');
         $product = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo,  DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
         ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
         ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
         ->whereBetween('date', [$date_from, $date_to])
         ->get();
 
         return $product;
     }

    public function getDate(){
        return $date = $this->getYear().'-'.$this->getMonth().'-'.$this->getDay();
    }
     
    public function getYear(){
        return $year = date('yy')-100;
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $month = date('d');
    }


}
