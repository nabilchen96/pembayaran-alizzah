<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $fillable = [
        'nis', 'nama_siswa', 'jk', 'alamat', 'no_telp', 'nama_ayah', 'nama_ibu'
    ];

    protected $primaryKey   = 'id_siswa';
}
