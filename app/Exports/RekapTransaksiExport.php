<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use App\RekapTransaksi;

class RekapTransaksiExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();
        $data = RekapTransaksi::where('id_tahun', $tahun->id_tahun)->get();

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
