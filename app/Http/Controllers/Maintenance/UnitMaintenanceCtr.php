<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\UnitMaintenance;
use Input;
use Illuminate\Http\Request;
use App\Classes\UserAccessRights;

class UnitMaintenanceCtr extends Controller
{
    private $table_name = 'tblunit';
    private $table_emp = "tblemployee";
    private $module = "Maintenance";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $unit = DB::table($this->table_name)->get();
        return view('/maintenance/unit/unit', ['unit' => $unit]);
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
        $unit = Input::input('unit');

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
