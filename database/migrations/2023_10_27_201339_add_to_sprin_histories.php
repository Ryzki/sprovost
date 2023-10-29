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
        Schema::table('sprin_histories', function (Blueprint $table) {
            $table->text('no_nd_rehabpers')->nullable();
            $table->date('tgl_nd_rehabpers')->nullable();
            $table->string('unit_pemeriksa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sprin_histories', function (Blueprint $table) {
            //
        });
    }
};
