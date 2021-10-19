<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use DataTables;

class LaporanKantinController extends Controller
{
    public function index(){

        // dd(@$_GET['tgl_akhir']);

        $tgl_awal   = new Carbon(@$_GET['tgl_awal']);
        $tgl_akhir  = new Carbon(@$_GET['tgl_akhir']);

        $data = DB::table('transaksi_uang_sakus')
                    ->join('siswas', 'siswas.id_siswa', '=', 'transaksi_uang_sakus.id_siswa')
                    ->join('users', 'users.id', '=', 'transaksi_uang_sakus.id_user')
                    ->where('transaksi_uang_sakus.jenis_transaksi', 'keluar')
                    ->where('users.role', 'admin-kantin')
                    ->select(
                        'transaksi_uang_sakus.*',
                        'siswas.id_siswa',
                        'siswas.nama_siswa',
                        'siswas.nis'
                    )
                    ->whereBetween('transaksi_uang_sakus.created_at', [$tgl_awal->format('Y-m-d')." 00:00:00", $tgl_akhir->format('Y-m-d')." 23:59:59"])
                    ->get();

        return view('laporankantin.index', [
            'data'  => $data
        ]);
    }
}
