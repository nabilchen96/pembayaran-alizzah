<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BackupDatabaseController extends Controller
{
    public function index(){
        return view('backup.index');
    }
}
