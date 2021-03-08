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
                return datatables()->of($this->getSalesByDate($request->date_from, $request->date_to, $request->order_type))
                ->make(true);  
            } 
            else{ 
                return datatables()->of($this->getSalesByDateAndCategory($request->date_from, $request->date_to, $request->category, $request->order_type))
                ->make(true); 
            }  
           
        }
        return view('/sales/sales_report', 
        [
            'currentDate' => date('Y-m-d', strtotime(date('Y-m-d'). ' - 1 days')),
            'category' => $category_name
        ]);     
    }

    public function computeSales(){

        $date_from = Input::input('date_from');
        $date_to = Input::input('date_to');
        $category = Input::input('category');
        $order_type = Input::input('order_type');
    
        return $this->getSales($date_from, $date_to, $category, $order_type);
        
    }

    public function getTotalDiscount($date_from, $date_to)
    {
        return DB::table('tblorder_discount')
                ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                ->sum('discount_amount');    
    }

    public function getTotalShippingFee($date_from, $date_to)
    {
        return DB::table('tblorder_shipping_fee')
                ->whereBetween(DB::raw('DATE(created_at)'), [$date_from, $date_to])
                ->sum('shipping_fee');     
    }

     public function getSales($date_from, $date_to, $category, $order_type){

        $cat = $category == 'All' ? $category = ['Milk', 'Branded','Generic','Vitamins','Galenical','Cosmetic'] : [$category];

            $total_sales = DB::table($this->table_sales)
            ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo, category_name'))
            ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->whereIn('category_name', $cat)
            ->whereBetween('date', [$date_from, $date_to])
            ->whereIn('order_from', [$order_type])
            ->sum('amount');

            $total_discount = $this->getTotalDiscount($date_from, $date_to);
            $total_fee = 0;
            if($order_type == 'Online')
            {
                $total_fee = $this->getTotalShippingFee($date_from, $date_to); 
            }

            return ($total_sales - $total_discount) + $total_fee;
        

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

    public function getSalesByDateAndCategory($date_from, $date_to, $category, $order_type)
    {
        $cat = $category == 'All' ? $category = ['Milk', 'Branded','Generic','Vitamins','Galenical','Cosmetic'] : [$category];
        
         $product = DB::table($this->table_sales)
            ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo,  DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
            ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
            ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
            ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
            ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
            ->whereBetween('date', [$date_from, $date_to])
            ->whereIn('category_name', $cat)
            ->whereIn('order_from', [$order_type])
            ->get();
 
         return $product;
     }

     public function getSalesByDate($date_from, $date_to, $order_type){
        // dd('test');
         $product = DB::table($this->table_sales)
         ->select("tblsales.*", DB::raw('CONCAT(tblsales._prefix, tblsales.transactionNo) AS transNo,  DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
         ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
         ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
         ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
         ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
         ->whereBetween('date', [$date_from, $date_to])
         ->whereIn('order_from', [$order_type])
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

    public function computeTotalSales($date_from, $date_to, $category, $order_type)
    {
        $cat = $category == 'All' ? $category = ['Milk', 'Branded','Generic','Vitamins','Galenical','Cosmetic'] : [$category];

        $total_sales = DB::table('tblsales') 
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_sales . '.product_code')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->whereBetween('date', [$date_from, $date_to])
        ->whereIn('category_name', $cat)
        ->whereIn('order_from', [$order_type])
        ->sum('amount');

        $total_discount = $this->getTotalDiscount($date_from, $date_to);
        $total_fee = 0;
        if($order_type == 'Online')
        {
            $total_fee = $this->getTotalShippingFee($date_from, $date_to); 
        }

        return ($total_sales - $total_discount) + $total_fee;
    }

    public function previewReport($date_from, $date_to, $category, $order_type)
    {
        $sales = $this->getSalesByDateAndCategory($date_from, $date_to, $category, $order_type);
        $total_sales = $this->computeTotalSales($date_from, $date_to, $category, $order_type);

        $output = $this->convertProductDataToHTML($sales, $total_sales, $date_from, $date_to, $category, $order_type);
    
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($output);
        $pdf->setPaper('A4', 'landscape');
    
        return $pdf->stream();
    }
    
    public function convertProductDataToHTML($sales, $total_sales, $date_from, $date_to, $category, $order_type)
    {
        $cat = $category == "All" ? "All Category" : $category;
        $output = '
        <div style="width:100%">
        <p style="text-align:right;">Date: '. date("M/d/Y", strtotime($date_from)) .' - '. date("M/d/Y", strtotime($date_to)).'</p>
        <h1 style="text-align:center;">Sales Report</h1>
        <h2 style="text-align:center;">'. $cat .'</h2>
    
        <p style="text-align:right;">Total: <b style="font-size: 22px;">'. number_format($total_sales,2,'.',',') .' PhP</b></p>

        <table width="100%" style="border-collapse:collapse; border: 1px solid;">
                      
            <thead>
                <tr>
                    <th style="border: 1px solid;">Sales Invoice #</th>    
                    <th style="border: 1px solid;">Product Code</th>    
                    <th style="border: 1px solid;">Description</th>     
                    <th style="border: 1px solid;">Category</th>
                    <th style="border: 1px solid;">Unit</th>
                    <th style="border: 1px solid;">Qty</th>  
                    <th style="border: 1px solid;">Amount</th>   
                    <th style="border: 1px solid;">Payment Method</th> 
                    <th style="border: 1px solid;">Date</th> 
            </thead>
            <tbody>
                ';
    
            if($sales){
                foreach ($sales as $data) {
                
                    $output .='
                    <tr>  
                    <td style="border: 1px solid; padding:10px;">'. $data->sales_inv_no.'</td>      
                    <td style="border: 1px solid; padding:10px;">'. $data->product_code .'</td>                     
                    <td style="border: 1px solid; padding:10px;">'. $data->description .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->category_name.'</td>  
                    <td style="border: 1px solid; padding:10px;">'. $data->unit .'</td>
                    <td style="border: 1px solid; padding:10px;">'. $data->qty .'</td>  
                    <td style="border: 1px solid; padding:10px;">'. number_format($data->amount,2,'.',',') .' PhP</td> 
                    <td style="border: 1px solid; padding:10px;">'. $data->payment_method .'</td>       
                    <td style="border: 1px solid; padding:10px;">'. $data->date .'</td>              
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
    
            </div>';
    
        return $output;
    }
}
