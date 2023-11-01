<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddRJStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Process::create([
            'name' => 'Dihentikan (RJ)'
        ]);
    }
}
