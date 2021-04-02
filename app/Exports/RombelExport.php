<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RombelExport implements FromView
{
    protected $id_kelas;

    function __construct($id_kelas) {
            $this->id_kelas         = $id_kelas;
    }

    public function view(): view
    {
        $data = DB::table('rombels')
                ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                ->where('tahun_ajarans.status_aktif', 1)
                ->where('kelas.id_kelas', $this->id_kelas)
                ->get();

        return view('rombel.export')->with('data', $data);
    }
}
