<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class SiswaExport implements FromView
{

    public function view(): View
    {
        $siswa  = DB::table('siswas')
                    ->join('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                    ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                    ->select('siswas.*', 'kelas.kelas', 'kelas.jenjang')
                    ->get();

        return view('siswa.export', [
            'data' => $siswa
        ]);
    }
}
