<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keringanan extends Model
{
    protected $fillable = [
        'keringanan', 'besaran_keringanan', 'id_jenis_pembayaran'
    ];

    protected $primaryKey   = 'id_keringanan';
}
