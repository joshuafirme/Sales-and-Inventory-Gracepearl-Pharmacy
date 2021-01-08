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

    public function getTotalSales($date_from, $date_to, $category){
          $total_sales = DB::table($this->table_sales)
            ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, category_name'))
            ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->whereBetween('date', [$date_from, $date_to])
            ->sum('amount');
         
          return $total_sales;
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
