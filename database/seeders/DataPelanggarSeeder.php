<?php

namespace Database\Seeders;

use App\Models\DataPelanggar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPelanggarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataPelanggar::create([
            'no_nota_dinas' => "10/24/propam",
            'wujud_perbuatan' => '60',
            'tanggal_nota_dinas' => '2023-02-01',
            'no_telp' => '085720966872',
            'kewarganegaraan' => 'Indonesia',
            'perihal_nota_dinas' => 'Pelimpahan Pengaduan Masyarakat a.n. Ahmad',
            'no_pengaduan' => "123456",
            'pelapor' => "Ahmad",
            'umur' => 24,
            'jenis_kelamin' => 1,
            'pekerjaan' => 'Karyawan Swasta',
            'agama' => 1,
            'alamat' => 'Jl. Cianjur wetan No. 666',
            'no_identitas' => 123456789,
            'jenis_identitas' => 1,
            'terlapor' => 'Rizky',
            'kesatuan' => 'Propam',
            'wilayah_hukum' => 'Mabes Polri',
            'tempat_kejadian' => 'Tebet',
            'kronologi' => 'Jatuh Bangun',
            'pangkat' => '15',
            'nama_korban' => 'Prayogi',
            'status_id' => 1,
            'nrp' => '12345',
            'tanggal_kejadian' => '2023-01-20',
            'jabatan' => 'KANIT POLDA METRO JAYA'
        ]);
    }
}
