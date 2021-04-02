<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'kelas', 'jenjang'
    ];

    protected $primaryKey = 'id_kelas';
}
