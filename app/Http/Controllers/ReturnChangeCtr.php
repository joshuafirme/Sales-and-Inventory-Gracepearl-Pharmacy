<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Input;
use App\ReturnChange;
use Illuminate\Http\Request;

class ReturnChangeCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $tbl_sales = "tblsales";

    public function index(){
        return  view('/inventory/return_change', ['getCurrentDate' => date('yy-m-d')]);
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
}
