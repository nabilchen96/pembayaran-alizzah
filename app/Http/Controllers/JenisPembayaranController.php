<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Kelas;
use App\JenisPembayaran;
use DB;

class JenisPembayaranController extends Controller
{
    public function json(){
        return Datatables::of(JenisPembayaran::all())->make(true);
    }

    public function index(){
        $kelas = Kelas::all();
        return view('jenispembayaran')->with('kelas', $kelas);
    }

    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'nama_pembayaran'           => 'required',
            'total_pembayaran_pertahun' => 'required',
            'pembayaran_rutin'          => 'required',
        ]);

        //memeriksa error
        try{

            //input data ke database
            JenisPembayaran::create([
                'nama_pembayaran'           => $request->input('nama_pembayaran'),
                'total_pembayaran_pertahun' => $request->input('total_pembayaran_pertahun'),
                'pembayaran_rutin'          => $request->input('pembayaran_rutin')
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
            'nama_pembayaran'           => 'required',
            'total_pembayaran_pertahun' => 'required',
            'pembayaran_rutin'          => 'required'
        ]);

        //memeriksa error
        try{

            //update data ke database
            $kelas  = JenisPembayaran::find($request->input('id_jenis_pembayaran'));
            $kelas->update([
                'nama_pembayaran'           => $request->input('nama_pembayaran'),
                'total_pembayaran_pertahun' => $request->input('total_pembayaran_pertahun'),
                'pembayaran_rutin'          => $request->input('pembayaran_rutin')
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
            $jenispembayaran = JenisPembayaran::find($id);
            $jenispembayaran->delete();

            return back()->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }
}
