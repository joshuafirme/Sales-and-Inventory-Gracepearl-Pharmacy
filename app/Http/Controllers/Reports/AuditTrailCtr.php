<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\UserAccessRights;
use App\Classes\Date;
use Illuminate\Support\Facades\DB;

class AuditTrailCtr extends Controller
{
    private $tbl_emp = "tblemployee";
    private $tbl_audit = "tblaudit_trail";
    private $module = "Reports";

    public function index(Request $request){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $audit_data = $this->getAuditTrail($request->date_from, $request->date_to);

        if(request()->ajax())
        {
            return datatables()->of($audit_data)
            ->make(true);  
        }
        
        return view('reports/audit_trail_report',[
            'currentDate' => $this->getDate()
        ]);
    }

    public function getAuditTrail($date_from, $date_to)
    {
        $audit = DB::table($this->tbl_audit.' AS A')
        ->select("A.*", 'name', 'position', 
        DB::raw('DATE_FORMAT(ADDTIME(A.created_at, "8:00:5.000003"),"%r") AS time,  DATE_FORMAT(A.created_at, "%m-%d-%Y") AS date'))
        ->leftJoin($this->tbl_emp.' AS E', 'E.username', '=', 'A.user_name')
        ->whereBetween('A.created_at', [$date_from, $date_to])
        ->orderBy('A.id', 'desc')
        ->get();

        return $audit;
    }

    public function getDate(){
        $date = new Date;
        return $date->getDate();
    }
}
