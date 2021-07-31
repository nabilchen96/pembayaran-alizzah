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

        //klasifikasikan pembayaran siswa sesuai parameter bulan dan kelas
        //1. ambil data rombel
        //2. ambil data pembayaran bulanan saja dari siswa
        //3. lakukan looping
        //4. setiap looping jumlahkan total pembayaran tahun ini - total bulan berjalan

        /*
            //jika 0 maka sudah bayar
            2.000.000 - (2 * 1.000.000) = 0

            
        */
        

        $transaksi  = DB::table('transaksis')
                        ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->leftJoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->select(
                            'transaksis.kd_nota',
                            // DB::raw('DATE_FORMAT(transaksis.tgl_transaksi, "%d/%m/%Y") as tgl_transaksi'),
                            'transaksis.tgl_transaksi',
                            'jenis_pembayarans.nama_pembayaran',
                            'transaksis.jumlah_bayar',
                            'siswas.nama_siswa',
                            'transaksis.nama_pembayar',
                            'siswas.nis',
                            'transaksis.keterangan'
                        )
                        ->orderBy('transaksis.tgl_transaksi', 'DESC')
                        ->get();

        return Datatables::of($transaksi)->make(true);
    }

    public function index(){

        $kelas = DB::table('kelas')->get();

        return view('rekappemasukan.index')->with('kelas', $kelas);
    }

    public function export(){
        return Excel::download(new RekapPemasukanExport, 'Data_Rekap_Pemasukan.xlsx');
    }
}
