<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    protected $fillable = [
        'tgl_pengeluaran', 'keterangan', 'harga_satuan', 'qty', 'total_harga', 'id_tahun', 'kd_nota'
    ];

    protected $primaryKey = 'id_pengeluaran';
}
