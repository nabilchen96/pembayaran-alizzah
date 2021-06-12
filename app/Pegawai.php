<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'nip', 'nik', 'nama_pegawai', 'jk', 'no_telp', 'alamat',
        'jenis_pegawai', 'tgl_bergabung'
    ];

    protected $primaryKey = 'id_pegawai';
}
