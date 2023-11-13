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
use App\Models\UndanganKlarifikasiHistory;
use App\Models\Witness;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
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
                    $data = DataPelanggar::find($request->kasus_id);
                    $data->status_id = 4;
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
            $no_pengaduan = "123456"; //generate otomatis
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
        $documentgenerated = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id);
        $subProcess = SubProcess::where('process_id', (int)$process_id);

        if ($documentgenerated->count() == $subProcess->count()){
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
}
