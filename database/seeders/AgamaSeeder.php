<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgamaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agama::create([
            'name' => 'Islam'
        ]);

        Agama::create([
            'name' => 'Kristen'
        ]);

        Agama::create([
            'name' => 'Budha'
        ]);

        Agama::create([
            'name' => 'Katolik'
        ]);

        // Agama::create([
        //     'Islam'
        // ]);
    }
}