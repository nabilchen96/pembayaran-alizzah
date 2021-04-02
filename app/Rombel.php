<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    protected $fillable = [
        'id_kelas', 'id_siswa', 'id_tahun'
    ];

    protected $primaryKey = 'id_rombel';
}
