<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keringanan;
use DataTables;
use Exception;
use App\JenisPembayaran;
use DB;

class JenisKeringananController extends Controller
{
    public function json(){ 
        return Datatables::of(
            DB::table('keringanans')->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'keringanans.id_jenis_pembayaran')->get()
        )->make(true);
    }

    public function index(){
        $pembayaran = JenisPembayaran::all();
        return view('jeniskeringanan')->with('pembayaran', $pembayaran);
    }

    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'keringanan'            => 'required',
            'besaran_keringanan'    => 'required',
            'id_jenis_pembayaran'   => 'required'
        ]);
        
        //memeriksa error
        try{

            //input data ke database
            Keringanan::create([
                'keringanan'            => $request->input('keringanan'),
                'besaran_keringanan'    => $request->input('besaran_keringanan'),
                'id_jenis_pembayaran'   => $request->input('id_jenis_pembayaran')
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
            'keringanan'        => 'required',
            'besaran_keringanan'=> 'required'
        ]);
        
        //memeriksa error
        try{

            //update data ke database
            $keringanan  = Keringanan::find($request->input('id_keringanan'));
            $keringanan->update([
                'keringanan'        => $request->input('keringanan'),
                'besaran_keringanan'=> $request->input('besaran_keringanan')
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
            $keringanan = Keringanan::find($id);
            $keringanan->delete();

            return back()->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }
}
