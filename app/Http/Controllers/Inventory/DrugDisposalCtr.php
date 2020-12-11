<?php
namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DrugDisposalCtr extends Controller
{
    public function index(){
        return view('/inventory/drug_disposal');
    }
}
