<?php

namespace Database\Seeders;

use App\Models\Polda;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoldaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $polda = [
            'ACEH', 'BALI', 'BANTEN', 'BENGKULU', 'D.I. YOGYAKARTA',
            'GORONTALO', 'JAMBI', 'JAWA BARAT', 'JAWA TENGAH', 'JAWA TIMUR',
            'KALIMANTAN BARAT', 'KALIMANTAN SELATAN', 'KALIMANTAN TENGAH',
            'KALIMANTAN TIMUR', 'KALIMANTAN UTARA', 'KEPULAUAN BANGKA BELITUNG',
            'KEPULAUAN RIAU', 'LAMPUNG', 'MALUKU', 'MALUKU UTARA', 'METRO JAYA',
            'NTB', 'NTT', 'PAPUA', 'PAPUA BARAT', 'RIAU', 'SULAWESI BARAT',
            'SULAWESI SELATAN', 'SULAWESI TENGAH', 'SULAWESI TENGGARA', 'SULAWESI UTARA',
            'SUMATRA BARAT', 'SUMATRA SELATAN', 'SUMATRA UTARA'];

        foreach ($polda as $key => $value) {
            Polda::create([
                'name' => $value
            ]);
        }
    }
}
