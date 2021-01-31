<?php

namespace App\Http\Controllers\Reports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Classes\UserAccessRights;

class FastAndSlowMovingReportCtr extends Controller
{
    private $tbl_prod = "tblproduct";
    private $tbl_cat = "tblcategory";
    private $tbl_suplr = "tblsupplier";
    private $tbl_unit = "tblunit";
    private $module = "Reports";

    public function index(Request $request){

        $rights = new UserAccessRights;
      //  $qty = $this->getQtyPurchase('P-010045', '2021-01-27', '2021-01-28');
      //  $num_of_customer = $this->getNumberOfCustomer('P-010045', '2021-01-27', '2021-01-28');
     //   $frequency = $qty / $num_of_customer;
     //   dd(number_format((float)$frequency, 2, '.', ''));
        
        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }

        $date_from = $request->date_from;
        $date_to = $request->date_to;

        
        $this->returnDate($date_from, $date_to);

        $st = $this->getSalesAndTimeFrame($date_from, $date_to);

        if(request()->ajax())
        {
            return datatables()->of($st)
            ->addColumn('frequency', function($st)
            {
                $qty = $this->getQtyPurchase($st->product_code,session()->get('date')['date_from'], session()->get('date')['date_to']);
                $num_of_customer = $this->getNumberOfCustomer($st->product_code,session()->get('date')['date_from'], session()->get('date')['date_to']);
                $frequency = $qty / $num_of_customer;
                $p = '<span>'. floor($frequency) .'</span>';

                return $p;
            })
            ->rawColumns(['frequency'])
            ->make(true);  
        }
        
        return view('reports/fast_and_slow_moving',['currentDate' => date('Y-m-d')]);
    }

    public function getNumberOfCustomer($product_code,$date_from, $date_to){

        $cust = DB::table('tblsales')
        ->where('product_code', $product_code)
        ->whereBetween('date', [$date_from, $date_to])->get(); 
        
        return $cust->count();
    }

    public function getQtyPurchase($product_code,$date_from, $date_to){
        return DB::table('tblsales')
        ->where('product_code', $product_code)
        ->whereBetween('date', [$date_from, $date_to])
        ->sum('qty');
    }

    public function getSalesAndTimeFrame($date_from, $date_to){
        $sales = DB::table('tblsales as S')
        ->select('S.*', 'P.description', 'C.category_name')
        ->leftJoin('tblproduct as P',  DB::raw('CONCAT(P._prefix, P.id)'), '=', 'S.product_code')
        ->leftJoin('tblcategory as C', 'C.id', '=', 'P.categoryID')
        ->whereBetween('S.date', [$date_from, $date_to])
        ->get();

        return $sales->unique('product_code');
    }

    public function returnDate($date_from, $date_to){
        $session_date = session()->get('date');
        $session_date = array("date_from"=>$date_from, "date_to"=>$date_to);
        session()->put('date', $session_date);
        return $session_date;
    }


}
