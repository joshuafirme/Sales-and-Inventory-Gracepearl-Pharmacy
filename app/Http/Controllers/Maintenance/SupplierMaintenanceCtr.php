<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\SupplierMaintenance;
use App\MarkupMaintenance;
use Illuminate\Http\Request;
use Input;
use App\Classes\UserAccessRights;

class SupplierMaintenanceCtr extends Controller
{
    private $table_name = "tblsupplier";
    private $table_company = "tblcompany";
    private $table_emp = "tblemployee";
    private $module = "Maintenance";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            return view('/layouts.not_auth');
        }

        $suplr = DB::table($this->table_name)
        ->select("tblsupplier.*", DB::raw('CONCAT(tblsupplier._prefix, tblsupplier.id) AS supplierID'))
        ->paginate(10);

        return view('maintenance/supplier/supplier', ['suplr' => $suplr]);
    }

    public function isUserAuthorize(){
        $emp = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('auth_modules');

        $modules = explode(", ",$emp);

        if (!(in_array($this->this_module, $modules)))
        {
            return false;
        }
        else{
            return true;
        }
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
        ->select("tblsupplier.*", DB::raw('CONCAT(tblsupplier._prefix, tblsupplier.id) AS supplierID'))
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
    public function update(Request $request)
    {
        $suplr = new SupplierMaintenance;
        $suplr->id = $request->input('edit_id');
        $suplr->supplierName = $request->input('supplier_name');
        $suplr->address = $request->input('address');
        $suplr->email = $request->input('email');
        $suplr->person = $request->input('person');
        $suplr->contact = $request->input('contact');

        DB::table('tblsupplier')
        ->where('id', $suplr->id)
        ->update([
            'supplierName' => $suplr->supplierName,
            'address' => $suplr->address,
            'email' => $suplr->email,
            'person' => $suplr->person,
            'contact' => $suplr->contact
        ]);
        return redirect('/maintenance/supplier')->with('success', 'Data Saved');
    
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

    // get company ID to get company markup
    public function getCompanyID($supplierID)
    {
        $suplr = DB::table($this->table_name)
        ->where('tblsupplier.id', $supplierID)
        ->get();
        return $suplr;
    }

    

    public function getDate(){
        $date = date('my');
        return $date;
    }
        
}
