<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class RekapPemasukanExport implements FromView
{
    public function view(): View
    {
        $transaksi  = DB::table('transaksis')
                        ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                        ->LeftJoin('siswas', 'siswas.id_siswa', '=', 'transaksis.id_siswa')
                        ->leftJoin('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                        ->leftJoin('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                        ->where('tahun_ajarans.status_aktif', 1)
                        ->groupBy('transaksis.id_transaksi')
                        ->get();


        return view('rekappemasukan.export', [
            'data' => $transaksi
        ]);
    }
}
