<?php

namespace Database\Seeders;

use App\Models\SubProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RemoveSubProcess extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubProcess::where('process_id', 7)->where('name', 'NOTA HASIL PUTUSAN')->delete();
    }
}
