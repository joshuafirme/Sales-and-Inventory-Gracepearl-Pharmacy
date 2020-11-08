<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\SupplierMaintenance;
use App\MarkupMaintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class SupplierMaintenanceCtr extends Controller
{
    private $table_name = "tblsupplier";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $suplr = DB::table($this->table_name)
                                ->select("*", DB::raw('CONCAT(_prefix, id) AS supplierID'))
                                ->paginate(10);

        return view('maintenance/supplier/supplier', ['suplr' => $suplr]);
    }

   
    public function store()
    {

        $suplr = new SupplierMaintenance;
        $suplr->_prefix = 'SP-';
        $suplr->supplierName = Input::get('supplier_name');
        $suplr->address = Input::get('address');
        $suplr->email = Input::get('email');
        $suplr->person = Input::get('person');
        $suplr->contact = Input::get('contact');
        $suplr->save();

        $id = $suplr->id;
        $markup = Input::get('markup');
        $this->storeToMarkupMaintenance($id, $markup);

    }

    public function storeToMarkupMaintenance($supplierID, $markup){
        DB::table('tblmarkup')->insert(
            ['supplierID' => $supplierID, 'markup' => $markup]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suplr = DB::select('SELECT * FROM ' . $this->table_name . ' WHERE id = ?', [$id]);
        return view('maintenance/supplier/update_supplier', ['suplr' => $suplr]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suplr = DB::select('SELECT * FROM ' . $this->table_name . ' WHERE id = ?', [$id]);
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

        DB::update('UPDATE '. $this->table_name .' SET supplierName = ?,
                                                        address = ?,
                                                        email= ?,
                                                        person = ?,
                                                        contact = ?
                                                        WHERE id = ?',
        [$suplr->supplierName, $suplr->address, $suplr->email, $suplr->person, $suplr->contact, $suplr->id]);

    
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
        $this->destroyMarkup($id);
        return $suplr;
    }

    public function destroyMarkup($id)
    {
        $markup = DB::table('tblmarkup')->where('supplierID', '=', $id)->delete();
        $markup->delete();
    }

    

    public function getDate(){
        $date = date('my');
        return $date;
    }
        
}
