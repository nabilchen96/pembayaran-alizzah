<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use DB;

class LaporanBayarBulananController extends Controller
{
    public function index(Request $request){

        $kelas      = Kelas::all();


        if($request){
            $data = DB::table('rombels')
                    ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                    ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                    ->join('set_pembayaran_kelas', 'set_pembayaran_kelas.id_kelas', '=', 'kelas.id_kelas')
                    ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                    ->where('jenis_pembayarans.id_jenis_pembayaran',  7)
                    ->where('tahun_ajarans.status_aktif', '1')
                    ->where('rombels.id_kelas', $request->id_kelas)
                    ->get();
                    
            $data_array = [];

            foreach ($data as $key => $value) {
                
                //get total transaksi
                $total_transaksi = DB::table('transaksis')
                                    ->where('id_jenis_pembayaran', 7)
                                    ->where('id_siswa', $value->id_siswa)
                                    ->where('id_tahun', $value->id_tahun)
                                    ->get();


                                    
                
                //cek keringanan
                $keringanan     = DB::table('penerima_keringanans')
                                ->join('keringanans', 'keringanans.id_keringanan', '=', 'penerima_keringanans.id_keringanan')
                                ->where('keringanans.id_jenis_pembayaran',  7)
                                ->where('penerima_keringanans.id_siswa', $value->id_siswa)
                                ->first();

                $biaya_bulanan = $value->biaya - @$keringanan->besaran_keringanan;

                if(date('m', strtotime($value->tgl_mulai)) <= $request->bulan){
                    $total_bulan = $request->bulan - date('m', strtotime($value->tgl_mulai))+1;
                }else{
                    $total_bulan = $request->bulan + date('m', strtotime($value->tgl_mulai))-1;
                }    
                

                $data_array[] = array(
                    'id_siswa'          => $value->id_siswa,
                    'nama_siswa'        => $value->nama_siswa,
                    'nis'               => $value->nis,
                    'total_transkasi'   => number_format($total_transaksi->sum('jumlah_bayar')),
                    'tgl_transaksi'     => @$total_transaksi->last()->tgl_transaksi,
                    'total_bulan'       => $total_bulan,
                    'biaya_bulanan'     => $biaya_bulanan,
                    'status'            => ($biaya_bulanan * $total_bulan) - $total_transaksi->sum('jumlah_bayar') <= 0 ? 'Sudah Dibayar' : 'Belum Dibayar',
                );

                // echo ;
                
            }

            // die;
            // dd($data_array);


        }

        return view('laporanbayarbulanan.index')
            ->with('data_array', $data_array)
            ->with('kelas', $kelas);
    }
}
