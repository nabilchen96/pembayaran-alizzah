<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;
use App\TahunAjaran;
use App\Rombel;
use Exception;
use DB;
use App\Exports\RombelExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use App\Siswa;

class RombelController extends Controller
{
    public function index(){
        $kelas = Kelas::all();
        return view('rombel.index')->with('kelas', $kelas);
    }

    public function addrombel(){

        $data = Siswa::whereNotIn(
            'id_siswa', function($query){
                $query->select('id_siswa')
                        ->from('rombels')
                        ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                        ->where('tahun_ajarans.status_aktif', '1');
            }
        )->get();
        
        return DataTables::of($data)
        ->toJson();
    }

    public function detail(Request $request){
        $rombel = DB::table('rombels')
                    ->join('tahun_ajarans', 'tahun_ajarans.id_tahun', '=', 'rombels.id_tahun')
                    ->join('siswas', 'siswas.id_siswa', '=', 'rombels.id_siswa')
                    ->where('tahun_ajarans.status_aktif', 1)
                    ->where('rombels.id_kelas', $request->input('id_kelas'))
                    ->get();

        $kelas  = Kelas::find($request->input('id_kelas'));
        $tahun  = TahunAjaran::where('status_aktif', 1)->first();


        return view('rombel.detail')
        ->with('kelas', $kelas)
        ->with('tahun', $tahun)
        ->with('rombel', $rombel);
    }

    public function store(Request $request){
        
        try{

            $datasiswa = $request->input('siswa');

            // var_dump(count($datasiswa));

            // dd($request->input('id_kelas'));

            //input data ke database
            for($i=0; $i<count($datasiswa); $i++){

                Rombel::create([
                    'id_kelas'  => $request->input('id_kelas'),
                    'id_siswa'  => $datasiswa[$i],
                    'id_tahun'  => $request->input('id_tahun')
                ]);
            }
            
            //kembali dan memberikan pesan sukses
            return back()->with(['sukses' => 'Data Berhasil Disimpan']);
            // return redirect('rombel');

        }catch (Exception $e) {

        //     //kembali dan memberikan pesan gagal
            return back()->with(['gagal' => 'error '.$e->getMessage()]);
        }
    }

    public function destroy($id){
        try{
            $rombel = Rombel::find($id);
            $rombel->delete();

            return back()->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }

    public function export($id_kelas){
        return Excel::download(new RombelExport($id_kelas), 'Lap.Rombel.xlsx');
    }
}
