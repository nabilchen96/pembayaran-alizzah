<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BackupDatabaseController extends Controller
{
    public function index(){
        $data = DB::select('SHOW TABLES');
        return view('backup.index')->with('data', $data);
    }
}
