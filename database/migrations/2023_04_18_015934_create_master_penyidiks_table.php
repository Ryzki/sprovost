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
        Schema::create('master_penyidiks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nrp');
            $table->string('pangkat');
            $table->string('jabatan');
            $table->string('tim');
            $table->string('unit');
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
        Schema::dropIfExists('master_penyidiks');
    }
};
