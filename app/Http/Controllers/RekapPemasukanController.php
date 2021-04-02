<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Exports\RekapPemasukanExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapPemasukanController extends Controller
{

    public function json(){
        $transaksi  = DB::table('transaksis')
                        ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->leftJoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->get();

        return Datatables::of($transaksi)->make(true);
    }

    public function index(){
        return view('rekappemasukan.index');
    }

    public function export(){
        return Excel::download(new RekapPemasukanExport, 'Data_Rekap_Pemasukan.xlsx');
    }
}
