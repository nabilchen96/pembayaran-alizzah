<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToPenerimaKeringanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penerima_keringanans', function (Blueprint $table) {
            //id_keringanan
            $table->bigInteger('id_keringanan')->unsigned()->change();
            $table->foreign('id_keringanan')->references('id_keringanan')->on('keringanans');

            //id_siswa
            $table->bigInteger('id_siswa')->unsigned()->change();
            $table->foreign('id_siswa')->references('id_siswa')->on('siswas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penerima_keringanans', function (Blueprint $table) {
            //
        });
    }
}
