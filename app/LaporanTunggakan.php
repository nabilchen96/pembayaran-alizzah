<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaporanTunggakan extends Model
{
    protected $fillable = [
        'id_siswa', 'id_jenis_pembayaran', 'tgl_pembayaran', 'pembayaran_ke', 'id_tahun'
    ];

    protected $primaryKey = 'id_laporan_tunggakan';
}
