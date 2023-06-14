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
        Schema::create('sidang_disiplins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pelanggar_id');
            $table->date('tgl_sidang');
            $table->time('waktu_sidang');
            $table->text('lokasi_sidang');
            $table->string('hasil_sidang')->nullable();
            $table->text('hukuman_disiplin')->nullable();
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
        Schema::dropIfExists('sidang_disiplins');
    }
};
