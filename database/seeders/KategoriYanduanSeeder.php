<?php

namespace Database\Seeders;

use App\Models\KategoriYanduan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriYanduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KategoriYanduan::insert([
            ['name' => 'AROGANSI'],
            ['name' => 'ASUSILA'],
            ['name' => 'BACKING'],
            ['name' => 'DISERSI'],
            ['name' => 'HUTANG PIUTANG'],
            ['name' => 'KEBERPIHAKAN'],
            ['name' => 'KETIDAKPROFESIONALAN'],
            ['name' => 'LAIN-LAIN'],
            ['name' => 'LGBT'],
            ['name' => 'PELECEHAN SEKSUAL'],
            ['name' => 'PENELANTARAN KELUARGA/KDRT'],
            ['name' => 'PENGANIAYAAN'],
            ['name' => 'PENGAWASAN'],
            ['name' => 'PENIPUAN'],
            ['name' => 'PENYALAHGUNAAN NARKOBA'],
            ['name' => 'PENYALAHGUNAAN WEWENANG'],
            ['name' => 'PERMOHONAN PERLINDUNGAN HUKUM'],
            ['name' => 'PERSELINGKUHAN'],
            ['name' => 'PUNGUTAN LIAR']
        ]);
    }
}
