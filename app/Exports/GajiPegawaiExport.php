<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class GajiPegawaiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $gaji = DB::table('set_gajis')
                ->join('pegawais', 'pegawais.id_pegawai', '=', 'set_gajis.id_pegawai')
                ->select(
                    'pegawais.nama_pegawai',
                    'pegawais.nip',
                    'pegawais.id_pegawai',
                    DB::raw('sum(gaji_rincian) as gaji_rincian')
                )
                ->groupBy('pegawais.id_pegawai')
                ->get();

        return view('setgaji.export', [
            'data' => $gaji
        ]);
    }
}
