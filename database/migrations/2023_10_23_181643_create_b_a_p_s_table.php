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
        Schema::create('b_a_p_s', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pelanggar_id');
            $table->bigInteger('penyidik1');
            $table->bigInteger('penyidik2');
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
        Schema::dropIfExists('b_a_p_s');
    }
};
