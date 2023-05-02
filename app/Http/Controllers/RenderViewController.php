<?php

namespace App\Http\Controllers;


use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\Disposisi;
use App\Models\GelarPerkara;
use App\Models\JenisIdentitas;
use App\Models\JenisKelamin;
use App\Models\LPA;
use App\Models\Pangkat;
use App\Models\Process;
use App\Models\PublicWitness;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use App\Models\SubProcess;
use App\Models\Witness;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
                return $this->gelarLidik($kasus_id);
                break;
            case 5:
                return $this->gelarLidik($kasus_id);
                break;
            case 6:
                return $this->sidik($kasus_id);
                break;
            case 7:
                return $this->sidang_disiplin($kasus_id);
                break;
            case 8:
                return $this->viewDiterima($kasus_id, $status_id);
                break;
            default:
                return 404;
                break;
        }
    }

    private function viewDiterima($id, $status_id)
    {
        $kasus = DataPelanggar::find($id);
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
        ];

        return view('pages.data_pelanggaran.proses.diterima', $data);
    }

    private function viewPulbaket($id, $status_id){
        $kasus = DataPelanggar::find($id);
        $status = Process::find($status_id);
        $sub_process = SubProcess::where('process_id', $status->id)->get();
        // $sub_process = SubProcess::where('process_id', 3)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->with('user')->first();
        $sp2hp2 = Sp2hp2History::where('data_pelanggar_id', $id)->with('user')->first();
        $agama = Agama::get();
        $saksi = Witness::where('data_pelanggar_id', $id)->get();
        $pangkat = Pangkat::all();

        $data = [
            'kasus' => $kasus,
            'pangkats' => $pangkat,
            'status' => $status,
            'sub_process' => $sub_process,
            'sprin' => $sprin,
            'sp2hp2' => $sp2hp2,
            'agamas' => $agama,
            'saksi' => $saksi
        ];

        return view('pages.data_pelanggaran.proses.pulbaket', $data);
    }

    private function gelarLidik($id){
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();
        // $sprin = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'lidik')->with('user')->first();
        $sprinGelar = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'gelar')->with('user')->first();
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $id)->with('penyidik')->first();
        // dd($gelarPerkara);
        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
            'sprinGelar' => $sprinGelar,
            'gelarPerkara' => $gelarPerkara
        ];

        return view('pages.data_pelanggaran.proses.gelarlidik', $data);
    }

    private function sidik($id){
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();
        $lpa = LPA::where('data_pelanggar_id', $id)->first();
        $sprinRiksa = SprinHistory::where('data_pelanggar_id', $id)->where('type', 'riksa')->with('user')->first();
        $saksi = PublicWitness::where('data_pelanggar_id', $id)->get();
        $agama = Agama::get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
            'lpa' => $lpa,
            'sprin' => $sprinRiksa,
            'saksi' => $saksi,
            'agamas' => $agama
        ];

        return view('pages.data_pelanggaran.proses.sidik_lpa', $data);
    }

    private function sidang_disiplin($id){
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
        ];

        return view('pages.data_pelanggaran.proses.sidang_disiplin', $data);
    }
}
