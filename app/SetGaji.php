<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetGaji extends Model
{
    protected $fillable = [
        'id_tahun', 'id_pegawai', 'jenis_rincian', 'gaji_rincian'
    ];

    protected $primaryKey   = 'id_setgaji';
}
