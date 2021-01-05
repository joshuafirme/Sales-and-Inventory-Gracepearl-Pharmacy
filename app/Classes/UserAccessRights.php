<?php 

namespace App\Classes;
use Illuminate\Support\Facades\DB;

class UserAccessRights {

    private $table_emp = "tblemployee";

    public function create() {
     //   dd('hello!');
    }

    public function isUserAuthorize($module){
        $emp = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('auth_modules');

        $modules_arr = explode(", ",$emp);

        if (!(in_array($module, $modules_arr)))
        {
            return false;
        }
        else{
            return true;
        }
    }

    public function getAuthModules(){
        $auth_mod = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('position');

        return $auth_mod;
    }

    public function getPosition(){
        $position = DB::table($this->table_emp)
        ->where([
            ['username', session()->get('emp-username')],
        ])
        ->value('position');

        return $position;
    }

    public function notAuthMessage(){
        dd('You are not authorized to access this module. Please see the administrator!');
    }
}