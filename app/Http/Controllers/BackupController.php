<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackupController extends Controller
{
    public function index(){
        $data = array( 'tahun_ajarans', 'kelas', 'pegawais', 'siswas', 'jenis_pembayarans', 'set_pembayaran_kelas', 'keringanans',
                        'rombels', 'penerima_keringanans', 'set_gajis', 'transaksis', 'pengeluarans', 'rekap_transaksis', 'users'
        );

        return view('backup.index')->with('data', $data);
    }
}
