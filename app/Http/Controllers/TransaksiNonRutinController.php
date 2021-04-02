<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaksi;
use DB;
use DataTables;
use App\JenisPembayaran;
use App\SetPembayaranKelas;

class TransaksiNonRutinController extends Controller
{
    public function index(){
        return view('transaksi.index');
    }

    public function create(){
        $pembayaran = JenisPembayaran::all();
        return view('transaksi.create')->with('pembayaran', $pembayaran);
    }
}
