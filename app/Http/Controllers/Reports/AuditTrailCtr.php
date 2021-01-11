<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\UserAccessRights;
use Illuminate\Support\Facades\DB;

class AuditTrailCtr extends Controller
{
    private $tbl_emp = "tblemployee";
    private $tbl_audit = "tblaudit_trail";
    private $module = "Reports";

    public function index(){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $audit_data = $this->getAuditTrail();

        if(request()->ajax())
        {
            return datatables()->of($audit_data)
            ->make(true);  
        }
        
        return view('reports/audit_trail_report');
    }

    public function getAuditTrail()
    {
        $audit = DB::table($this->tbl_audit.' AS A')
        ->select("A.*", 'name', 'position', 
        DB::raw('DATE_FORMAT(ADDTIME(A.created_at, "8:00:5.000003"),"%r") AS time,  DATE_FORMAT(A.created_at, "%m-%d-%Y") AS date'))
        ->leftJoin($this->tbl_emp.' AS E', 'E.username', '=', 'A.user_name')
        ->orderBy('A.id', 'desc')
        ->get();

        return $audit;
    }
}
