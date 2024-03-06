<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\GelarPerkara;
use App\Models\JenisIdentitas;
use App\Models\JenisKelamin;
use App\Models\LimpahPolda;
use App\Models\LPA;
use App\Models\Pangkat;
use App\Models\Penyidik;
use App\Models\Polda;
use App\Models\Process;
use App\Models\PublicWitness;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use App\Models\SubProcess;
use App\Models\UndanganKlarifikasiHistories;
use App\Models\UndanganKlarifikasiHistory;
use App\Models\Witness;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class KasusController extends Controller
{
    public function index()
    {
        $data['kasuss'] = DataPelanggar::all();
        $data['kasus_dihentikan'] = DataPelanggar::whereIn('status_id', [9,10])->get();
        $data['kasus_selesai'] = DataPelanggar::where('status_id', 8)->get();
        $data['kasus_diproses'] = DataPelanggar::whereNotIn('status_id', [1,8,5,9,10])->get();

        $currentMonth = Carbon::now()->translatedFormat('m');
        $lastMonth = Carbon::now()->subMonth()->translatedFormat('m');

        $countKasusLastMonth = DataPelanggar::whereMonth('created_at', $lastMonth)->count();
        $countKasusCurrentMonth = DataPelanggar::whereMonth('created_at', $currentMonth)->count();
        $data['all_growth'] = $countKasusLastMonth != 0 ? ($countKasusCurrentMonth - $countKasusLastMonth) / $countKasusLastMonth*100 : 100;

        return view('pages.data_pelanggaran.index', $data);
    }

    public function inputKasus()
    {
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();
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

        // dd($id_kode_etik);

        $data = [
            'agama' => $agama,
            'jenis_identitas' => $jenis_identitas,
            'jenis_kelamin' => $jenis_kelamin,
            'pangkat' => $pangkat,
            'wujud_perbuatan' => $wujud_perbuatan,
            'disiplin' => $disiplin,
            'id_disiplin' => $id_disiplin,
            'kode_etik' => $kode_etik,
            'id_kode_etik' => $id_kode_etik,
            'polda' => $polda
        ];

        return view('pages.data_pelanggaran.input_kasus.input',$data);
    }

    public function storeKasus(Request $request){
        $no_pengaduan = "123456"; //generate otomatis
        $currentYear = Carbon::now()->translatedFormat('Y');
        $totalData = DB::table('data_pelanggars')->select('*')->whereYear('created_at', $currentYear)->count();
        if($totalData == 0){
            $number = '0001';
        } else if (strlen($totalData) < 4){
            $number = sprintf("%04d", (int)$totalData+1);
        } else {
            $number = $totalData;
        }

        $transNumber = "$currentYear$number";

        $DP = DataPelanggar::create([
            // Pelapor
            'no_nota_dinas' => $request->no_nota_dinas,
            'no_pengaduan' => $transNumber,
            'perihal_nota_dinas' => $request->perihal_nota_dinas,
            'wujud_perbuatan' => $request->wujud_perbuatan,
            'tanggal_nota_dinas' => Carbon::create($request->tanggal_nota_dinas)->format('Y-m-d'),
            'pelapor' => $request->pelapor,
            'umur' => $request->umur,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
            'agama' => $request->agama,
            'alamat' => $request->alamat,
            'no_identitas' => $request->no_identitas,
            'no_telp' => $request->no_telp,
            'jenis_identitas' => $request->jenis_identitas,
            //Terlapor
            'terlapor' => $request->terlapor,
            'nrp' => $request->nrp,
            'jabatan' => $request->jabatan,
            'kesatuan' => $request->kesatuan,
            'wilayah_hukum' => $request->wilayah_hukum,
            'kewarganegaraan' => 'WNI',
            'tempat_kejadian' => $request->tempat_kejadian,
            'tanggal_kejadian' => Carbon::create($request->tanggal_kejadian)->format('Y-m-d'),
            'kronologi' => $request->kronologis,
            'pangkat' => $request->pangkat,
            'nama_korban' => $request->nama_korban,
            'status_id' => 1
        ]);
        return redirect()->route('kasus.detail',['id'=>$DP->id]);
    }

    public function data(Request $request)
    {
        $query = DataPelanggar::with('status')->with('pangkatName')->latest('created_at')->get();

        return Datatables::of($query)
            ->editColumn('no_nota_dinas', function($query) {
                // return $query->no_nota_dinas;
                return '<a href="/data-kasus/detail/'.$query->id.'">'.$query->no_nota_dinas.'</a>';
            })
            ->editColumn('pangkatName.name', function($query){
                $pangkat = $query->pangkatName != null ? $query->pangkatName->name : ' - ';
                return '<span>'.$pangkat.'</span>';
            })
            ->rawColumns(['no_nota_dinas', 'pangkatName.name'])
            ->make(true);
    }

    public function detail($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process
        ];

        // if ($kasus->status_id == 3)
        // {

        // }

        return view('pages.data_pelanggaran.detail', $data);
    }

    public function updateData(Request $request)
    {
        if ($request->status == 'update_data')
            return $this->updateDataPelanggar($request);

        $status = $this->cek_requirement($request->kasus_id, $request->process_id);
        if ($status['status'] == false && (isset($request->next) && $request->next != 'restorative_justice')){
            return response()->json([
                'status' => [
                    'code' => 400,
                    'msg' => "Harap cetak semua dokumen terlebih dahulu : <br><br>".$status['data']
                ]
            ], 400);
        } else {
            if ($request->status == '2'){
                    try {
                        $data = DataPelanggar::find($request->kasus_id);
                        $data->status_id = 3;
                        $data->save();

                        return response()->json([
                            'status' => [
                                'code' => 200,
                                'msg' => 'OK'
                            ]
                        ], 200);
                    } catch (\Throwable $th) {
                        return response()->json([
                            'status' => [
                                'code' => 500,
                                'msg' => 'Terjadi masalah saat merubah status'
                            ], 'detail' => $th
                        ], 500);
                    }

                // }
            } else if ($request->status == 3) {
                try {
                    $sprin = SprinHistory::where('data_pelanggar_id', $request->kasus_id)->where('type', 'lidik')->select('is_draft')->first();
                    if($sprin->is_draft){
                        throw new Exception('Nomor SPRIN Lidik masih draft, Harap update terlebih dahulu', 400);
                    }

                    $undanganKlarifikasi = UndanganKlarifikasiHistories::where('data_pelanggar_id', $request->kasus_id)->select('is_draft')->first();
                    if($undanganKlarifikasi->is_draft){
                        throw new Exception('Nomor Undangan Klarifikasi masih draft, Harap update terlebih dahulu', 400);
                    }

                    $data = DataPelanggar::find($request->kasus_id);
                    $data->status_id = 4;
                    $data->save();

                    return response()->json([
                        'status' => [
                            'code' => 200,
                            'msg' => 'OK'
                        ]
                    ], 200);
                } catch (Exception $th) {
                    return response()->json([
                        'status' => [
                            'code' => $th->getCode() != '' ? $th->getCode() :500,
                            'msg' => $th->getMessage() != '' ? $th->getMessage() : 'Err',
                        ],
                        'detail' => $th,
                        'message' => $th->getMessage() != '' ? $th->getMessage() : 'Terjadi Kesalahan Saat Hapus Data, Harap Coba lagi!'
                    ], 500);
                }
            } else if ($request->status == 4){
                if($request->next == 'limpah_modal'){
                    $this->validate($request,[
                        'polda_id' => 'required'
                    ], [
                        'polda_id' => 'Harap pilih Polda yang akan dituju'
                    ]);
                    DB::beginTransaction();
                    try {
                        $data = DataPelanggar::find($request->kasus_id);
                        $data->status_id = 5;
                        $data->save();

                        $documentLimpah = (new GenerateDocument)->limpah_polda($request);

                        DB::commit();
                        return response()->json(['file' => $documentLimpah]);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return response()->json([
                            'status' => [
                                'code' => 500,
                                'msg' => 'Terjadi masalah saat merubah status'
                            ], 'detail' => $th
                        ], 500);
                    }
                } else if ($request->next == 'restorative_justice') {
                    DB::beginTransaction();
                    try {
                        $data = DataPelanggar::find($request->kasus_id);
                        $data->status_id = 10;
                        $data->save();

                        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $request->kasus_id)->first();
                        $gelarPerkara->hasil_gelar = Process::where('id', 10)->first()->name;
                        $gelarPerkara->save();

                        $sp2hp = (new GenerateDocument)->sp2hp($request->kasus_id,$request->process_id,12);
                        DB::commit();
                        return response()->json(['file' => $sp2hp]);
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        return response()->json([
                            'status' => [
                                'code' => 500,
                                'msg' => 'Terjadi masalah saat merubah status'
                            ], 'detail' => $th
                        ], 500);
                    }
                } else {
                    try {
                        $data = DataPelanggar::find($request->kasus_id);
                        $data->status_id = 6;
                        $data->save();

                        return response()->json([
                            'status' => [
                                'code' => 200,
                                'msg' => 'OK'
                            ]
                        ], 200);
                    } catch (\Throwable $th) {
                        return response()->json([
                            'status' => [
                                'code' => 500,
                                'msg' => 'Terjadi masalah saat merubah status'
                            ], 'detail' => $th
                        ], 500);
                    }
                }
            } else if ($request->status == 6) {
                try {
                    $data = DataPelanggar::find($request->kasus_id);
                    $data->status_id = 7;
                    $data->save();

                    return response()->json([
                        'status' => [
                            'code' => 200,
                            'msg' => 'OK'
                        ]
                    ], 200);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => [
                            'code' => 500,
                            'msg' => 'Terjadi masalah saat merubah status'
                        ], 'detail' => $th
                    ], 500);
                }
            } else if ($request->status == 7) {
                try {
                    $data = DataPelanggar::find($request->kasus_id);
                    $data->status_id = 8;
                    $data->save();

                    return response()->json([
                        'status' => [
                            'code' => 200,
                            'msg' => 'OK'
                        ]
                    ], 200);
                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => [
                            'code' => 500,
                            'msg' => 'Terjadi masalah saat merubah status'
                        ], 'detail' => $th
                    ], 500);
                }
            }
        }
    }

    public function updateDataPelanggar(Request $request){
        try {
            $data_pelanggar = DataPelanggar::where('id', $request->kasus_id)->first();
            $data_pelanggar->update([
                'no_nota_dinas' => $request->no_nota_dinas,
                // 'no_pengaduan' => $no_pengaduan,
                'perihal_nota_dinas' => $request->perihal_nota_dinas,
                'wujud_perbuatan' => $request->wujud_perbuatan,
                'tanggal_nota_dinas' => Carbon::create($request->tanggal_nota_dinas)->format('Y-m-d'),
                'pelapor' => $request->pelapor,
                'umur' => $request->umur,
                'jenis_kelamin' => $request->jenis_kelamin,
                'pekerjaan' => $request->pekerjaan,
                'agama' => $request->agama,
                'alamat' => $request->alamat,
                'no_identitas' => $request->no_identitas,
                'jenis_identitas' => $request->jenis_identitas,
                'no_telp' => $request->no_telp,
                'terlapor' => $request->terlapor,
                'nrp' => $request->nrp,
                'jabatan' => $request->jabatan,
                'kesatuan' => $request->kesatuan,
                'wilayah_hukum' => $request->wilayah_hukum,
                'tempat_kejadian' => $request->tempat_kejadian,
                'tanggal_kejadian' => Carbon::create($request->tanggal_kejadian)->format('Y-m-d'),
                'kronologi' => $request->kronologis,
                'pangkat' => $request->pangkat,
                'nama_korban' => $request->nama_korban,
            ]);

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'OK'
                ]
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Terjadi masalah saat merubah status'
                ], 'detail' => $th
            ], 500);
        }
    }

    public function getDataPenyidik($kasus_id){
        $data = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->get();
        return response()->json($data);
    }

    public function getDataPenyidikRiksa($kasus_id){
        $data = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->get();
        return response()->json($data);
    }

    private function cek_requirement($kasus_id, $process_id){
        $documentgenerated = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->select(['data_pelanggar_id', 'process_id', 'sub_process_id'])->distinct();
        $subProcess = SubProcess::where('process_id', (int)$process_id);

        if (count($documentgenerated->get()) == $subProcess->count()){
            return ['status' => true, 'data' => null];
        } else {
            $arrSubProcessId = [];
            foreach ($documentgenerated->get() as $val) {
                array_push($arrSubProcessId, $val->sub_process_id);
            }

            $documentNotGenerated = '';
            foreach ($subProcess->whereNotIn('id',$arrSubProcessId)->get() as $docVal) {
                $documentNotGenerated .= "- $docVal->name <br>";
            };
            return ['status' => false, 'data' => $documentNotGenerated];
        }
    }

    public function insertLimpahPaminal(Request $request)
    {
        $key = 'uKnv0kWIResqXDc8sV3TBgQwhh1gsU5DxEEAGXpeNukdy8wbN1';
        $headerKey = base64_decode($request->header('api_key'));
        if($key == $headerKey){
            DB::beginTransaction();
            try {
                $wilayah_hukum = $request->wilayah_hukum != null ? Polda::where('name', 'like', '%'.$request->wilayah_hukum.'%')->first() : null;
                $wilayah_hukum = $wilayah_hukum != null ? $wilayah_hukum->id : null;

                $currentYear = Carbon::now()->translatedFormat('Y');
                $totalData = DB::table('data_pelanggars')->select('*')->whereYear('created_at', $currentYear)->count();
                if($totalData == 0){
                    $number = '0001';
                } else if (strlen($totalData) < 4){
                    $number = sprintf("%04d", (int)$totalData+1);
                } else {
                    $number = $totalData;
                }

                $transNumber = "$currentYear$number";

                $body = [
                    "no_nota_dinas" => $request->no_nota_dinas, //string
                    "no_pengaduan" => $transNumber,
                    "perihal_nota_dinas" => $request->perihal_nota_dinas, //string
                    "wujud_perbuatan" => $request->wujud_perbuatan, //id
                    "tanggal_nota_dinas" => $request->tanggal_nota_dinas, //string
                    "pelapor" => $request->pelapor, //string
                    "jenis_kelamin" => $request->jenis_kelamin, //id
                    "no_telp" => $request->no_telp, //string
                    "alamat" => $request->alamat, //string
                    "no_identitas" => $request->no_identitas, //string
                    "jenis_identitas" => $request->jenis_identitas, //id
                    "terlapor" => $request->terlapor, //string
                    "agama" => $request->agama, //id
                    "umur" => $request->umur, //string
                    "pekerjaan" => $request->pekerjaan, //string
                    "kesatuan" => $request->kesatuan, //id
                    "nrp" => $request->nrp, //string
                    "tempat_kejadian" => $request->tempat_kejadian, //string
                    "tanggal_kejadian" => $request->tanggal_kejadian, //string
                    "pangkat" => $request->pangkat, //id
                    "jabatan" => $request->jabatan, //string
                    "wilayah_hukum" => $wilayah_hukum,
                    "nama_korban" => $request->nama_korban, //string
                    'data_from' => 'paminal',
                    'kategori_yanduan_id' => null,
                    'status_id' => 1
                ];

                $data = [];
                foreach ($body as $key => $value) {
                    if($value == '' || $value == 'null'){
                        $data[$key] = null;
                    } else {
                        $data[$key] = $value;
                    }
                }

                $pelanggar = DataPelanggar::create($data);

                $pelaporIdentity = [
                    "data_pelanggar_id" => $pelanggar->id,
                    "id_card" => $request->link_ktp, //string
                    "selfie" => $request->selfie //string
                ];

                $dataPelapor = [];
                foreach ($pelaporIdentity as $key => $value) {
                    if($value == '' || $value == 'null'){
                        $dataPelapor[$key] = null;
                    } else {
                        $dataPelapor[$key] = $value;
                    }
                }

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Limpah berhasil'
                ], 200);
            } catch (Exception $th) {
                DB::rollBack();
                return response()->json([
                    'status' =>  $th->getCode() != '' ? $th->getCode() : 500,
                    'message' => $th->getMessage() != '' ? $th->getMessage() : 'Terjadi Kesalahan Saat Input Data, Harap Coba lagi!',
                    'data' => null,
                    'err_detail' => $th,
                ], $th->getCode() != '' ? $th->getCode() : 500);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Failed to authenticate, no api-key header provided'
            ], 401);
        }
    }
}
