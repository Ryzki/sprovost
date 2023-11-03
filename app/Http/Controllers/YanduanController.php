<?php

namespace App\Http\Controllers;

use App\Http\Integration\YanduanIntegration;
use App\Models\DataPelanggar;
use App\Models\Pangkat;
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
        if(!session()->has('tokenYanduan')){
            $this->yanduan->getToken();
        }
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
            } else {
                if(count($yanduan->data) == 0){
                    throw new Exception('Tidak ada data yanduan pada range tanggal tersebut', 404);
                } else if($yanduan->message == 'Server Error'){
                    throw new Exception('Gagal Mengambil Data Dari Server Yanduan, Harap Coba Lagi', 500);
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
        foreach ($data as $yanduan) {
            if(str_contains($yanduan->biro, 'PROVOS')){

                $pangkat = null;
                if(count($yanduan->defendants) > 0){
                    $dataPangkat = Pangkat::where('name', $yanduan->defendants[0]->occupation)->first();
                    $pangkat = $dataPangkat != null ? $dataPangkat->id : null;
                }

                $tanggal_kejadian = null;
                if(count($yanduan->crime_scenes) > 0){
                    $tanggal_kejadian = Carbon::createFromFormat('d/m/Y H:i', $yanduan->crime_scenes[0]->datetime)->format('Y/m/d');
                }

                $checkIfExist = DataPelanggar::where('no_nota_dinas', $yanduan->nomor_nota_dinas)->first();
                if($checkIfExist == null){
                    array_push($tempDumas, [
                        'no_nota_dinas' => $yanduan->nomor_nota_dinas,
                        'no_pengaduan' => $yanduan->ticket_id,
                        'perihal_nota_dinas' => $yanduan->perihal_nota_dinas,
                        'kronologi' => str_replace('&nbsp;', '', strip_tags($yanduan->chronology)),
                        'tanggal_nota_dinas' => $yanduan->tanggal_nota_dinas,
                        'terlapor' => count($yanduan->defendants) > 0 ? $yanduan->defendants[0]->name : null,
                        'pangkat' => $pangkat,
                        'kesatuan' => $yanduan->defendants[0]->unit,
                        'nama_korban' => count($yanduan->victims) > 0 ? $yanduan->victims[0]->name : null,
                        'tempat_kejadian' => count($yanduan->crime_scenes) > 0 ? $yanduan->crime_scenes[0]->detail : null,
                        'tanggal_kejadian' => $tanggal_kejadian,

                        'wujud_perbuatan' => null,
                        'pelapor' => null,
                        'umur' => null,
                        'jenis_kelamin' => null,
                        'pekerjaan' => null,
                        'agama' => null,
                        'alamat' => null,
                        'no_identitas' => null,
                        'no_telp' => null,
                        'jenis_identitas' => null,
                        'nrp' => null,
                        'jabatan' => null,
                        'wilayah_hukum' => null,
                        'kewarganegaraan' => 'WNI',
                        'status_id' => 1,
                        'created_at' => now(),
                    ]);
                }
            }
        }

        DataPelanggar::insert($tempDumas);
    }
}
