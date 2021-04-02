<?php

use Illuminate\Database\Seeder;
use DB as DBS;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<=20000; $i++){

        
        DBS::table('keringanans')->insert([
            'keringanan' => 'Lorem Ipsum Sit Dolor Amet',
            'besaran_keringanan' => 2500000,
            'id_jenis_pembayaran' => 3
        ]);


        }
    }
}
