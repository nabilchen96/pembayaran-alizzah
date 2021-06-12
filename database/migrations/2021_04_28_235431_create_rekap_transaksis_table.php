<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_transaksis', function (Blueprint $table) {
            $table->bigIncrements('id_rekap_transaksi');
            $table->date('tgl_transaksi');
            $table->string('jenis_transaksi');
            $table->integer('jumlah_transaksi');
            $table->text('keterangan');
            $table->string('kd_nota');
            $table->integer('id_tahun');
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
        Schema::dropIfExists('rekap_transaksis');
    }
}
