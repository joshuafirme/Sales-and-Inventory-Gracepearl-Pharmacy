<?php

namespace App\Http\Controllers\Utilities;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BackupAndRestoreCtr extends Controller
{
    public function index(){
        return view('/utilities/backup_restore');
    }

    public function backup(){
        $filename = "backup-" . date('Y-m-d') . ".sql";

        $command = "".env('DUMP_PATH')." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);

        return redirect('/utilities/backup_restore')->with('success', 'The database is successfully backup.');
    }

    public function restore(){
        $filename = "backup-" . date('Y-m-d') . ".sql";

        $command = "".env('IMP_PATH')." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  < " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);

        return redirect('/utilities/backup_restore')->with('success', 'The database is successfully restored.');
    }

    
}
