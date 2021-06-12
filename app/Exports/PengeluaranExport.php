<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PengeluaranExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data  = DB::table('pengeluarans')
                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                ->where('tahun_ajarans.status_aktif', 1)
                ->orderBy('pengeluarans.created_at', 'DESC')
                ->get();


        return view('pengeluaran.export', [
            'data' => $data
        ]);
    }
}
