<?php

namespace Database\Seeders;

use App\Models\JenisIdentitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisIdentitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JenisIdentitas::create([
            'name' => 'KTP'
        ]);

        JenisIdentitas::create([
            'name' => 'SIM'
        ]);


    }
}