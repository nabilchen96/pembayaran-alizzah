<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //tes 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //total kelas
        $kelas  = DB::table('kelas')->count();

        //Jumlah Siswa Penerima Bantuan
        $penerima_bantuan = DB::table('penerima_keringanans')
                            ->count();

        //Total Siswa
        $siswa  = DB::table('siswas')
                    ->count();

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

        $saldo          = $pemasukan - $pengeluaran;

        return view('home')
            ->with('kelas', $kelas)
            ->with('siswa', $siswa)
            ->with('penerima_bantuan', $penerima_bantuan)
            ->with('saldo', $saldo);
    }
}
