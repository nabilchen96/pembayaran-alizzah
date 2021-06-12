<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setgaji;
use App\Pegawai;
use DB;
use App\Exports\GajiPegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class SetGajiController extends Controller
{
    public function index(){
        $data = Pegawai::whereNotIn(
            'id_pegawai', function($query){
                $query->select('id_pegawai')->from('set_gajis');
            }
        )->get();

        $gaji = DB::table('set_gajis')
                ->join('pegawais', 'pegawais.id_pegawai', '=', 'set_gajis.id_pegawai')
                ->select(
                    'pegawais.nama_pegawai',
                    'pegawais.nip',
                    'pegawais.id_pegawai',
                    DB::raw('sum(gaji_rincian) as gaji_rincian')
                )
                ->groupBy('pegawais.id_pegawai')
                ->get();

        return view('setgaji.index')->with('data', $data)->with('gaji', $gaji);
    }

    public function store(Request $request){
        $request->validate([
            'id_pegawai'    => 'required',
        ]);

        $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();

        for($i=0; $i<=count($request->input('jenis_rincian'))-1; $i++){
            if($request->input('jenis_rincian')[$i] != null){
                Setgaji::create([
                    'id_pegawai'    => $request->input('id_pegawai'),
                    'jenis_rincian' => $request->input('jenis_rincian')[$i],
                    'gaji_rincian'  => $request->input('gaji_rincian')[$i],
                    'id_tahun'      => $tahun->id_tahun
                ]);
            }
        }

        return back()->with(['sukses' => 'Data Berhasil Disimpan!']);
    }

    public function edit($id){
        $data = DB::table('set_gajis')
                ->join('pegawais', 'pegawais.id_pegawai', '=', 'set_gajis.id_pegawai')
                ->where('pegawais.id_pegawai', $id)
                ->get();

        return view('setgaji.edit')
                ->with('data', $data);
    }

    public function update(Request $request){
        $tahun = DB::table('tahun_ajarans')->where('status_aktif', 1)->first();
        for($i=0; $i<=count($request->input('id_setgaji_old'))-1; $i++){
            $data = Setgaji::find($request->input('id_setgaji_old')[$i]);
            $data->update([
                'id_pegawai'    => $request->input('id_pegawai'),
                'jenis_rincian' => $request->input('jenis_rincian_old')[$i],
                'gaji_rincian'  => $request->input('gaji_rincian_old')[$i],
                'id_tahun'      => $tahun->id_tahun
            ]);
        }

        for($i=0; $i<=count($request->input('jenis_rincian'))-1; $i++){
            if($request->input('jenis_rincian')[$i] != null){
                Setgaji::create([
                    'id_pegawai'    => $request->input('id_pegawai'),
                    'jenis_rincian' => $request->input('jenis_rincian')[$i],
                    'gaji_rincian'  => $request->input('gaji_rincian')[$i],
                    'id_tahun'      => $tahun->id_tahun
                ]);
            }
        }

        return redirect('setgaji')->with(['sukses' => 'Data Berhasil Disimpan']);
    }

    public function destroy($id){
        Setgaji::where('id_pegawai', $id)->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }

    public function destroygaji($id){
        Setgaji::find($id)->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }

    public function export(){
        return Excel::download(new GajiPegawaiExport, 'Data Gaji Pegawai.xlsx');
    }
}
