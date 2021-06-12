<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PegawaiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $pegawai  = DB::table('pegawais')->get();

        return view('pegawai.export', [
            'data' => $pegawai
        ]);
    }
}
