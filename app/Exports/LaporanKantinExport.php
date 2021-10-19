<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class LaporanKantinExport implements FromView
{
    protected $tgl_awal;
    protected $tgl_akhir;

    function __construct($tgl_awal, $tgl_akhir) {
            $this->tgl_awal         = $tgl_awal;
            $this->tgl_akhir        = $tgl_akhir;
    }

    public function view(): view
    {

        // dd($this->tgl_awal);

        $tgl_awal   = new Carbon($this->tgl_awal);
        $tgl_akhir  = new Carbon($this->tgl_akhir);

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

        return view('laporankantin.export', [
            'data'  => $data
        ]);
    }
}
