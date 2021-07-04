<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanTunggakanExport implements FromView
{
    protected $id_jenis_pembayaran;

    function __construct($id_jenis_pembayaran) {
            $this->id_jenis_pembayaran        = $id_jenis_pembayaran;
    }

    public function view(): view
    {

        $data  = DB::table('siswas')
                ->join('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')

                ->join('set_pembayaran_kelas', 'set_pembayaran_kelas.id_kelas', '=', 'kelas.id_kelas')
                ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                ->where('jenis_pembayarans.id_jenis_pembayaran', $this->id_jenis_pembayaran)
                ->where('tahun_ajarans.status_aktif', 1)
                ->select(
                    db::raw('max(siswas.id_siswa) as id_siswa'),
                    db::raw('max(siswas.nis) as nis'),
                    db::raw('max(siswas.nama_siswa) as nama_siswa'),
                    db::raw('max(set_pembayaran_kelas.biaya) as biaya'),
                    db::raw('max(tahun_ajarans.tgl_mulai) as tgl_mulai'),
                    db::raw('max(kelas.kelas) as kelas'),
                    db::raw('max(tahun_ajarans.tahun) as tahun'),
                    db::raw('max(kelas.jenjang) as jenjang'),
                    db::raw('max(jenis_pembayarans.nama_pembayaran) as pembayaran'),

                )
                ->groupBy('siswas.id_siswa')
                ->get();


        $jenis_pembayaran = DB::table('jenis_pembayarans')
                    ->where('id_jenis_pembayaran', $this->id_jenis_pembayaran)
                    ->first();
        
        foreach($data as $key => $d){

            //cek apakah menerima keringanan
            $keringanan     = DB::table('penerima_keringanans')
                                ->join('keringanans', 'keringanans.id_keringanan', '=', 'penerima_keringanans.id_keringanan')
                                ->where('keringanans.id_jenis_pembayaran',  $this->id_jenis_pembayaran)
                                ->where('penerima_keringanans.id_siswa', $d->id_siswa)
                                ->first();

            if($jenis_pembayaran->total_pembayaran_pertahun == 1){

                $transaksi      = DB::table('transaksis')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                                ->where('id_siswa', $d->id_siswa)
                                ->where('id_jenis_pembayaran', $this->id_jenis_pembayaran)
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->select(
                                    DB::raw('sum(transaksis.jumlah_bayar) as jumlah_tunggakan'),
                                )
                                ->first();
                
                $hutang_tunggakan      = (@$d->biaya - @$keringanan->besaran_keringanan) - ($transaksi->jumlah_tunggakan);

                
            }else{
                
                $transaksi      = DB::table('transaksis')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                                ->where('id_siswa', $d->id_siswa)
                                ->where('id_jenis_pembayaran', $this->id_jenis_pembayaran)
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->select(
                                    DB::raw('sum(transaksis.jumlah_bayar) as jumlah_tunggakan')
                                )
                                ->first();

                $diff           = date_diff( date_create($d->tgl_mulai), date_create('m'));


                $hutang_tunggakan    = (@$d->biaya - @$keringanan->besaran_keringanan) * ($diff->m + 1) - $transaksi->jumlah_tunggakan;
            }
            
            $siswa[] = array(
                'id_siswa'          => $d->id_siswa,
                'nis'               => $d->nis,
                'nama_siswa'        => $d->nama_siswa,
                'hutang_tunggakan'  => $hutang_tunggakan,
                'spp'               => @$d->biaya,
                'keringanan'        => @$keringanan->besaran_keringanan,
                'kelas'             => @$d->kelas.'/'.@$d->jenjang,
                'pembayaran'        => $d->pembayaran 
            );
        }

        return view('laporantunggakan.export')->with('siswa', $siswa);
    }
}
