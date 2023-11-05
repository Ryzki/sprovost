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
        Schema::table('data_pelanggars', function (Blueprint $table) {
            // $table->integer('print_nd')->after('status_id')->nullable()->default(0);
            $table->integer('kategori_yanduan_id')->after('print_nd')->nullable()->default(null);
            $table->string('data_from')->after('kategori_yanduan_id')->nullable()->default('input');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_pelanggars', function (Blueprint $table) {
            //
        });
    }
};
