<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetGajisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_gajis', function (Blueprint $table) {
            $table->bigIncrements('id_setgaji');
            $table->integer('id_pegawai');
            $table->integer('id_tahun');
            $table->integer('jenis_rincian');
            $table->text('gaji_rincian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('set_gajis');
    }
}
