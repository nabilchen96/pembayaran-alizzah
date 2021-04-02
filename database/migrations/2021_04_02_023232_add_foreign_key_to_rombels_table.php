<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToRombelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rombels', function (Blueprint $table) {

            //id_kelas
            $table->bigInteger('id_kelas')->unsigned()->change();
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas');

            //id_siswa
            $table->bigInteger('id_siswa')->unsigned()->change();
            $table->foreign('id_siswa')->references('id_siswa')->on('siswas');

            //id_tahun
            $table->bigInteger('id_tahun')->unsigned()->change();
            $table->foreign('id_tahun')->references('id_tahun')->on('tahun_ajarans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rombels', function (Blueprint $table) {
            //
        });
    }
}
