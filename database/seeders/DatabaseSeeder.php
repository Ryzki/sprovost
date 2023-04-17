<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\DataPelanggar;
use App\Models\MasterPenyidik;
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

        $this->call([
            AgamaSeeder::class,
            JenisKelaminSeed::class,
            JenisIdentitasSeeder::class,
            ProcessSeeder::class,
            SubProcessSeeder::class,
            DataPelanggarSeeder::class,
            PoldaSeeder::class,
            PangkatSeeder::class,
            WujudPerbuatanSeeder::class,
            MasterPenyidikSeeder::class
        ]);
    }
}
