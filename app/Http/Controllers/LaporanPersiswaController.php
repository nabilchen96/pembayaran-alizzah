<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Exports\LaporanPersiswaExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanPersiswaController extends Controller
{
    public function index(Request $request){

        $siswa = DB::table('siswas')->get();

        if($request->id_siswa != null){ 
            $pembayaran = DB::table('transaksis')
                    ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                    ->where('transaksis.id_siswa', $request->id_siswa)
                    ->get();

            $tunggakan = [];

            $data_siswa = DB::table('siswas')
                            ->join('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                            ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                            ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                            ->where('siswas.id_siswa', $request->id_siswa)
                            ->first();

        }else{
            $data_siswa = [];
            $pembayaran = [];
            $tunggakan = [];
        }


        // dd($pembayaran[0]->nama_siswa);


        return view('laporanpersiswa.index')
            ->with('data_siswa', $data_siswa)
            ->with('pembayaran', $pembayaran)
            ->with('tunggakan', $tunggakan)
            ->with('siswa', $siswa);
    }

    public function export($id){

        return Excel::download(new LaporanPersiswaExport($id), 'Lap. Pembayaran Siswa.xlsx');
    }
}
