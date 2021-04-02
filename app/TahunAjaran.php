<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $fillable = [
        'tahun', 'status_aktif', 'tgl_mulai', 'tgl_akhir'
    ];

    protected $primaryKey = 'id_tahun';
}
