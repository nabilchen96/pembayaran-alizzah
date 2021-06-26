<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use App\RekapTransaksi;

class RekapTransaksiExport implements FromView
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
            $data = RekapTransaksi::whereBetween('tgl_transaksi', [$this->tgl_awal, $this->tgl_akhir])->get();

        }elseif($this->jenis_export == 2){

            //mengambil semua data hari ini
            $data = RekapTransaksi::where('tgl_transaksi', date('Y-m-d'))->get();

        }elseif($this->jenis_export == 3){

            //mengambil semua data bulan ini
            $data = RekapTransaksi::whereMonth('tgl_transaksi', date('m'))->get();

        }elseif($this->jenis_export == 4){


            //mengambil semua data tahun ini
            $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();
            $data = RekapTransaksi::where('id_tahun', $tahun->id_tahun)->get();

        }


            $rekap_trx = [];
            $pemasukan = null;
            $pengeluaran = null;

            foreach($data as $k => $d){
                
                $d->jenis_transaksi == 'pemasukan' ? $pemasukan = $d->jumlah_transaksi + $pemasukan : $pengeluaran = $d->jumlah_transaksi + $pengeluaran;
    
                $saldo = $pemasukan - $pengeluaran;
    
                $rekap_trx[] = array(
                    'id_rekap_transaksi'    => $d->id_rekap_transaksi,
                    'tgl_transaksi'         => $d->tgl_transaksi,
                    'jenis_transaksi'       => $d->jenis_transaksi,
                    'jumlah_transaksi'      => $d->jumlah_transaksi,
                    'keterangan'            => $d->keterangan,
                    'saldo'                 => $saldo
                );
            }

            


        return view('rekaptransaksi.export', [
            'data' => $rekap_trx
        ]);
    }
}
