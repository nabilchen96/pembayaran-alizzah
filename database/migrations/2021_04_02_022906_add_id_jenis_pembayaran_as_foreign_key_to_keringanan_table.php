<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdJenisPembayaranAsForeignKeyToKeringananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('keringanans', function (Blueprint $table) {
            $table->bigInteger('id_jenis_pembayaran')->unsigned()->change();
            $table->foreign('id_jenis_pembayaran')->references('id_jenis_pembayaran')->on('jenis_pembayarans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('keringanans', function (Blueprint $table) {
            //
        });
    }
}
