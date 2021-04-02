<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetPembayaranKelasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_pembayaran_kelas', function (Blueprint $table) {
            $table->bigIncrements('id_set_pembayaran_kelas');
            $table->bigInteger('id_jenis_pembayaran');
            $table->bigInteger('id_kelas');
            $table->integer('biaya');
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
        Schema::dropIfExists('set_pembayaran_kelas');
    }
}
