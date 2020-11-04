<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\UnitMaintenance;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class UnitMaintenanceCtr extends Controller
{
    private $table_name = 'tblunit';

    public function index(){

        $unit = DB::table($this->table_name)->get();
        return view('/maintenance/unit/unit', ['unit' => $unit]);
    }

    public function store(Request $request)
    {    
        $unit = new UnitMaintenance;
        $unit->unit = $request->input('unit');
        $unit->save();

        return redirect('/maintenance/unit')->with('success', 'Data Saved');
    }

    public function edit($id)
    {
        $unit = DB::select('SELECT * FROM ' . $this->table_name . ' WHERE id = ?', [$id]);
        return $unit;
    }

    public function update($id)
    {
        $unit = Input::get('unit');

        DB::update('UPDATE '. $this->table_name .' 
        SET unit = ?
        WHERE id = ?',
        [
            $unit,
            $id
        ]);
    }

    public function destroy($id)
    {
        $unit = UnitMaintenance::findOrFail($id);
        $unit->delete();
        return $unit;
    }
}
