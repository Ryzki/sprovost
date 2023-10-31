<?php

namespace Database\Seeders;

use App\Models\Agama;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddToAgama extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agama::create([
            'name' => 'Hindu'
        ]);

        Agama::create([
            'name' => 'Konghucu'
        ]);

    }
}
