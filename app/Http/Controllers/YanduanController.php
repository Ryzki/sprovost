<?php

namespace App\Http\Controllers;

use App\Http\Integration\YanduanIntegration;
use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\EvidenceReferenceModel;
use App\Models\JenisKelamin;
use App\Models\KategoriYanduan;
use App\Models\Pangkat;
use App\Models\PelaporIdentityReference;
use App\Models\WitnessReferenceModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class YanduanController extends Controller
{
    private $yanduan;
    public function __construct()
    {
        $this->yanduan = new YanduanIntegration();
    }

    public function index(){
        // if(!session()->has('tokenYanduan')){
        $this->yanduan->getToken();
        // }
        return view('pages.data_yanduan.index');
    }

    public function import(Request $request){
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required|after_or_equal:start_date'
        ],[
            'start_date' => 'Tanggal Mulai Nota Dinas Wajib Diisi',
            'end_date.required' => 'Tanggal Akhir Nota Dinas Wajib Diisi',
            'end_date.after_or_equal' => 'Tanggal Akhir Nota Dinas Tidak Boleh Lebih Dari Tanggal Mulai',
        ]);
        DB::beginTransaction();
        try {
            $yanduan = $this->yanduan->getProcessedReport($request->start_date, $request->end_date);

            if($yanduan->message == 'Token expired' || $yanduan->message == 'Unauthorized'){
                session()->forget('tokenYanduan');
                throw new Exception('Token API WA Yanduan Expired, harap refresh untuk memperbarui token', 401);
            } else if ($yanduan->message == 'Server Error') {
                throw new Exception('Gagal Mengambil Data Dari Server Yanduan, Harap Coba Lagi', 500);
            } else {
                if(count($yanduan->data) == 0){
                    throw new Exception('Tidak ada data yanduan pada range tanggal tersebut', 404);
                }

                self::ProcessData($yanduan->data);

                DB::commit();
                return response()->json([
                    'status' => [
                        'code' => 200,
                        'msg' => 'Berhasil Input Dumas',
                    ],
                ], 200);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'msg' => $th->getMessage(),
                ],
                'detail' => $th,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function ProcessData($data){
        $tempDumas = [];
        $tempWitnessReference = [];
        $tempEvidenceReference = [];
        $tempPelaporDetail = [];
        foreach ($data as $yanduan) {
            if(str_contains($yanduan->biro, 'PROVOS') && $yanduan->status == 'DISPOSISI'){

                $checkIfExist = DataPelanggar::where('no_nota_dinas', $yanduan->nomor_nota_dinas)->where('no_pengaduan', $yanduan->ticket_id)->first();
                if($checkIfExist == null){
                    $pangkat = null;
                    if(count($yanduan->defendants) > 0){
                        $dataPangkat = Pangkat::where('name', 'like', '%'.$yanduan->defendants[0]->occupation.'%')->first();
                        $pangkat = $dataPangkat != null ? $dataPangkat->id : null;
                    }

                    $tanggal_kejadian = null;
                    if(count($yanduan->crime_scenes) > 0){
                        $tanggal_kejadian = Carbon::createFromFormat('d/m/Y H:i', $yanduan->crime_scenes[0]->datetime)->format('Y/m/d');
                    }

                    $kategoriYanduan = null;
                    if($yanduan->category != '' || $yanduan->category != '-'){
                        $kategoriYanduan = KategoriYanduan::where('name', $yanduan->category)->first();
                        $kategoriYanduan = $kategoriYanduan != null ? $kategoriYanduan->id : null;
                    }

                    $age = null;
                    if($yanduan->reporter->dob != null){
                        $diff = date_diff(date_create($yanduan->reporter->dob), date_create(now()));
                        $age = $diff->format('%y');
                    }

                    $jk = null;
                    if($yanduan->reporter->gender != null){
                        $dataJK = JenisKelamin::where('name', 'like', '%'.$yanduan->reporter->gender.'%')->first();
                        $jk = $dataJK != null ? $dataJK->id : null;
                    }

                    $agama = null;
                    if($yanduan->reporter->religion != null){
                        $dataAgama = Agama::where('name', 'like', '%'.$yanduan->reporter->religion.'%')->first();
                        $agama = $dataAgama != null ? $dataAgama->id : null;
                    }

                    // Data Pelanggar
                    $dataPelanggar = DataPelanggar::create([
                        'no_nota_dinas' => $yanduan->nomor_nota_dinas,
                        'no_pengaduan' => $yanduan->ticket_id,
                        'perihal_nota_dinas' => $yanduan->perihal_nota_dinas,
                        'kronologi' => str_replace('&nbsp;', '', strip_tags($yanduan->chronology)),
                        'tanggal_nota_dinas' => $yanduan->tanggal_nota_dinas != '-' ? $yanduan->tanggal_nota_dinas : null,
                        'terlapor' => count($yanduan->defendants) > 0 ? $yanduan->defendants[0]->name : null,
                        'pangkat' => $pangkat,
                        'kesatuan' => count($yanduan->defendants) > 0 ? $yanduan->defendants[0]->unit : null,
                        'nama_korban' => count($yanduan->victims) > 0 ? $yanduan->victims[0]->name : null,
                        'tempat_kejadian' => count($yanduan->crime_scenes) > 0 ? $yanduan->crime_scenes[0]->detail : null,
                        'tanggal_kejadian' => $tanggal_kejadian,
                        'kategori_yanduan_id' => $kategoriYanduan,
                        'data_from' => 'yanduan',

                        'wujud_perbuatan' => null,
                        'pelapor' => $yanduan->reporter->name,
                        'umur' => $age,
                        'jenis_kelamin' => $jk,
                        'pekerjaan' => $yanduan->reporter->occupation,
                        'agama' => $agama,
                        'alamat' => $yanduan->reporter->alamat,
                        'no_identitas' => $yanduan->reporter->identity_number,
                        'no_telp' => $yanduan->reporter->phonenumber,
                        'jenis_identitas' => 1,
                        'nrp' => null,
                        'jabatan' => null,
                        'wilayah_hukum' => null,
                        'kewarganegaraan' => 'WNI',
                        'status_id' => 1,
                        'created_at' => now(),
                    ]);

                    // Data Witness Reference
                    if($yanduan->witness != 0){
                        WitnessReferenceModel::create([
                            'data_pelanggar_id' => $dataPelanggar->id,
                            'witness_detail' => $yanduan->witness_detail,
                        ]);
                    }

                    if(count($yanduan->evidences) > 0){
                        for ($i=0; $i < count($yanduan->evidences); $i++) {
                            EvidenceReferenceModel::create([
                                'data_pelanggar_id' => $dataPelanggar->id,
                                'evidence_path' => $yanduan->evidences[$i]->file_path
                            ]);
                        }
                    }

                    if($yanduan->reporter->id_card != null && $yanduan->reporter->selfie != null){
                        PelaporIdentityReference::create([
                            'data_pelanggar_id' => $dataPelanggar->id,
                            'id_card' => $yanduan->reporter->id_card,
                            'selfie' => $yanduan->reporter->selfie,
                        ]);
                    }
                }
            }
        }
    }
}
