<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\CompanyMaintenance;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class CompanyMaintenanceCtr extends Controller
{
    private $table_name = 'tblcompany';
    private $table_suplr = 'tblsupplier';

    public function index(){

        $company = DB::table($this->table_name)
        ->paginate(10);

        return view('/maintenance/company/company', ['company' => $company]);
    }

    public function store(Request $request)
    {    
        $company = new CompanyMaintenance;
        $company->company_name = $request->input('company_name');
        $company->markup = $request->input('markup');
        $company->save();

        return redirect('/maintenance/company')->with('success', 'Data Saved');
    }

    
    public function getCompanyMarkup($companyID)
    {
        $com = DB::table($this->table_name)
        ->where('tblcompany.id', $companyID)
        ->get();
        return $com;
    }


    public function edit($id)
    {
        $company = DB::select('SELECT * FROM ' . $this->table_name . ' WHERE id = ?', [$id]);
        return $company;
    }

    public function update($id)
    {
        $company_name = Input::get('company_name');
        $markup = Input::get('markup');

        DB::update('UPDATE '. $this->table_name .' 
        SET company_name = ?, markup = ?
        WHERE id = ?',
        [
            $company_name,
            $markup,
            $id
        ]);
    }
}
