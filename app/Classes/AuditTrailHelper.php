<?php 

namespace App\Classes;
use Illuminate\Support\Facades\DB;
use App\AuditTrail;

class AuditTrailHelper {

    private $table_emp = "tblemployee";
    private $table_audit = "tblaudit_trail";


    public function recordAction($module, $action)
    {
        $audit = new AuditTrail;
        $audit->user_name = session()->get('emp-username');
        $audit->module = $module;
        $audit->action = $action;
        $audit->save();
    }


}