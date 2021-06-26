<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class PengeluaranExport implements FromView
{

    protected $jenis_export;
    protected $tgl_awal;
    protected $tgl_akhir;

    function __construct($jenis_export, $tgl_awal, $tgl_akhir){
        $this->jenis_export = $jenis_export;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }


    public function view(): View
    {

        if($this->jenis_export == 1 and $this->tgl_awal != 0 and $this->tgl_akhir != 0){
            //ambil data berdasarkan range
            $data = DB::table('pengeluarans')->whereBetween('tgl_pengeluaran', [$this->tgl_awal, $this->tgl_akhir])->get();

        }elseif($this->jenis_export == 2){
            //mengambil semua data hari ini
            $data = DB::table('pengeluarans')->where('tgl_pengeluaran', date('Y-m-d'))->get();

        }elseif($this->jenis_export == 3){
            //mengambil semua data bulan ini
            $data  = DB::table('pengeluarans')
                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                    ->where('tahun_ajarans.status_aktif', 1)
                    ->whereMonth('tgl_pengeluaran', date('m'))
                    ->whereYear('tgl_pengeluaran', date('Y'))
                    ->orderBy('pengeluarans.created_at', 'DESC')
                    ->get();

        }elseif($this->jenis_export == 4){

            //mengambil semua data tahun ini
            $data  = DB::table('pengeluarans')
                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'pengeluarans.id_tahun')
                ->where('tahun_ajarans.status_aktif', 1)
                ->orderBy('pengeluarans.created_at', 'DESC')
                ->get();


        }

        return view('pengeluaran.export', [
            'data' => $data
        ]);
    }
}
