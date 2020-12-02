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

    public function index(Request $request)
    {       
        $total_sales = $this->getTotalSales($request->date_from, $request->date_to, $request->category);
     
        if(request()->ajax())
        {       
       
                return datatables()->of($this->getSalesByDate($request->date_from, $request->date_to, $request->category))
                ->make(true);   
          
        }
        $category = DB::table($this->table_cat)->get();
      

        
        return view('/sales/sales_report', 
        [
            'currentDate' => $this->getDate(),
            'category' => $category,
            'totalSales' => $total_sales
        ]);
    }

    public function getTotalSales($date_from, $date_to, $category){
         $total_sales = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
         ->whereBetween('date', [$date_from, $date_to])
         ->where('category_name', $category)
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

    public function getSalesByDate($date_from, $date_to, $category){
        // dd('test');
         $product = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, description, unit, supplierName, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
         ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
         ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
         ->whereBetween('date', [$date_from, $date_to])
         ->where('category_name', $category)
         ->get();
 
         return $product;
     }

     
    public function getDate(){
        $date = date('yy-m-d');
        return $date;
    }


}
