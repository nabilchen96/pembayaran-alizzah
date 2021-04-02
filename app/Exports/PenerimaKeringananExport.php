<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PenerimaKeringananExport implements FromView
{
    protected $id_keringanan;

    function __construct($id_keringanan) {
            $this->id_keringanan        = $id_keringanan;
    }

    public function view(): view
    {
        $data = DB::table('penerima_keringanans')
        ->join('siswas', 'siswas.id_siswa', '=', 'penerima_keringanans.id_siswa')
        ->join('keringanans', 'keringanans.id_keringanan', '=', 'penerima_keringanans.id_keringanan')
        ->where('keringanans.id_keringanan', $this->id_keringanan)
        ->get();

        return view('penerimakeringanan.export')->with('data', $data);
    }
}
