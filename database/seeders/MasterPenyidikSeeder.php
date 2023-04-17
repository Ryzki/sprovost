<?php

namespace Database\Seeders;

use App\Models\MasterPenyidik;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterPenyidikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nama = ['DWI SAMAYO SATIADY,SIK','EDWIN LOUIS SENGKA, S.I.K,M.Si.','LIRISMAN MARBUN,S.H,.M.H.','ANGGA NAZMI SAPUTRA','THUBAGUS','ERICSON SIREGAR, S.Kom,MT,M.Sc','ACHMAD HUSNI IMAWAN,S.Tr.K,SIK','APRI AJI SETYAWAN, S.H.','YOBIE ARI YUANDANA','SANDI YUDHA WIRATAMA, S.H.','YULIUS SYAHPUTRA, S.Tr.K, SIK','DIMAS ERI PRABOWO, S.Tr.K', 'GILANG EKA NUGRAHA','I KADEK NOVA ADI WIJAYA KUSUMA', 'MUHAMMAD MAHDII HEAVENY NOVIANSYAH, S.Tr.K', 'I MADE PUTRA SETYA DHARMA', 'RINALDI PUTRA ISTIYONO'];
        $pangkat = ['KOMBES POL', 'AKBP', 'IPTU', 'BRIPTU', 'BRIGADIR','AKP', 'IPTU', 'IPDA', 'BRIPTU', 'BRIPTU', 'IPTU', 'IPDA', 'BRIGADIR', 'BRIGADIR', 'IPDA', 'BRIPTU', 'BRIPDA'];
        $nrp = ['78050947', '78081217', '78071162', '94110803', '9501033', '88090982', '94081263', '87040482', '96090598', '97060437', '93071063', '95091233', '90120155', '94110684', '98110752', '97100356', '00110861'];
        $jabatan = ['KADEN A', 'WAKADEN A', 'PS.PANIT 2 UNIT I DEN A', 'BANIT DEN A', 'BANIT I DEN A', 'PS.KANIT II DEN A', 'PS. PANIT 1 UNIT II DEN A', 'PS.PANIT 2 UNIT II DEN A', 'BANIT DEN A', 'BANIT DEN A', 'PS. PANIT 1 UNIT III DEN A', 'PS.PANIT 2 UNIT III DEN A', 'BANIT DEN A', 'BANIT DEN A', 'PAMIN DEN A', 'BAMIN DEN A', 'BAMIN DEN A'];
        $tim = 'Den A';
        $unit = ['','','UNIT I', 'UNIT I', 'UNIT I', 'UNIT II', 'UNIT II', 'UNIT II', 'UNIT II', 'UNIT II', 'UNIT III', 'UNIT III', 'UNIT III', 'UNIT III', 'MIN DEN A', 'MIN DEN A', 'MIN DEN A'];

        foreach ($nama as $key => $value) {
            MasterPenyidik::create([
                'name' => $value,
                'pangkat' => $pangkat[$key],
                'nrp' => $nrp[$key],
                'jabatan' => $jabatan[$key],
                'tim' => $tim,
                'unit' => $unit[$key],
            ]);
        }
    }
}
