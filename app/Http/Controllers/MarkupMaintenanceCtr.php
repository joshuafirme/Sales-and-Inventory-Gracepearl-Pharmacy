<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\MarkupMaintenance;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class MarkupMaintenanceCtr extends Controller
{
    private $table_name = 'tblmarkup';
    private $table_suplr = 'tblsupplier';

    public function index(){

        $markup = DB::table($this->table_name)
        ->select("tblmarkup.*", DB::raw('tblmarkup.id AS id, supplierName'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_name . '.supplierID')
        ->get();
        return view('/maintenance/markup/markup', ['markup' => $markup]);
    }


    public function edit($id)
    {
        $markup = DB::table($this->table_name)
        ->select("tblmarkup.*", DB::raw('tblmarkup.id AS id, supplierName'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_name . '.supplierID') 
        ->where('tblmarkup.id', $id)
        ->get();
        return $markup;
    }

    public function update($id)
    {
        $markup = Input::get('markup');

        DB::update('UPDATE '. $this->table_name .' 
        SET markup = ?
        WHERE id = ?',
        [
            $markup,
            $id
        ]);
    }

    
    public function getSupplierMarkup($id){

        $markup = DB::table($this->table_name)
        ->select("tblmarkup.*", DB::raw('tblmarkup.id AS id, supplierName'))
        ->leftJoin($this->table_suplr, $this->table_suplr . '.id', '=', $this->table_name . '.supplierID')
        ->where('tblmarkup.supplierID', $id)
        ->get();
    }
}
