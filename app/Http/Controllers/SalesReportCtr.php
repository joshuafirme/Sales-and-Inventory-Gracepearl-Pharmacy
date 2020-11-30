<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Input;
use App\Sales;
use Illuminate\Http\Request;

class SalesReportCtr extends Controller
{
    private $table_sales = "tblsales";
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";

    public function index()
    {       
        return view('/sales/sales_report', ['currentDate' => $this->getDate()]);
    }

    public function getDate(){
        $date = date('yy-m-d');
        return $date;
    }

    public function displaySales(){
        $get_all_sales = $this->getAllSales();
        if(request()->ajax())
        {       
            return datatables()->of($get_all_sales)
            ->make(true);            
        }
    }

    public function displaySalesByDate(Request $request){
     //   $date_from = Input::input('date_from');
     //   $date_to = Input::input('date_to');

     //   $get_sales_by_date = $this->getSalesByDate($date_from, $date_to);
        if(request()->ajax())
        {       
            if($request->date_from){
                return datatables()->of($this->getSalesByDate($request->date_from, $request->date_to))
                ->make(true);      
            }
            else{
                return datatables()->of($this->getAllSales())
                ->make(true);      
            }
        }
    
        
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

    public function getSalesByDate($date_from, $date_to){
        // dd('test');
         $product = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, description, unit, supplierName, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
         ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
         ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
         ->whereBetween('date', [$date_from, $date_to])
         ->get();
 
         return $product;
     }
}
