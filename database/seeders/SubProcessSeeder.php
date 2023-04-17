<?php

namespace Database\Seeders;

use App\Models\SubProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $subprocess =
        [
            [
                'process_id' => '2',
                'name' => 'Disposisi Karo',
                'required' => 0
            ],[
                'process_id' => '2',
                'name' => 'Disposisi Sesro',
                'required' => 0
            ],[
                'process_id' => '2',
                'name' => 'Disposisi Kabag Gakkum',
                'required' => 0
            ],[
                'process_id' => '3',
                'name' => 'SPRIN Lidik',
                'required' => 1
            ],[
                'process_id' => '3',
                'name' => 'Undangan Klarifikasi',
                'required' => 0
            ],[
                'process_id' => '3',
                'name' => 'BAI',
                'required' => 0
            ],[
                'process_id' => '3',
                'name' => 'Laporan Hasil Penyelidikan',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'SPRIN Gelar',
                'required' => 1
            ],[
                'process_id' => '4',
                'name' => 'Undangan Gelar',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'Laporan Hasil Gelar',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'SP2HP2',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'LPA',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'SPRIN RIKSA',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'Surat Panggilan Saksi',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'Surat Panggilan Terduga',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'BAP',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'DP3D',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'Surat Pelimpahan ke Ankum',
                'required' => 0
            ],[
                'process_id' => '7',
                'name' => 'NOTA DINA PERANGKAT SIDANG',
                'required' => 0
            ],[
                'process_id' => '7',
                'name' => 'SPRIN PERANGKAT SIDANG',
                'required' => 0
            ],[
                'process_id' => '7',
                'name' => 'Undangan Sidang Disiplin',
                'required' => 0
            ],[
                'process_id' => '7',
                'name' => 'Hasil Putusan Sidang Disiplin',
                'required' => 0
            ],[
                'process_id' => '7',
                'name' => 'NOTA HASIL PUTUSAN',
                'required' => 0
            ]
        ];

        SubProcess::insert($subprocess);
    }
}
