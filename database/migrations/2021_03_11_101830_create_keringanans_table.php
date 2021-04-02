<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeringanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keringanans', function (Blueprint $table) {
            $table->bigIncrements('id_keringanan');
            $table->string('keringanan');
            $table->integer('besaran_keringanan');
            $table->bigInteger('id_jenis_pembayaran');
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
        Schema::dropIfExists('keringanans');
    }
}
