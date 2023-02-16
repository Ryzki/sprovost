<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Process;
use App\Models\SubProcess;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $adminRole = Role::create(['name' => 'admin']);
        $permission = Permission::where('name', 'manage-auth')->first();
        $adminRole->givePermissionTo($permission);
        $user = User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'password' => bcrypt('123456')
        ]);

        $user->assignRole($adminRole);


        Process::create([
            'name' => 'Diterima'
        ]);

        Process::create([
            'name' => 'Disposisi'
        ]);

        Process::create([
            'name' => 'Pulbaket / Lidik'
        ]);

        Process::create([
            'name' => 'Gelar Lidik'
        ]);

        Process::create([
            'name' => 'Limpah Polda'
        ]);

        Process::create([
            'name' => 'Sidik / LPA'
        ]);

        Process::create([
            'name' => 'Sidang Disiplin'
        ]);

        $subprocess =
        [
            [
                'process_id' => '2',
                'name' => 'Disposisi Karo / Sesro Ke Gakkum',
                'required' => 0
            ],[
                'process_id' => '2',
                'name' => 'Disposisi Rikum / Riksa / Pemeriksa Utama 1-6',
                'required' => 0
            ],[
                'process_id' => '3',
                'name' => 'SPRIN Lidik',
                'required' => 1
            ],[
                'process_id' => '3',
                'name' => 'SP2HP2 Awal',
                'required' => 1
            ],[
                'process_id' => '3',
                'name' => 'SP2HP2 Akhir',
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
                'process_id' => '3',
                'name' => 'ND Permohonan Gelar Perkara',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'Undangan Gelar',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'Gelar',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'Notulen Hasil Gelar',
                'required' => 0
            ],[
                'process_id' => '4',
                'name' => 'Laporan Hasil Gelar',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'SPRIN Sidik',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'UUK',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'Undangan Pemeriksaan',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'BAP',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'Tambahan Alat Bukti',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'Laporan Hasil',
                'required' => 0
            ],[
                'process_id' => '6',
                'name' => 'ND Permohonan Gelar Sidik',
                'required' => 0
            ]
        ];

        SubProcess::insert($subprocess);

        $this->call([
            AgamaSeeder::class,
            JenisKelaminSeed::class,
            JenisIdentitasSeeder::class,
          ]);
    }
}
