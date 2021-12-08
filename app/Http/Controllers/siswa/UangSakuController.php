<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use auth;
use DataTables;

class UangSakuController extends Controller
{
    public function index(){

        if(request()->ajax()){

            $siswa = DB::table('siswas')->where('nis', auth::user()->email)->value('id_siswa');

            $data = DB::table('transaksi_uang_sakus')
                        ->join('siswas', 'siswas.id_siswa', '=', 'transaksi_uang_sakus.id_siswa')
                        ->where('siswas.id_siswa', $siswa)
                        ->select(
                            'siswas.id_siswa',
                            'siswas.nama_siswa',
                            'siswas.nis',
                            'transaksi_uang_sakus.*'
                        )
                        // ->groupBy('transaksi_uang_sakus.created_at')
                        ->get();
                        
            $pemasukan      = 0;
            $pengeluaran    = 0;
            $rekap_trx       = [];

                foreach($data as $d){
                    $d->jenis_transaksi == 'masuk' ? $pemasukan = $d->jumlah + $pemasukan : $pengeluaran = $d->jumlah + $pengeluaran;
        
                    $saldo = $pemasukan - $pengeluaran;
        
                    $rekap_trx[] = array(
                        'id_transaksi_uang_saku'    => $d->id_transaksi_uang_saku,
                        'created_at'                => date('d-m-Y H:i:s', strtotime($d->created_at)),
                        'jenis_transaksi'           => $d->jenis_transaksi,
                        'jumlah'                    => $d->jumlah,
                        'keterangan'                => $d->keterangan,
                        'saldo'                     => $saldo
                    );
                }
            

            return DataTables::of($rekap_trx)->toJson();
        }

        return view('dashboardsiswa.uangsaku.index');
    }

    public function settinguangsaku(Request $request){

        DB::update('update uang_sakus set limit_jajan_harian = '.$request->limit_jajan_harian.' where  id_siswa = '.$request->id_siswa);

        return back()->with(['sukses' => 'Limit Jajan Harian Berhasil Diset!']);
    }
}
