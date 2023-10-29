<?php

namespace Database\Seeders;

use App\Models\Polda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddWabprofToPolda extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Polda::create([
            'id' => 0,
            'name' => 'Wabprof',
        ]);
    }
}
