<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keringanan;
use App\Siswa;
use DataTables;
use Exception;
use App\PenerimaKeringanan;
use DB;
use App\Exports\PenerimaKeringananExport;
use Maatwebsite\Excel\Facades\Excel;

class PenerimaKeringananController extends Controller
{
    public function index(){
        $keringanan = DB::table('keringanans')
                        ->join('jenis_pembayarans', 'jenis_pembayarans.id_jenis_pembayaran', '=', 'keringanans.id_jenis_pembayaran')
                        ->get();
        return view('penerimakeringanan.index')->with('keringanan', $keringanan);
    }

    public function detail(Request $request){
        $penerimakeringanan = DB::table('penerima_keringanans')
                                ->join('siswas', 'siswas.id_siswa','=','penerima_keringanans.id_siswa')
                                ->where('penerima_keringanans.id_keringanan', $request->input('id_keringanan'))
                                ->get();
        $keringanan         = Keringanan::find($request->input('id_keringanan'));

        return view('penerimakeringanan.detail')
        ->with('keringanan', $keringanan)
        ->with('penerimakeringanan', $penerimakeringanan);
    }

    public function create(Request $request){
        $keringanan = Keringanan::find($request->input('id_keringanan'));
        return view('penerimakeringanan.create')->with('keringanan', $keringanan);
    }

    public function store(Request $request){

        //validasi
        $request->validate([
            'id_keringanan'     => 'required',
            'id_siswa'          => 'required',
            'status_penerima'   => 'required',
            // 'berkas_keringanan' => 'required',
            'alasan_keringanan' => 'required'
        ]);

        // berkas
        if($request->file('berkas_keringanan') != null){
            $berkas         = $request->file('berkas_keringanan');
            $nama_berkas    = $berkas->getClientOriginalName();
            $berkas->move('file_upload', $nama_berkas);
        }

        try{

            PenerimaKeringanan::create([
                'id_keringanan'     => $request->input('id_keringanan'),
                'id_siswa'          => $request->input('id_siswa'),
                'status_penerima'   => $request->input('status_penerima'),
                'berkas_keringanan' => @$nama_berkas != null ? $nama_berkas : null,
                'alasan_keringanan' => $request->input('alasan_keringanan')
            ]);

            echo '<script>window.location="detailpenerimakeringanan?id_keringanan='.$request->input('id_keringanan').'";</script>';

        }catch(Exception $e){

            // kembali dan memberikan pesan gagal
            return back()->with(['gagal' => $e->getMessage()]);

            // echo $e->getMessage();
            // die;
        }
    }

    public function edit(Request $request){
        $penerima   = DB::table('penerima_keringanans')
                        ->join('siswas', 'siswas.id_siswa', '=', 'penerima_keringanans.id_siswa')
                        ->where('penerima_keringanans.id_penerima_keringanan', $request->id_penerima_keringanan)
                        ->first();

        $keringanan = Keringanan::find($request->input('id_keringanan'));

        return view('penerimakeringanan.edit')
        ->with('keringanan', $keringanan)
        ->with('penerima', $penerima);
    }

    public function update(Request $request){
        //validasi
        $request->validate([
            'id_keringanan'             => 'required',
            'id_siswa'                  => 'required',
            'status_penerima'           => 'required',
            'alasan_keringanan'         => 'required',
            'id_penerima_keringanan'    => 'required'
        ]);

        $file_path;

        try{
            $penerima = PenerimaKeringanan::find($request->input('id_penerima_keringanan'));

            if(empty($request->file('berkas_keringanan'))){

                $nama_berkas    = $penerima->berkas_keringanan;
            }else{

                $berkas         = $request->file('berkas_keringanan');
                $nama_berkas    = $berkas->getClientOriginalName();
                $berkas->move('file_upload', $berkas->getClientOriginalName());

                $path = public_path() . "/file_upload/" . $penerima->berkas_keringanan;
                unlink($path);
            }

            $penerima->update([
                'id_keringanan'     => $request->input('id_keringanan'),
                'id_siswa'          => $request->input('id_siswa'),
                'status_penerima'   => $request->input('status_penerima'),
                'berkas_keringanan' => $nama_berkas,
                'alasan_keringanan' => $request->input('alasan_keringanan')
            ]);

            echo '<script>window.location="detailpenerimakeringanan?id_keringanan='.$request->input('id_keringanan').'";</script>';

        }catch(Exception $e){

            // kembali dan memberikan pesan gagal
            return back()->with(['gagal' => $e->getMessage()]);
        }
    }

    public function destroy($id){
        
        try{
            $penerima = PenerimaKeringanan::find($id);
            
            $path = public_path() . "/file_upload/" . $penerima->berkas_keringanan;
            unlink($path);

            $penerima->delete();

            return back()->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }

    public function export($id_keringanan){
        return Excel::download(new PenerimaKeringananExport($id_keringanan), 'Lap. Penerima Keringanan.xlsx');
    }
}
