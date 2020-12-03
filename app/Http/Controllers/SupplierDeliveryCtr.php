<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Input;
use App\ProductMaintenance;
use App\SupplierDelivery;

class SupplierDeliveryCtr extends Controller
{
    private $table_prod = "tblproduct";
    private $table_cat = "tblcategory";
    private $table_suplr = "tblsupplier";
    private $table_unit = "tblunit";
    private $table_stockad = "tblstockadjustment";
    private $table_po = "tblpurchaseorder";
    private $table_delivery = "tblsupplierdelivery";

    public function index()
    { 
        return view('inventory/supplier_delivery');
    }

    public function displayPurchaseOrder(){
        $po = $this->getPurchaseOrder();
        
        if(request()->ajax())
        {       
            return datatables()->of($po)
            ->addColumn('action', function($po){
                $button = '<a class="btn btn-sm btn-success" id="btn-add-delivery" product-code='. $po->po_num .' 
                data-toggle="modal" data-target="#qtyDeliverModal" title="click here" style="color:#fff;"><i class="fas fa-plus"></i></a>';

                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);            
        }
    }

    public function getPurchaseOrder()
     {
        $product = DB::table($this->table_po)
        ->select("tblpurchaseorder.*", DB::raw('CONCAT('.$this->table_po.'._prefix, '.$this->table_po.'.po_num) AS po_num, description, unit, supplierName, category_name'))
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_po . '.product_code')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->get();

        return $product;
     }
 

    public function recordDelivery(){
 
             $sd = new SupplierDelivery;
 
             $sd->_prefix = $this->getPrefix();
             $sd->delivery_num = $this->getDeliveryNumWithPrefix();
             $sd->product_code = Input::input('product_code');
             $sd->qty_delivered = Input::input('qty_delivered');
             $sd->exp_date = Input::input('exp_date');
             $sd->date_delivered = Input::input('date_recieved');
             $sd->amount = Input::input('amount');
             $sd->remarks = Input::input('remarks');
             $sd->save();

             $this->updatePurchaseOrder();
             $this->checkPOQty();
     
     }

     public function updatePurchaseOrder($po_num, $qty){
 
        $sd = new SupplierDelivery;

        $sd->_prefix = $this->getPrefix();
        $sd->delivery_num = $this->getDeliveryNumWithPrefix();
        $sd->product_code = Input::input('product_code');
        $sd->qty_delivered = Input::input('qty_delivered');
        $sd->exp_date = Input::input('exp_date');
        $sd->date_delivered = Input::input('date_recieved');
        $sd->amount = Input::input('amount');
        $sd->remarks = Input::input('remarks');
        $sd->save();

}

     public function getDelivery()
     {
        $product = DB::table($this->table_po)
        ->select("tblsupplier_delivery.*", DB::raw('CONCAT('.$this->table_po.'._prefix, '.$this->table_po.'.po_num) AS po_num, description, unit, supplierName, category_name'))
        ->leftJoin($this->table_prod,  DB::raw('CONCAT('.$this->table_prod.'._prefix, '.$this->table_prod.'.id)'), '=', $this->table_po . '.product_code')
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_prod . '.supplierID')
        ->leftJoin($this->table_cat, $this->table_cat . '.id', '=', $this->table_prod . '.categoryID')
        ->leftJoin($this->table_unit, $this->table_unit . '.id', '=', $this->table_prod . '.unitID')
        ->get();

        return $product;
     }

     
     public function show($product_code)
     {
         $product = DB::table($this->tbl_prod)
             ->select("tblproduct.*", DB::raw('CONCAT(tblproduct._prefix, tblproduct.id) AS productCode'))
             ->leftJoin($this->tbl_suplr, $this->tbl_suplr . '.id', '=', $this->tbl_prod . '.supplierID')
             ->leftJoin($this->tbl_cat, $this->table_cat . '.id', '=', $this->tbl_prod . '.categoryID')
             ->where('tblproduct.id', $productCode)
             ->get();
 
             return $product;
     }

     public function getDeliveryNumWithPrefix(){
        
        return $this->getDeliveryNumPrefix() . $this->getDeliveryNum();
    }
    
    public function getDeliveryNum(){
        $del_num = DB::table($this->table_po)
        ->max('po_num');
        return ++ $del_num;
    }

    public function getDeliveryNumPrefix(){
        return 'DELI-' . $this->getDate() .'-';
    }

    public function getDate(){
        return $date = $this->getYear() . $this->getMonth() . $this->getDay();
    }

    public function getYear(){
        return $year = date('y');
    }

    public function getMonth(){
        return $month = date('m');
    }

    public function getDay(){
        return $month = date('d');
    }
}
