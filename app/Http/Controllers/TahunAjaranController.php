<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TahunAjaran;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;
use DB;

class TahunAjaranController extends Controller
{
    public function json(){
        $tahun = TahunAjaran::select(
            'tahun',
            'status_aktif',
            // DB::raw('DATE_FORMAT(tgl_mulai, "%d-%m-%Y") as tgl_mulai'),
            // DB::raw('DATE_FORMAT(tgl_akhir, "%d-%m-%Y") as tgl_akhir'),
            'tgl_mulai',
            'tgl_akhir',
            'id_tahun'
        )->get();
        return Datatables::of($tahun)->make(true);
    }

    public function index()
    {
        return view('tahunajaran');
    }

    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'tahun'         => 'required',
            'tgl_mulai'    => 'required',
            'tgl_akhir'   => 'required'
        ]);
        
        //memeriksa error
        try{

            //input data ke database
            $tahun = TahunAjaran::create([
                'tahun'         => $request->input('tahun'),
                'status_aktif'  => '0',
                'tgl_mulai'     => $request->input('tgl_mulai'),
                'tgl_akhir'     => $request->input('tgl_akhir')    
            ]);
            
            //kembali dan memberikan pesan sukses
            return back()->with(['sukses' => 'Data Berhasil Disimpan']);

        }catch (Exception $e) {

            //kembali dan memberikan pesan gagal
            return back()->with(['gagal' => 'error '.$e->getMessage()]);
        }

        
    }

    public function update(Request $request)
    {
        //validasi
        $request->validate([
            'tahun'     => 'required',
            'id_tahun'  => 'required',
            'tgl_mulai' => 'required',
            'tgl_akhir' => 'required'
        ]);
        
        //memeriksa error
        try{

            //update data ke database
            $tahun  = TahunAjaran::find($request->input('id_tahun'));
            $tahun->update([
                'tahun'     => $request->input('tahun'),
                'tgl_mulai' => $request->input('tgl_mulai'),
                'tgl_akhir' => $request->input('tgl_akhir')         
            ]);
            
            //kembali dan memberikan pesan sukses
            return back()->with(['sukses' => 'Data Berhasil Diupdate']);
            

        }catch(Exception $e){  

            //kembali dan memberikan pesan gagal
            return back()->with(['gagal' => $e->getMessage()]);
        }
    }

    public function setactive($id){
        $tahun      = TahunAjaran::find($id);
        $cektahun   = TahunAjaran::where('status_aktif', 1)->count();

        if($tahun->status_aktif == 0){
            if($cektahun == 1){
                return back()->with(['gagal' => 'Silahkan nonaktifkan tahun yang sedang aktif']);
            }else{
                // if($tahun->tgl_mulai > now()){
                //     return back()->with(['gagal' => 'Tanggal Mulai Lebih Besar Dari Hari Ini']);
                // }else{
                    $tahun->update([
                        'status_aktif'  => '1'
                    ]);
                // }

                return back()->with(['sukses' => 'Tahun Berhasil Diaktifkan']);
            }
        }else{
            $tahun->update([
                'status_aktif'  => '0'
            ]);

            return back()->with(['sukses' => 'Tahun Berhasil Dinonaktifkan']);
        }
    }

}
