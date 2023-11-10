<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('undangan_klarifikasi', function (Blueprint $table) {
            $table->dateTime('tgl_pertemuan');
            $table->string('ruang_pertemuan');
            $table->time('jam_pertemuan');
            $table->string('penyidik');
            $table->bigInteger('no_telp_penyidik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('undangan_klarifikasi', function (Blueprint $table) {
            //
        });
    }
};
