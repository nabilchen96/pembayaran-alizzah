<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\TransaksiUangSaku;
use App\UangSaku;
use DataTables;
use Carbon\Carbon;
use auth;

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
            $data = DB::table('siswas')
                    ->join('rombels', 'rombels.id_siswa', '=', 'siswas.id_siswa')
                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                    ->join('kelas', 'kelas.id_kelas', '=', 'rombels.id_kelas')
                    ->leftjoin('uang_sakus', 'uang_sakus.id_siswa', '=', 'siswas.id_siswa')
                    ->where('tahun_ajarans.status_aktif', "1")
                    ->where('nis', $id)->first();

            echo json_encode($data);
        }
    }

    public function store(Request $request){

        $data = UangSaku::where('id_siswa', $request->id_siswa)->first();

        if($data == null){
            return redirect('transaksikantin')->with(['gagal' => 'input uang saku pertama kali terlebih dahulu']);
        }

        if($request->jenis_transaksi == 0){
            if($request->jumlah > $data->saldo || $request->jumlah > 10000){
                return redirect('transaksikantin')->with(['gagal' => 'jumlah belanja lebih besar dari saldo']);
            }
        }else{
            if($request->jumlah > $data->saldo){
                return redirect('transaksikantin')->with(['gagal' => 'jumlah belanja lebih besar dari saldo']);
            }
        }

        $total = TransaksiUangSaku::where('id_siswa', $request->id_siswa)
                    ->whereRaw('date(created_at) = CURDATE()')
                    ->where('jenis_transaksi', 'keluar')
                    ->where('keterangan', 'jajan harian')
                    ->sum('jumlah');

                    // dd($total);
        
        if($request->jenis_transaksi == 0 && ($total + $request->jumlah) > 10000){
            return redirect('transaksikantin')->with(['gagal' => 'santri sudah melewati batas harian']);
        }

        //tabel transaksi_uang_sakus
        TransaksiUangSaku::create([
            'id_siswa'          =>  $request->id_siswa,
            'keterangan'        =>  $request->jenis_transaksi == 0 ? 'jajan harian' : 'kebutuhan khusus',
            'jenis_transaksi'   =>  'keluar',
            'jumlah'            =>  $request->jumlah,
            'id_user'           =>  auth::user()->id
        ]);

        //tabel uang_sakus
        $uangsaku = UangSaku::find($data->id_uang_saku);
        $uangsaku->update([
            'saldo' => $uangsaku->saldo - $request->jumlah
        ]);

        return redirect('transaksikantin')->with(['sukses' => 'data berhsil disimpan']);

    }
}
