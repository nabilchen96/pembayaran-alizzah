<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SetPembayaranKelas;
use App\Kelas;
use DB;
use App\JenisPembayaran;
use Exception;

class SetPembayaranKelasController extends Controller
{
    public function index($id){
        $setpembayarankelas = DB::table('set_pembayaran_kelas')
                                ->join('kelas', 'kelas.id_kelas', '=', 'set_pembayaran_kelas.id_kelas')
                                ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                                ->where('jenis_pembayarans.id_jenis_pembayaran', $id)
                                ->get();

        $kelas              = DB::table('kelas')
                                ->whereNotIn('id_kelas', function($query) use ($id){
                                    $query->select('id_kelas')->from('set_pembayaran_kelas')->where('id_jenis_pembayaran', $id);
                                })->get();

                            

        $jenispembayaran    = JenisPembayaran::where('id_jenis_pembayaran', $id)->first();

        return view('setpembayarankelas')
            ->with('setpembayarankelas', $setpembayarankelas)
            ->with('kelas', $kelas)
            ->with('jenispembayaran', $jenispembayaran);
    }


    public function store(Request $request)
    {
        //validasi
        $request->validate([
            'id_jenis_pembayaran'   => 'required',
            'id_kelas'              => 'required',
            'biaya'                 => 'required',
            'keterangan'            => 'required'
        ]);
        
        //memeriksa error
        try{

            //input data ke database
            SetPembayaranKelas::create([
                'id_jenis_pembayaran'   => $request->input('id_jenis_pembayaran'),
                'id_kelas'              => $request->input('id_kelas'),
                'biaya'                 => $request->input('biaya'),
                'keterangan'            => $request->input('keterangan')
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
            'id_jenis_pembayaran'   => 'required',
            'id_kelas'              => 'required',
            'biaya'                 => 'required',
            'keterangan'            => 'required'
        ]);
        
        //memeriksa error
        try{

            //update data ke database
            $pembayarankelas  = SetPembayaranKelas::find($request->input('id_set_pembayaran_kelas'));
            $pembayarankelas->update([
                'id_jenis_pembayaran'   => $request->input('id_jenis_pembayaran'),
                'id_kelas'              => $request->input('id_kelas'),
                'biaya'                 => $request->input('biaya'),
                'keterangan'            => $request->input('keterangan')
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
            $pembayarankelas = SetPembayaranKelas::find($id);
            $pembayarankelas->delete();

            return back()->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }


    public function json(Request $request){
        // $setpembayaran = SetPembayaranKelas::where('id_jenis_pembayaran', $request->input('id_jenis_pembayaran'))->get();

        $setpembayaran = DB::table('set_pembayaran_kelas')
                            ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'set_pembayaran_kelas.id_jenis_pembayaran')
                            ->join('kelas', 'kelas.id_kelas', '=', 'set_pembayaran_kelas.id_kelas')
                            ->where('jenis_pembayarans.id_jenis_pembayaran', $request->input('id_jenis_pembayaran'))
                            ->get();
        
        return json_encode($setpembayaran);
    }
}
