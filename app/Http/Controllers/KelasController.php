<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class KelasController extends Controller
{
    public function json(){
        return Datatables::of(Kelas::all())->make(true);
    }

    public function index(){
        return view('kelas');
    }

    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'kelas'     => 'required',
        ]);
        
        //memeriksa error
        try{

            //input data ke database
            $kelas = Kelas::create([
                'kelas'     => $request->input('kelas'),
                'jenjang'   => $request->input('jenjang')
            ]);
            
            //kembali dan memberikan pesan sukses
            return back()->with(['sukses' => 'Data Berhasil Disimpan']);

        }catch (Exception $e) {

            //kembali dan memberikan pesan gagal
            return back()->with(['gagal' => $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        //validasi
        $request->validate([
            'kelas'     => 'required',
            'id_kelas'  => 'required'
        ]);
        
        //memeriksa error
        try{

            //update data ke database
            $kelas  = Kelas::find($request->input('id_kelas'));
            $kelas->update([
                'kelas'     => $request->input('kelas'),
                'jenjang'   => $request->input('jenjang')
            ]);
            
            //kembali dan memberikan pesan sukses
            return back()->with(['sukses' => 'Data Berhasil Diupdate']);
            

        }catch(Exception $e){  

            //kembali dan memberikan pesan gagal
            return back()->with(['gagal' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        try{
            $kelas = Kelas::find($id);
            $kelas->delete();

            return back()->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }
}
