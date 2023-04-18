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
use Illuminate\Support\Facades\Redirect;

class KasusController extends Controller
{
    public function index()
    {
        $data['kasuss'] = DataPelanggar::all();

        return view('pages.data_pelanggaran.index', $data);
    }

    public function inputKasus()
    {
        $agama = Agama::get();
        $jenis_identitas = JenisIdentitas::get();
        $jenis_kelamin = JenisKelamin::get();
        $pangkat = Pangkat::get();
        $wujud_perbuatan = WujudPerbuatan::get();

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
        ];

        return view('pages.data_pelanggaran.input_kasus.input',$data);
    }

    public function storeKasus(Request $request){
        $no_pengaduan = "123456"; //generate otomatis
        $DP = DataPelanggar::create([
            // Pelapor
            'no_nota_dinas' => $request->no_nota_dinas,
            'no_pengaduan' => $no_pengaduan,
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
        $query = DataPelanggar::orderBy('id', 'desc')->with('status');

        return Datatables::of($query)
            ->editColumn('no_nota_dinas', function($query) {
                // return $query->no_nota_dinas;
                return '<a href="/data-kasus/detail/'.$query->id.'">'.$query->no_nota_dinas.'</a>';
            })
            ->rawColumns(['no_nota_dinas'])
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
        if ($status == false){
            return response()->json([
                'status' => [
                    'code' => 400,
                    'msg' => 'Harap cetak semua dokumen terlebih dahulu'
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
                if($request->next == 'limpah'){
                    try {
                        $data = DataPelanggar::find($request->kasus_id);
                        $data->status_id = 5;
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
                'no_pengaduan' => $no_pengaduan,
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
        $documentgenerated = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->count();
        $subProcess = SubProcess::where('process_id', (int)$process_id)->count();
        if ($documentgenerated == $subProcess){
            return true;
        } else {
            return false;
        }
    }
}
