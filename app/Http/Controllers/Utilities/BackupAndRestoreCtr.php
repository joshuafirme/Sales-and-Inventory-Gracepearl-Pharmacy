<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\UserAccessRights;

class BackupAndRestoreCtr extends Controller
{
    public function index(){
        $rights = new UserAccessRights;

        if(!($rights->isUserAuthorize('Utilities')))
        {
            return view('/layouts.not_auth');
        }   

        return view('/utilities/backup_restore');
    }

    public function backup(){
        $filename = "backup-" . date('Y-m-d') . ".sql";

        $command = "".storage_path() . "/app/mysql/bin/mysqldump.exe"." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);

        return redirect('/utilities/backup_restore')->with('success', 'The database is successfully backup.');
    }

    public function restore(){
        $filename = "backup-" . date('Y-m-d') . ".sql";

        $command = "".storage_path() . "/app/mysql/bin/mysql.exe"." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  < " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);

        return redirect('/utilities/backup_restore')->with('success', 'The database is successfully restored.');
    }

    
}
