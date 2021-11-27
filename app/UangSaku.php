<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UangSaku extends Model
{
    protected $primaryKey = 'id_uang_saku';

    protected $fillable = [
        'id_siswa', 'saldo', 'limit_jajan_harian'
    ];
}
