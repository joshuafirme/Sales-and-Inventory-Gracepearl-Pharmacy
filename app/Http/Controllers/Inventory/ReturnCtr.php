<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Input;
use App\Sales;
use App\ReturnChange;
use Illuminate\Http\Request;
use App\Classes\UserAccessRights;

class ReturnCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_exp = "tblexpiration";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_sales = "tblsales";
    private $tbl_return = "tblreturn_change";
    private $module = "Inventory";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        return  view('/inventory/return', ['getCurrentDate' => date('Y-m-d')]);
    }

    public function searchSalesInvoice()
    {
        $sales_inv_no = Input::input('sales_inv_no');

        $sales = DB::table($this->tbl_sales)
        ->select('product_code')
        ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_sales. '.product_code')
        ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
        ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
        ->where('sales_inv_no', 'LIKE', '%' . $sales_inv_no . '%') 
        ->distinct('product_code')
        ->get();  

        return $sales;      

    }

    public function searchProdAndInv()
    {
        $sales_inv_no = Input::input('sales_inv_no');
        $product_code = Input::input('product_code');

        $sales = DB::table($this->tbl_sales)
        ->select('product_code', 'description', 'unit', 'category_name', 'selling_price', 'tblsales.amount', 'tblsales.qty')
        ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_sales. '.product_code')
        ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
        ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
        ->where([
            ['sales_inv_no', 'LIKE', '%' . $sales_inv_no . '%'],
            ['product_code', 'LIKE', '%' . $product_code . '%'],
        ])
        ->get();  

        return $sales;      

    }


    public function displayReturns(){
        
        $get_returns = $this->getReturns();
        
        if(request()->ajax())
        {       
            return datatables()->of($get_returns)
            ->make(true);            
        }
    }


    public function getReturns(){
        $ret = DB::table($this->tbl_return)
        ->select($this->tbl_return.".*", DB::raw('CONCAT('.date('y').', '.$this->tbl_return.'.id) AS returnID, DATE_FORMAT(date,"%d-%m-%Y") as date, description, unit, supplierName, category_name'))
        ->leftJoin($this->tbl_prod,  DB::raw('CONCAT('.$this->tbl_prod.'._prefix, '.$this->tbl_prod.'.id)'), '=', $this->tbl_return . '.product_code')
        ->leftJoin($this->tbl_suplr, $this->tbl_suplr . '.id', '=', $this->tbl_prod . '.supplierID')
        ->leftJoin($this->tbl_cat, $this->tbl_cat . '.id', '=', $this->tbl_prod . '.categoryID')
        ->leftJoin($this->tbl_unit, $this->tbl_unit . '.id', '=', $this->tbl_prod . '.unitID')
        ->get();

        return $ret;
    }


    public function returnItem()
    {
        $sales_inv_no = Input::input('sales_inv_no');
        $product_code = Input::input('product_code');
        $exp_date = Input::input('exp_date');
        $qty_return = Input::input('qty_return');
        $reason = Input::input('reason');
        $date = Input::input('date');

        if($reason == 'Damaged' || $reason == 'Expired'){
            $this->recordReturn($sales_inv_no, $product_code, $qty_return, $reason, $date);
            $this->updateSales($sales_inv_no, $product_code);
        }
        else if($reason == 'Wrong Item'){
            $this->recordReturn($sales_inv_no, $product_code, $qty_return, $reason, $date);
            $this->updateInventory($product_code, $qty_return, $exp_date);
            $this->updateSales($sales_inv_no, $product_code);
        }        

    }

    public function recordReturn($sales_inv_no, $product_code, $qty_return, $reason, $date){
        $rc = new ReturnChange;
        $rc->sales_inv_no = $sales_inv_no;
        $rc->product_code = $product_code;
        $rc->qty = $qty_return;  
        $rc->reason = $reason; 
        $rc->date = $date;  
        $rc->save();     
    }

    public function updateInventory($product_code, $qty_return, $exp_date){
            DB::table($this->tbl_exp.' as E')
            ->where('product_code', $product_code)
            ->where('exp_date', $exp_date)
            ->update(array(
                'qty' => DB::raw('qty + '. $qty_return .'')));
    }

    public function updateSales($sales_inv_no, $product_code){
        DB::table($this->tbl_sales)
        ->where('sales_inv_no', $sales_inv_no)
        ->where('product_code', $product_code)
        ->delete();
}
}
