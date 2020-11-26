<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\SupplierMaintenance;
use App\MarkupMaintenance;
use Illuminate\Http\Request;
use Input;

class SupplierMaintenanceCtr extends Controller
{
    private $table_name = "tblsupplier";
    private $table_company = "tblcompany";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $company = DB::table($this->table_company)->get();
        $suplr = DB::table($this->table_name)
        ->select("tblsupplier.*", DB::raw('CONCAT(tblsupplier._prefix, tblsupplier.id) AS supplierID, company_name'))
        ->leftJoin($this->table_company, $this->table_company . '.id', '=', $this->table_name . '.companyID')
        ->paginate(10);

        return view('maintenance/supplier/supplier', ['suplr' => $suplr, 'company' => $company]);
    }

   
    public function store()
    {
        $suplr = new SupplierMaintenance;
        $suplr->_prefix = 'SP-';
        $suplr->supplierName = Input::input('supplier_name');
        $suplr->address = Input::input('address');
        $suplr->email = Input::input('email');
        $suplr->person = Input::input('person');
        $suplr->contact = Input::input('contact');
        $suplr->companyID = Input::input('company');
 
        $suplr->save();

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suplr = DB::table($this->table_name)
        ->select("tblsupplier.*", DB::raw('CONCAT(tblsupplier._prefix, tblsupplier.id) AS supplierID, company_name'))
        ->leftJoin($this->table_company, $this->table_company . '.id', '=', $this->table_name . '.companyID')
        ->where('tblsupplier.id', $id)
        ->get();
        return $suplr;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $suplr = new SupplierMaintenance;
        $suplr->id = Input::get('id');
        $suplr->supplierName = Input::get('supplier_name');
        $suplr->address = Input::get('address');
        $suplr->email = Input::get('email');
        $suplr->person = Input::get('person');
        $suplr->contact = Input::get('contact');
        $suplr->companyID = Input::get('company');

        DB::update('UPDATE '. $this->table_name .' SET supplierName = ?,
                                                        address = ?,
                                                        email= ?,
                                                        person = ?,
                                                        contact = ?,
                                                        companyID = ?
                                                        WHERE id = ?',
        [$suplr->supplierName, $suplr->address, $suplr->email, $suplr->person, $suplr->contact, $suplr->companyID, $suplr->id]);

    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suplr = SupplierMaintenance::findOrFail($id);
        $suplr->delete();
        return $suplr;
    }

    public function getCompanyMarkup($id)
    {
        $suplr = DB::table($this->table_name)
        ->select("tblsupplier.*", DB::raw('CONCAT(tblsupplier._prefix, tblsupplier.id) AS supplierID, markup'))
        ->leftJoin($this->table_company, $this->table_company . '.id', '=', $this->table_name . '.companyID')
        ->where('tblsupplier.companyID', $id)
        ->get();
        return $suplr;
    }

    public function getCompanyID($id)
    {
        $suplr = DB::table($this->table_name)
        ->select("tblsupplier.*", DB::raw('CONCAT(tblsupplier._prefix, tblsupplier.id) AS supplierID, markup'))
        ->leftJoin($this->table_company, $this->table_company . '.id', '=', $this->table_name . '.companyID')
        ->where('tblsupplier.companyID', $id)
        ->get();
        return $suplr;
    }
    

    public function getDate(){
        $date = date('my');
        return $date;
    }
        
}
