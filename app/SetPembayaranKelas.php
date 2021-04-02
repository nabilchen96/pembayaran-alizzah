<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetPembayaranKelas extends Model
{
    protected $fillable = [
        'id_jenis_pembayaran', 'id_kelas', 'biaya'
    ];

    protected $primaryKey   = 'id_set_pembayaran_kelas';
}
