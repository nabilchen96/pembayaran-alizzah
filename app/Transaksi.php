<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'tgl_transaksi', 'id_siswa', 'id_jenis_pembayaran', 'jumlah_bayar', 'keterangan',
        'nama_pembayar', 'id_tahun', 'kd_nota', 'id_kelas'
    ];

    protected $primaryKey = 'id_transaksi';
}
