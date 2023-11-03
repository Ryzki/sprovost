<?php

namespace App\Http\Controllers;


use App\Models\Agama;
use App\Models\BAI;
use App\Models\BAP;
use App\Models\DataPelanggar;
use App\Models\Disposisi;
use App\Models\DP3D;
use App\Models\GelarPerkara;
use App\Models\JenisIdentitas;
use App\Models\JenisKelamin;
use App\Models\LPA;
use App\Models\MasterPenyidik;
use App\Models\Pangkat;
use App\Models\Penyidik;
use App\Models\Polda;
use App\Models\Process;
use App\Models\PublicWitness;
use App\Models\SidangDisiplin;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use App\Models\SubProcess;
use App\Models\UndanganKlarifikasiHistories;
use App\Models\Witness;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RenderViewController extends Controller
{

    public function viewProcess($kasus_id,$status_id)
    {
        switch ($status_id) {
            case 1:
                return $this->viewDiterima($kasus_id, $status_id);
                break;
            case 2:
                return $this->viewDiterima($kasus_id, $status_id);
                break;
            case 3:
                return $this->viewPulbaket($kasus_id, $status_id);
                break;
            case 4:
                return $this->gelarLidik($kasus_id, $status_id);
                break;
            case 5:
                return $this->gelarLidik($kasus_id, $status_id);
                break;
            case 6:
                return $this->sidik($kasus_id, $status_id);
                break;
            case 7:
                return $this->sidang_disiplin($kasus_id, $status_id);
                break;
            case 8:
                return $this->sidang_disiplin($kasus_id, $status_id);
                break;
            case 9:
                return $this->gelarLidik($kasus_id, $status_id);
                break;
            case 10:
                return $this->gelarLidik($kasus_id, $status_id);
                break;
            default:
                return 404;
                break;
        }
    }

    private function viewDiterima($id, $status_id)
    {
        $kasus = DataPelanggar::find($id);
        if($kasus->status_id == 8 || $kasus->status_id == 5){
            $status_id = $kasus->status_id;
        }
        $status = Process::find($status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $sub_process = SubProcess::where('process_id', $status->id)->get();
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $wujud_perbuatan = WujudPerbuatan::get();
        $disposisiKaro = Disposisi::where('data_pelanggar_id', $id)->where('type', 'Karo')->first();
        $disposisiSesro = Disposisi::where('data_pelanggar_id', $id)->where('type', 'Sesro')->first();
        $disposisiKabag = Disposisi::where('data_pelanggar_id', $id)->where('type', 'Kabag')->first();
        $polda = Polda::where('id', '<>', 0)->get();

        $i_dis = 0;
        $i_ke = 0;
        foreach ($wujud_perbuatan as $key => $value) {
            if ($value->jenis_wp == 'disiplin') {
                $disiplin[$i_dis] = $value->keterangan_wp;
                $id_disiplin[$i_dis] = $value->id;
                $i_dis++;
            } else {
                $kode_etik[$i_ke] = $value->keterangan_wp;
                $id_kode_etik[$i_ke] = $value->id;
                $i_ke++;
            }
        }

        $disiplin = implode('|',$disiplin);
        $id_disiplin = implode('|',$id_disiplin);
        $kode_etik = implode('|',$kode_etik);
        $id_kode_etik = implode('|',$id_kode_etik);

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'sub_process' => $sub_process,
            'agama' => $agama,
            'jenis_identitas' => $jenis_identitas,
            'wujud_perbuatan' => $wujud_perbuatan,
            'disiplin' => $disiplin,
            'id_disiplin' => $id_disiplin,
            'kode_etik' => $kode_etik,
            'id_kode_etik' => $id_kode_etik,
            'jenis_kelamin' => $jenis_kelamin,
            'pangkats' => Pangkat::all(),
            'disposisiKaro' => $disposisiKaro,
            'disposisiSesro' => $disposisiSesro,
            'disposisiKabag' => $disposisiKabag,
            'polda' => $polda
        ];

        return view('pages.data_pelanggaran.proses.diterima', $data);
    }

    private function viewPulbaket($id, $status_id){
        $kasus = DataPelanggar::find($id);
        if($kasus->status_id == 8 || $kasus->status_id == 5){
            $status_id = $kasus->status_id;
        }
        $status = Process::find($status_id);
        $sub_process = SubProcess::where('process_id', $status->id)->get();
        // $sub_process = SubProcess::where('process_id', 3)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'lidik')->with('user')->first();
        $sp2hp2 = Sp2hp2History::where('data_pelanggar_id', $id)->with('user')->first();
        $agama = Agama::get();
        $saksi = Witness::where('data_pelanggar_id', $id)->get();
        $pangkat = Pangkat::all();
        $bai = BAI::where('data_pelanggar_id', $id)->first();
        $undanganKlarifikasi = UndanganKlarifikasiHistories::where('data_pelanggar_id', $id)->latest()->first();
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $id)->first();
        $unit = DB::table('master_penyidiks')->select('unit')->groupBy('unit')->get();

        if($bai != null){
            $penyidik1 = Penyidik::where('id', $bai->penyidik1)->first();
            $penyidik2 = Penyidik::where('id', $bai->penyidik2)->first();
        } else {
            $penyidik1 = null;
            $penyidik2 = null;
        }

        $data = [
            'kasus' => $kasus,
            'pangkats' => $pangkat,
            'status' => $status,
            'sub_process' => $sub_process,
            'sprin' => $sprin,
            'sp2hp2' => $sp2hp2,
            'agamas' => $agama,
            'saksi' => $saksi,
            'bai' => $bai,
            'penyidik1' => $penyidik1,
            'penyidik2' => $penyidik2,
            'undanganKlarifikasi' => $undanganKlarifikasi,
            'gelarPerkara' => $gelarPerkara,
            'unit' => $unit
        ];

        return view('pages.data_pelanggaran.proses.pulbaket', $data);
    }

    private function gelarLidik($id, $status_id){
        $kasus = DataPelanggar::find($id);
        if($kasus->status_id == 8 || $kasus->status_id == 5){
            $status_id = $kasus->status_id;
        }
        $status = Process::find($status_id);
        $sub_process = SubProcess::where('process_id', $status_id)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'lidik')->with('user')->first();
        $sprinGelar = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'gelar')->with('user')->first();
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $id)->with('penyidik')->first();
        $polda = Polda::all();
        $undanganKlarifikasi = UndanganKlarifikasiHistories::where('data_pelanggar_id', $id)->latest()->first();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
            'sprinGelar' => $sprinGelar,
            'gelarPerkara' => $gelarPerkara,
            'poldas' => $polda,
            'sprin' => $sprin,
            'undanganKlarifikasi' => $undanganKlarifikasi
        ];

        return view('pages.data_pelanggaran.proses.gelarlidik', $data);
    }

    private function sidik($id, $status_id){
        $kasus = DataPelanggar::find($id);
        if($kasus->status_id == 8 || $kasus->status_id == 5){
            $status_id = $kasus->status_id;
        }
        $status = Process::find($status_id);
        $sub_process = SubProcess::where('process_id', $status_id)->get();
        $lpa = LPA::where('data_pelanggar_id', $id)->first();
        $sprinRiksa = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'riksa')->with('user')->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'lidik')->with('user')->first();
        $saksi = PublicWitness::where('data_pelanggar_id', $id)->get();
        $saksiAhli = Witness::where('data_pelanggar_id', $id)->get();
        $agama = Agama::get();
        $dp3d = DP3D::where('data_pelanggar_id', $id)->first();
        $undanganKlarifikasi = UndanganKlarifikasiHistories::where('data_pelanggar_id', $id)->latest()->first();
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $id)->with('penyidik')->first();
        $pangkat = Pangkat::all();
        $unit = DB::table('master_penyidiks')->select('unit')->groupBy('unit')->get();
        $penyidikLPA = Penyidik::where('data_pelanggar_id', $id)->get();

        $bap = BAP::where('data_pelanggar_id', $id)->first();
        if($bap != null){
            $penyidik1 = Penyidik::where('id', $bap->penyidik1)->first();
            $penyidik2 = Penyidik::where('id', $bap->penyidik2)->first();
        } else {
            $penyidik1 = null;
            $penyidik2 = null;
        }


        $data = [
            'pangkats' => $pangkat,
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
            'lpa' => $lpa,
            'sprinRiksa' => $sprinRiksa,
            'sprin' => $sprin,
            'saksi' => $saksi,
            'saksiAhli' => $saksiAhli,
            'agamas' => $agama,
            'dp3d' => $dp3d,
            'penyidik1' => $penyidik1,
            'penyidik2' => $penyidik2,
            'bap' => $bap,
            'undanganKlarifikasi' => $undanganKlarifikasi,
            'gelarPerkara' => $gelarPerkara,
            'unit' => $unit
        ];

        return view('pages.data_pelanggaran.proses.sidik_lpa', $data);
    }

    private function sidang_disiplin($id){
        $kasus = DataPelanggar::find($id);
        if($kasus->status_id == 8 || $kasus->status_id == 5){
            $status_id = $kasus->status_id;
        }
        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'sidang')->with('user')->first();
        $sprinLidik = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'lidik')->with('user')->first();
        $sidang = SidangDisiplin::where('data_pelanggar_id', $id)->first();
        $dp3d = DP3D::where('data_pelanggar_id', $id)->first();
        $undanganKlarifikasi = UndanganKlarifikasiHistories::where('data_pelanggar_id', $id)->latest()->first();
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $id)->with('penyidik')->first();
        $dp3d = DP3D::where('data_pelanggar_id', $id)->first();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
            'sprin' => $sprin,
            'sprinLidik' => $sprinLidik,
            'sidang' => $sidang,
            'dp3d' => $dp3d,
            'undanganKlarifikasi' => $undanganKlarifikasi,
            'gelarPerkara' => $gelarPerkara,
            'dp3d' => $dp3d
        ];

        return view('pages.data_pelanggaran.proses.sidang_disiplin', $data);
    }
}
