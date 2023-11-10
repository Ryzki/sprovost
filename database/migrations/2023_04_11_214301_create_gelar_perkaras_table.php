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
        Schema::create('gelar_perkaras', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pelanggar_id');
            $table->date('tgl_pelaksanaan')->nullable()->default(null);
            $table->string('waktu_pelaksanaan')->nullable()->default(null);
            $table->string('tempat_pelaksanaan')->nullable()->default(null);
            $table->string('pimpinan')->nullable()->default(null);
            $table->string('operator')->nullable()->default(null);
            $table->string('notulen')->nullable()->default(null);
            $table->string('pemapar')->nullable()->default(null);
            $table->string('hasil_gelar')->nullable()->default(null);
            $table->text('landasan_hukum')->nullable()->default(null);
            $table->string('keterangan_hasil')->nullable()->default(null);
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
        Schema::dropIfExists('gelar_perkaras');
    }
};
