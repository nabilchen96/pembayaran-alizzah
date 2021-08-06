<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePenerimaKeringanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penerima_keringanans', function (Blueprint $table) {
            $table->bigIncrements('id_penerima_keringanan');
            $table->bigInteger('id_keringanan');
            $table->bigInteger('id_siswa');
            $table->enum('status_penerima', [1, 0]);
            $table->string('berkas_keringanan')->nullable();
            $table->string('alasan_keringanan')->nullable();
            $table->bigInteger('id_tahun');
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
        Schema::dropIfExists('penerima_keringanans');
    }
}
