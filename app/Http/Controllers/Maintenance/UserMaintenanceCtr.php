<?php

namespace App\Http\Controllers\Maintenance;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\UserMaintenance;
use Illuminate\Http\Request;
use Input;
use App\Classes\UserAccessRights;

class UserMaintenanceCtr extends Controller
{
    private $table_emp = "tblemployee";
    private $module = "Maintenance";

    public function index()
    {
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize($this->module)))
        {
            $rights->notAuthMessage();
        }
        return view('/maintenance/user/user');
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

    public function store(Request $request){
      
        $user = new UserMaintenance;
        $user->_prefix = 'EMP-' . date('yy') . '-';
        $user->name = $request->input('employee_name');
        $user->position = $request->input('position');
        $user->username = $request->input('username');
        $user->password = $request->input('password'); 
    
        $modules = $request->all();
        $modules[] = $request->input('chk-module');

        $fusion = implode(", ", $modules[0]);
        
        $user->auth_modules = $fusion;
       
        $user->save();


        return redirect('/maintenance/user');
    }

    public function update(){
      $empID = Input::input('empID');
      $emp_name = Input::input('emp_name');
      $position = Input::input('position');
      $username = Input::input('username');
      $password = Input::input('password');
      $modules = Input::input('modules');

        DB::table($this->table_emp)
        ->where('id', $empID)
        ->update([
            'name' => $emp_name,
            'position' => $position,
            'username' => $username,
            'password' => $password,
            'auth_modules' => $modules
        ]);
    }

    public function displayUsers(){
        
        if(request()->ajax())
        {       
            return datatables()->of($this->getUsers())
            ->addColumn('action', function($user){

                $button = ' <a class="btn btn-sm" id="btn-edit-user" emp-id="'. $user->id .'"
                data-toggle="modal" data-target="#editUserModal" ><i class="fa fa-edit"></i></a>';

                $button .= '<a class="btn btn-sm" id="delete-user" delete-id="'. $user->id .'"><i  style="color:#DC3545;" class="fa fa-trash"></i></a>';
                return $button;

            })
            ->rawColumns(['action'])
            ->make(true);               
        }
    }

    public function getUsers(){
        $emp = DB::table($this->table_emp)
        ->select($this->table_emp.".*", DB::raw('CONCAT('.$this->table_emp.'._prefix, '.$this->table_emp.'.id) AS empID'))
        ->get();

        return $emp;
    }

    public function getName(){
        $emp = DB::table($this->table_emp)
        ->where('username', session()->get('emp-username'))
        ->value('name');

        return $emp;
    }

    public function getPosition(){
        $emp = DB::table($this->table_emp)
        ->where('username', session()->get('emp-username'))
        ->value('position');

        return $emp;
    }

    public function show($empID){
        $emp = DB::table($this->table_emp)
        ->select($this->table_emp.".*", DB::raw('CONCAT('.$this->table_emp.'._prefix, '.$this->table_emp.'.id) AS empID'))
        ->where('id', $empID)
        ->get();

        return $emp;
    }
    public function destroy($empID)
    {
        $user = UserMaintenance::findOrFail($empID);
        $user->delete();
        return $user;
    }
}
