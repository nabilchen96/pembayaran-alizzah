<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TransaksiKantinController extends Controller
{
    public function index(){

        return view('transaksikantin.index');
    }

    public function carisiswa($id){

        // dd($id);

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
