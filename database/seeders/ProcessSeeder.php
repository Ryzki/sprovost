<?php

namespace Database\Seeders;

use App\Models\Process;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Process::create([
            'name' => 'Diterima'
        ]);

        Process::create([
            'name' => 'Disposisi Diterima'
        ]);

        Process::create([
            'name' => 'Penyelidikan'
        ]);

        Process::create([
            'name' => 'Gelar Lidik'
        ]);

        Process::create([
            'name' => 'Limpah Polda'
        ]);

        Process::create([
            'name' => 'Pemberkasan'
        ]);

        Process::create([
            'name' => 'Sidang Disiplin'
        ]);

        Process::create([
            'name' => 'Selesai'
        ]);
    }
}
