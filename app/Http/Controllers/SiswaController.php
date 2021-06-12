<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Siswa;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
use Importer;

class SiswaController extends Controller
{
    public function json(){
        // return Datatables::of(Siswa::all())->make(true);

        return DataTables::of(Siswa::all())
                ->toJson();
    }

    public function index(){
        return view('siswa.index');
    }

    public function create(){
        return view('siswa.create');
    }

    public function store(Request $request){
        
        $request->validate([
            'nis'           => 'required|unique:siswas',
            'nama_siswa'    => 'required',
            'jk'            => 'required'
        ]);

        try{

            Siswa::create([
                'nis'           => $request->input('nis'),
                'nama_siswa'    => $request->input('nama_siswa'),
                'jk'            => $request->input('jk'),
                'no_telp'       => $request->input('no_telp'),
                'nama_ayah'     => $request->input('nama_ayah'),
                'nama_ibu'      => $request->input('nama_ibu'),
                'alamat'        => $request->input('alamat')
            ]);

            //ke halaman siswa dan memberikan pesan sukses
            return redirect('siswa')->with(['sukses' => 'Data Berhasil Disimpan']);

        }catch(Exception $e){

            //kembali dan memberikan pesan error
            return back()->with(['gagal' => 'error '.$e->getMessage()]);
        }
    }

    public function edit($id){
        $siswa  = Siswa::find($id);
        return view('siswa.edit')->with('siswa', $siswa);
    }

    public function update(Request $request){
        
        $request->validate([
            'nis'           => 'required|unique:siswas,nis,'.$request->input('id_siswa').',id_siswa',
            'nama_siswa'    => 'required',
            'jk'            => 'required',
            'id_siswa'      => 'required'
        ]);

        try{

            $siswa = Siswa::find($request->input('id_siswa'));
            $siswa->update([
                'nis'           => $request->input('nis'),
                'nama_siswa'    => $request->input('nama_siswa'),
                'jk'            => $request->input('jk'),
                'no_telp'       => $request->input('no_telp'),
                'nama_ayah'     => $request->input('nama_ayah'),
                'nama_ibu'      => $request->input('nama_ibu'),
                'alamat'        => $request->input('alamat')
            ]);

            //ke halaman siswa dan memberikan pesan sukses
            return redirect('siswa')->with(['sukses' => 'Data Berhasil Diupdate']);

        }catch(Exception $e){

            //kembali dan memberikan pesan error
            return back()->with(['gagal' => 'error '.$e->getMessage()]);
        }
    }

    public function destroy($id){
        try{
            $siswa  = Siswa::find($id);
            $siswa->delete();

            return redirect('siswa')->with(['sukses' => 'Data Berhasil Dihapus']);
        }catch (Exception $e) {
            return back()->with(['gagal' => 'Hapus Data Terkait Terlebih Dahulu Untuk Menghapus Data Ini']);
        }
    }

    public function export(){
        return Excel::download(new SiswaExport, 'Data_Siswa.xlsx');
    }

    public function import(Request $request){

        try{
            $file = $request->file;
            
            $excel = Importer::make('Excel');
            $excel->load($file);
            $collection = $excel->getCollection();
            
            foreach($collection as $k => $v){
                if($k > 0){
                    Siswa::create([
                        'nis'           => $v[0],
                        'nama_siswa'    => $v[1],
                        'jk'            => $v[2],
                        'no_telp'       => $v[3],
                        'nama_ayah'     => $v[4],
                        'nama_ibu'      => $v[5],
                        'alamat'        => $v[6]
                    ]);
                }
            }

            return back()->with(['sukses' => 'Data Berhasil Diimport']);

        }catch(Exception $e){

            return back()->with(['gagal' => $e->getMessage()]);
        }


        
    }
}
