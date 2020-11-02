<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\SupplierMaintenance;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $suplr = new SupplierMaintenance;
        $suplr->_prefix = 'SP-';
        $suplr->supplierName = $request->input('supplierName');
        $suplr->address = $request->input('address');
        $suplr->person = $request->input('person');
        $suplr->contact = $request->input('contact');

        $suplr->save();

        return redirect('/maintenance/supplier')->with('success', 'Data Saved');
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
        $suplr->person = Input::get('person');
        $suplr->contact = Input::get('contact');

        DB::update('UPDATE '. $this->table_name .' SET supplierName = ?,
                                                        address = ?,
                                                        person = ?,
                                                        contact = ?
                                                        WHERE id = ?',
        [$suplr->supplierName, $suplr->address, $suplr->person, $suplr->contact, $suplr->id]);

    
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

    public function action(Request $request){

        if($request->ajax()){
            if($request->action == 'Edit'){
                $data = array(
                    'supplierName' => $request->supplierName,
                    'address' => $request->address,
                    'person' => $request->person,
                    'contact' => $request->contact
                );
          
                DB::table($table_name)
                ->where('id', $request->supplierID)
                ->update($data);
            }


            if($request->action == 'delete'){
               
                DB::table($table_name)
                ->where('id', $request->supplierID)
                ->delete();
            }
        }

        return request()->json($request);
    }

    public function getDate(){
        $date = date('my');
        return $date;
    }
        
}
