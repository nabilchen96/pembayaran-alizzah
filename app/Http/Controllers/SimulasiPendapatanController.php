<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimulasiPendapatanController extends Controller
{
    public function index(){
        return view('simulasipendapatan.index');
    }

    public function create(){
        return view('simulasipendapatan.create');
    }
}
