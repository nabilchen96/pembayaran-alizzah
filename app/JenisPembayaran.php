<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $fillable = [
        'nama_pembayaran', 'biaya', 'id_kelas', 'total_pembayaran_pertahun', 'pembayaran_rutin'
    ];

    protected $primaryKey   = 'id_jenis_pembayaran';
}
