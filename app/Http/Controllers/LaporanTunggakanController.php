<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DataTables;
use App\JenisPembayaran;
use App\Exports\LaporanTunggakanExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanTunggakanController extends Controller
{

    public function json(Request $request){
        //menampilkan semua siswa
        $data   = DB::table('siswas')->select('id_siswa', 'nis', 'nama_siswa')->get();

        //mengambil tanggal mulai di tahun aktif
        $tahun  = DB::table('tahun_ajarans')->select('tgl_mulai')->where('status_aktif', 1)->first();

        
        foreach($data as $key => $d){

            //data kelas
            $kelas          = DB::table('rombels')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                                ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                                ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                                ->where('siswas.id_siswa', $d->id_siswa)
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->first();

            //menampilkan pembayaran yang cocok dengan kelas si siswa
            $spp            = DB::table('rombels')
                                ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                                ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_Kelas')
                                ->join('set_pembayaran_kelas', 'set_pembayaran_kelas.id_kelas', '=', 'kelas.id_kelas')
                                ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                                ->where('siswas.id_siswa', $d->id_siswa)
                                ->where('jenis_pembayarans.id_jenis_pembayaran',  $request->input('id_jenis_pembayaran'))
                                ->select('set_pembayaran_kelas.biaya')
                                ->first();

            //cek apakah menerima keringanan
            $keringanan     = DB::table('penerima_keringanans')
                                ->join('siswas', 'siswas.id_siswa', '=', 'penerima_keringanans.id_siswa')
                                ->join('keringanans', 'keringanans.id_keringanan', '=', 'penerima_keringanans.id_keringanan')
                                ->where('keringanans.id_jenis_pembayaran',  $request->input('id_jenis_pembayaran'))
                                ->where('siswas.id_siswa', $d->id_siswa)
                                ->first();

            //jumlah tunggakan

            $jenis_pembayaran = DB::table('jenis_pembayarans')
                                ->where('id_jenis_pembayaran', $request->input('id_jenis_pembayaran'))
                                ->first();

            if($jenis_pembayaran->total_pembayaran_pertahun == 1){
                $transaksi      = DB::table('transaksis')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                                ->where('id_siswa', $d->id_siswa)
                                ->where('id_jenis_pembayaran', $request->input('id_jenis_pembayaran'))
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->select(
                                    DB::raw('sum(transaksis.jumlah_bayar) as jumlah_tunggakan'),
                                )
                                ->first();
                
                $hutang_tunggakan      = (@$spp->biaya - @$keringanan->besaran_keringanan) - ($transaksi->jumlah_tunggakan);

                
            }else{
                $transaksi      = DB::table('transaksis')
                                ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'transaksis.id_tahun')
                                ->where('id_siswa', $d->id_siswa)
                                ->where('id_jenis_pembayaran', $request->input('id_jenis_pembayaran'))
                                ->where('tahun_ajarans.status_aktif', 1)
                                ->select(
                                    DB::raw('TIMESTAMPDIFF(MONTH, "'.$tahun->tgl_mulai.'", CURRENT_DATE) as total_bulan'),
                                    DB::raw('sum(transaksis.jumlah_bayar) as jumlah_tunggakan')
                                    // DB::raw('sum(transaksis.jumlah_bayar) as jumlah_tunggakan')
                                )
                                ->first();

                $hutang_tunggakan      = (@$spp->biaya - @$keringanan->besaran_keringanan) * ($transaksi->total_bulan + 1) - $transaksi->jumlah_tunggakan;
                // $hutang_tunggakan       = (@spp->biaya - @keringanan->besaran_keringanan);
            }
            
            $siswa[] = array(
                'id_siswa'          => $d->id_siswa,
                'nis'               => $d->nis,
                'nama_siswa'        => $d->nama_siswa,
                // 'total_tunggakan'   => $transaksi->jumlah_tunggakan + 1,
                'hutang_tunggakan'  => $hutang_tunggakan,
                
                'spp'               => @$spp->biaya,
                'keringanan'        => @$keringanan->besaran_keringanan,
                'kelas'             => @$kelas->kelas.'/'.@$kelas->jenjang
            );
        }

        return Datatables::of($siswa)->make(true);
    }

    public function index(){
        $pembayaran = JenisPembayaran::where('pembayaran_rutin', 'rutin')->get();
        return view('laporantunggakan.index')->with('pembayaran', $pembayaran);
    }

    public function surat(){
        return view('laporantunggakan.surat');
    }

    public function export($id_jenis_pembayaran){
        return Excel::download(new LaporanTunggakanExport($id_jenis_pembayaran), 'Lap. Tunggakan.xlsx');
    }
}
