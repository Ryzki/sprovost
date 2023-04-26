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
        Schema::create('witnesses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pelanggar_id');
            $table->string('nama')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('nrp')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('kesatuan')->nullable();
            $table->string('ttl')->nullable();
            $table->string('warga_negara')->nullable();
            $table->integer('agama')->nullable();
            $table->string('alamat')->nullable();
            $table->string('no_telp')->nullable();
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
        Schema::dropIfExists('witnesses');
    }
};
