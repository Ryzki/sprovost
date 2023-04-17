<?php

namespace Database\Seeders;

use App\Models\Pangkat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PangkatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pangkat = [
            'Jenderal Polisi', 'Komjen Pol', 'Irjen Pol', 'Brigjen Pol',
            'Kombes Pol', 'AKBP', 'Kompol',
            'AKP', 'IPTU', 'IPDA',
            'AIPTU', 'AIPDA', 'BRIPKA', 'BRIGADIR', 'BRIPTU', 'BRIPDA',
            'ABRIP', 'ABRIPTU', 'ABRIPDA', 'BHARAKA', 'BHARATU', 'BHARADA',
            'Pembina Utama', 'Pembina Madya', 'Pembina Muda', 'Pembina Tk I', 'Pembina',
            'Penata Tk I', 'Penata', 'Penda Tk I', 'Penda', 'Pengatur Tk I', 'Pengatur',
            'Pengda Tk I', 'Pengda', 'Juru Tk I', 'Juru', 'Juru Muda Tk I'
        ];


        foreach ($pangkat as $key => $value) {
            Pangkat::create([
                'name' => $value
            ]);
        }
    }
}
