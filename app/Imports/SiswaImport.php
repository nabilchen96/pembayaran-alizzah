<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use App\Siswa;

class SiswaImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $k => $v){
            if($k = 1){
                Siswa::create([
                    'nis'           => $v[1],
                    'nama_siswa'    => $v[2],
                    'jk'            => $v[3],
                    'no_telp'       => $v[4],
                    'nama_ayah'     => $v[5],
                    'nama_ibu'      => $v[6],
                    'alamat'        => $v[6]
                ]);
            }
        }
    }
}
