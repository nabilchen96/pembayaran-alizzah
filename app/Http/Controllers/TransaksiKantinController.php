<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\TransaksiUangSaku;
use App\UangSaku;
use DataTables;
use Carbon\Carbon;
use auth;
use Exception;

class TransaksiKantinController extends Controller
{
    public function index(){

        if(request()->ajax()){
            $data = DB::table('transaksi_uang_sakus')
                    ->join('siswas', 'siswas.id_siswa', '=', 'transaksi_uang_sakus.id_siswa')
                    ->join('users', 'users.id', '=', 'transaksi_uang_sakus.id_user')
                    ->where('transaksi_uang_sakus.jenis_transaksi', 'keluar')
                    ->where('users.role', 'admin-kantin')
                    ->whereDate('transaksi_uang_sakus.created_at', Carbon::today())
                    ->select(
                        'transaksi_uang_sakus.*',
                        'siswas.id_siswa',
                        'siswas.nama_siswa',
                        'siswas.nis'
                    )
                    ->orderBy('transaksi_uang_sakus.created_at', 'DESC')
                    ->get();


            return DataTables::of($data)->toJson();
        }

        return view('transaksikantin.index');
    }

    public function carisiswa($id){

        if(request()->ajax()){
            $data = [
                'data1' => DB::table('siswas')
                    ->join('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                    ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                    ->leftjoin('uang_sakus', 'uang_sakus.id_siswa', '=', 'siswas.id_siswa')
                    ->leftjoin('transaksi_uang_sakus', 'transaksi_uang_sakus.id_siswa', '=', 'siswas.id_siswa')
                    ->select(
                        'siswas.nama_siswa',
                        'siswas.id_siswa',
                        'siswas.nis',
                        'kelas.jenjang',
                        'kelas.kelas',
                        'uang_sakus.limit_jajan_harian',
                    )
                    ->where('tahun_ajarans.status_aktif', "1")
                    ->where('nis', $id)
                    ->first(),
                'jumlah_masuk' => DB::table('transaksi_uang_sakus')
                        ->join('siswas', 'siswas.id_siswa', '=', 'transaksi_uang_sakus.id_siswa')
                        ->where('transaksi_uang_sakus.jenis_transaksi', 'masuk')
                        ->where('siswas.nis', $id)
                        ->sum('transaksi_uang_sakus.jumlah'),

                'jumlah_keluar' => DB::table('transaksi_uang_sakus')
                        ->join('siswas', 'siswas.id_siswa', '=', 'transaksi_uang_sakus.id_siswa')
                        ->where('transaksi_uang_sakus.jenis_transaksi', 'keluar')
                        ->where('siswas.nis', $id)
                        ->sum('transaksi_uang_sakus.jumlah')
            ];
            

            echo json_encode($data);
        }
    }

    public function store(Request $request){

        // dd($request);

        if($request->jajan_harian == NULL && $request->kebutuhan_khusus == NULL){
            return redirect('transaksikantin')->with(['gagal' => 'gagal!, input jajan harian atau kebutuhan khusus tidak boleh kosong']);
        }

        if($request->jajan_harian == 0 && $request->kebutuhan_khusus == 0){
            return redirect('transaksikantin')->with(['gagal' => 'input jajan harian atau kebutuhan khusus']);
        }

        $data = UangSaku::where('id_siswa', $request->id_siswa)->first();

        $jumlah_masuk = DB::table('transaksi_uang_sakus')
            ->where('jenis_transaksi', 'masuk')
            ->where('id_siswa', $request->id_siswa)
            ->sum('jumlah');

        $jumlah_keluar = DB::table('transaksi_uang_sakus')
            ->where('jenis_transaksi', 'keluar')
            ->where('id_siswa', 'keluar')
            ->sum('jumlah');

        $saldo = $jumlah_masuk - $jumlah_keluar;

        if($data == null){
            return redirect('transaksikantin')->with(['gagal' => 'input uang saku pertama kali terlebih dahulu']);
        }

        // if($request->jajan_harian == 0){
            if($request->jajan_harian > $saldo || $request->jajan_harian > $data->limit_jajan_harian){
                return redirect('transaksikantin')->with(['gagal' => 'jumlah belanja lebih besar dari saldo']);
            }
        // }else{
            if($request->kebutuhan_khusus > $saldo){
                return redirect('transaksikantin')->with(['gagal' => 'jumlah belanja lebih besar dari saldo']);
            }
        // }

        $total = TransaksiUangSaku::where('id_siswa', $request->id_siswa)
                    ->whereRaw('date(created_at) = CURDATE()')
                    ->where('jenis_transaksi', 'keluar')
                    ->where('keterangan', 'jajan harian')
                    ->sum('jumlah');

                    // dd($total);
        
        if($total + $request->jajan_harian > $data->limit_jajan_harian){
            return redirect('transaksikantin')->with(['gagal' => 'santri sudah melewati batas harian']);
        }


        DB::beginTransaction();

        try {

            //tabel transaksi_uang_sakus

            //insert data jajan harian
            if($request->jajan_harian != 0){
                TransaksiUangSaku::create([
                    'id_siswa'          =>  $request->id_siswa,
                    'keterangan'        =>  'jajan harian',
                    'jenis_transaksi'   =>  'keluar',
                    'jumlah'            =>  $request->jajan_harian,
                    'id_user'           =>  auth::user()->id
                ]);
            }

            //insert data kebutuhan khususus
            if($request->kebutuhan_khusus != 0){
                TransaksiUangSaku::create([
                    'id_siswa'          =>  $request->id_siswa,
                    'keterangan'        =>  'kebutuhan khusus',
                    'jenis_transaksi'   =>  'keluar',
                    'jumlah'            =>  $request->kebutuhan_khusus,
                    'id_user'           =>  auth::user()->id
                ]);
            }

            //tabel uang_sakus
            $uangsaku = UangSaku::find($data->id_uang_saku);
            $uangsaku->update([
                'saldo' => $uangsaku->saldo - ($request->kebutuhan_khusus + $request->jajan_harian)
            ]);
        

            DB::commit();

        } catch (\Throwable $e) {

            DB::rollback();

            return redirect('transaksikantin')->with(['gagal' => 'data gagal disimpan, pastikan koneksi internet stabil!']);
        }

        return redirect('transaksikantin')->with(['sukses' => 'data berhsil disimpan']);

    }
}
