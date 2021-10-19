<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiUangSaku extends Model
{
    protected $primaryKey = 'id_transaksi_uang_saku';

    protected $fillable = [
        'id_siswa', 'jenis_transaksi', 'jumlah', 'keterangan', 'id_user'
    ];
}
