<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RekapTransaksi;
use DataTables;
use DB;
use App\Exports\RekapTransaksiExport;
use Maatwebsite\Excel\Facades\Excel;

class RekapTransaksiController extends Controller
{
    public function index(){

        $pemasukan      = DB::table('rekap_transaksis')
                            ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rekap_transaksis.id_tahun')
                            ->where('tahun_ajarans.status_aktif', 1)
                            ->where('rekap_transaksis.jenis_transaksi', 'pemasukan')
                            ->sum('rekap_transaksis.jumlah_transaksi');

        $pengeluaran    = DB::table('rekap_transaksis')
                            ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rekap_transaksis.id_tahun')
                            ->where('tahun_ajarans.status_aktif', 1)
                            ->where('rekap_transaksis.jenis_transaksi', 'pengeluaran')
                            ->sum('rekap_transaksis.jumlah_transaksi');

        $tahun          = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();  
        
        $saldo          = $pemasukan - $pengeluaran;
        
        return view('rekaptransaksi.index')
            ->with('tahun', $tahun->tahun)
            ->with('pengeluaran', $pengeluaran)
            ->with('pemasukan', $pemasukan)
            ->with('saldo', $saldo);
    }

    public function json(){
        $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();
        $data = RekapTransaksi::where('id_tahun', $tahun->id_tahun)->get();

            $rekap_trx = [];
            $pemasukan = null;
            $pengeluaran = null;

            foreach($data as $k => $d){
                
                $d->jenis_transaksi == 'pemasukan' ? $pemasukan = $d->jumlah_transaksi + $pemasukan : $pengeluaran = $d->jumlah_transaksi + $pengeluaran;
    
                $saldo = $pemasukan - $pengeluaran;
    
                $rekap_trx[] = array(
                    'id_rekap_transaksi'    => $d->id_rekap_transaksi,
                    'tgl_transaksi'         => $d->tgl_transaksi,
                    'jenis_transaksi'       => $d->jenis_transaksi,
                    'jumlah_transaksi'      => $d->jumlah_transaksi,
                    'keterangan'            => $d->keterangan,
                    'saldo'                 => $saldo
                );
            }


        return Datatables::of($rekap_trx)->make(true);
    }

    public function export(){
        return Excel::download(new RekapTransaksiExport, 'Data Rekap Transaksi.xlsx');
    }
}
