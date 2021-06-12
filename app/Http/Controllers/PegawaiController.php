<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
use App\Exports\PegawaiExport;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    public function index(){
        $data = Pegawai::all();
        return view('pegawai.index')->with('data', $data);
    }

    public function create(){
        return view('pegawai.create');
    }

    public function store(Request $request){
        $request->validate([
            'nik'   => 'required|unique:pegawais',
            'nip'   => 'required|unique:pegawais',
            'nama_pegawai'  => 'required',
            'jk'        => 'required',
            'jenis_pegawai' => 'required',
            'tgl_bergabung' => 'required',
        ]);

        Pegawai::create([
            'nik'   => $request->input('nik'),
            'nip'   => $request->input('nip'),
            'nama_pegawai'  => $request->input('nama_pegawai'),
            'alamat'        => $request->input('alamat'),
            'jk'            => $request->input('jk'),
            'no_telp'       => $request->input('no_telp'),
            'jenis_pegawai' => $request->input('jenis_pegawai'),
            'tgl_bergabung' => $request->input('tgl_bergabung')
        ]);

        return redirect('pegawai')->with(['sukses' => 'Data Berhasil Diinput!']);
    }

    public function edit($id){
        $pegawai = Pegawai::find($id);
        return view('pegawai.edit')->with('pegawai', $pegawai);
    }

    public function update(Request $request){
        $request->validate([
            'nik'   => 'required|unique:pegawais,nik,'.$request->input('id_pegawai').',id_pegawai',
            'nip'   => 'required|unique:pegawais,nip,'.$request->input('id_pegawai').',id_pegawai',
            'nama_pegawai'  => 'required',
            'jk'        => 'required',
            'jenis_pegawai' => 'required',
            'tgl_bergabung' => 'required',
            'id_pegawai'    => 'required',
        ]);

        $pegawai = Pegawai::find($request->input('id_pegawai'));
        $pegawai->update([
            'nik'   => $request->input('nik'),
            'nip'   => $request->input('nip'),
            'nama_pegawai'  => $request->input('nama_pegawai'),
            'alamat'        => $request->input('alamat'),
            'jk'            => $request->input('jk'),
            'no_telp'       => $request->input('no_telp'),
            'jenis_pegawai' => $request->input('jenis_pegawai'),
            'tgl_bergabung' => $request->input('tgl_bergabung')
        ]);

        return redirect('pegawai')->with(['sukses' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id){
        $pegawai = Pegawai::find($id);
        $pegawai->delete();

        return back()->with(['sukses' => 'Data Berhasil Dihapus!']);
    }

    public function export(){
        return Excel::download(new PegawaiExport, 'Data_Pegawai.xlsx');
    }
}
