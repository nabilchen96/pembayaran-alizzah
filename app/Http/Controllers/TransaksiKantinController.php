<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransaksiKantinController extends Controller
{
    public function index(){

        return view('transaksikantin.index');
    }
}
