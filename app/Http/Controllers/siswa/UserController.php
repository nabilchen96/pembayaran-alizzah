<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Siswa;
use auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

    }

    public function edit(){

        $siswa = Siswa::where('nis', auth::user()->email)->first();
        return view('dashboardsiswa.profil.index')->with('siswa', $siswa);
    }

    public function update(Request $request){

        $request->validate([
            'nama_siswa'    => 'required',
            'jk'            => 'required',
            'id_siswa'      => 'required',
        ]);


        $siswa = Siswa::find($request->input('id_siswa'));
        $pass  = $siswa->password;
        $siswa->update([
            'nama_siswa'    => $request->input('nama_siswa'),
            'jk'            => $request->input('jk'),
            'no_telp'       => $request->input('no_telp'),
            'nama_ayah'     => $request->input('nama_ayah'),
            'nama_ibu'      => $request->input('nama_ibu'),
            'alamat'        => $request->input('alamat'),
            'password'      => $request->password ? $request->password : $pass
        ]);

        if($request->password){
            User::updateOrCreate(
                ['email' => $siswa->nis],
                [
                    'name'          => $request->nama_siswa,
                    'role'          => 'siswa',
                    'siswa'         => $request->siswa,
                    'password'      => Hash::make($request->password)
                ]
            );
        }

        return back()->with(['sukses' => 'Data berhasil diupdate!']);
    }
}
