<?php

namespace App\Exports;

use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPersiswaExport implements FromView
{

    protected $id;

    function __construct($id) {
        $this->id   = $id;
    }

    public function view(): view
    {

        $data = DB::table('transaksis')
                    ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'transaksis.id_jenis_pembayaran')
                    ->where('transaksis.id_siswa', $this->id)
                    ->get();

        $data_siswa = DB::table('siswas')
                    ->join('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                    ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                    ->where('siswas.id_siswa', $this->id)
                    ->first();

        
        return view('laporanpersiswa.export')
                ->with('data_siswa', $data_siswa)
                ->with('data', $data);

    }
}
