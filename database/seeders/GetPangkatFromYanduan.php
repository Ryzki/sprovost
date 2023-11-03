<?php

namespace Database\Seeders;

use App\Http\Integration\YanduanIntegration;
use App\Models\Pangkat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GetPangkatFromYanduan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pangkat::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('pangkats')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $yanduan = new YanduanIntegration;
        $pangkat = $yanduan->getPangkat();
        $pangkat = $pangkat->data;
        foreach ($pangkat as $val) {
            Pangkat::create([
                'name' => $val->name
            ]);
        }
    }
}
