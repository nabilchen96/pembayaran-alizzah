<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RekapTransaksi extends Model
{
    protected $fillable = [
        'tgl_transaksi', 'jenis_transaksi', 'jumlah_transaksi', 'keterangan', 'kd_nota', 'id_tahun'
    ];

    protected $primaryKey   = 'id_rekap_transaksi';
}
