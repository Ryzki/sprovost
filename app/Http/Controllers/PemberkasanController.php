<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\DP3D;
use App\Models\LPA;
use App\Models\MasterPenyidik;
use App\Models\Penyidik;
use App\Models\SprinHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PemberkasanController extends Controller
{
    public function updateLPA(Request $request, $kasus_id)
    {
        DB::beginTransaction();
        try {
            $lpa = LPA::where('data_pelanggar_id', $kasus_id);
            $lpa->update([
                'no_lpa' => $request->no_lpa,
                'is_draft' => 0
            ]);

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error'
                ],
                'detail' => $th,
            ], 500);
        }
    }

    public function generateSPRINRiksa(Request $request, $kasus_id)
    {
        try {
            $kasus = DataPelanggar::find($kasus_id);
            $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();
            $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->get();
            $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();

            if ($sprinHistory == null){
                $sprinHistory = SprinHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_sprin' => $request->no_sprin,
                    'created_by' => Auth::user()->id,
                    'type' => 'riksa',
                    'unit_pemeriksa' => $request->unit_pemeriksa
                ]);

                $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
                if($dokumen == null){
                    DokumenPelanggar::create([
                        'data_pelanggar_id' => $kasus_id,
                        'process_id' => $request->process_id,
                        'sub_process_id' => $request->sub_process,
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }
            }

            if (count($penyelidik) == 0){
                $masterPenyelidik = MasterPenyidik::where('unit', $request->unit_pemeriksa)->with('pangkats')->get();

                foreach ($masterPenyelidik as $value) {
                    Penyidik::create([
                        'data_pelanggar_id' => $kasus_id,
                        'name' => strtoupper($value->name),
                        'nrp' => $value->nrp,
                        'pangkat' => strtoupper($value->pangkats->name),
                        'jabatan' => strtoupper($value->jabatan),
                        'kesatuan' => strtoupper($value->kesatuan),
                        'type' => 'riksa',
                        'unit_pemeriksa' => $request->unit_pemeriksa
                    ]);
                }

                $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->get();
            }

            $documentData = [
                'no_lpa' => $lpa->no_lpa,
                'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
                'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                'terlapor' => $kasus->terlapor,
                'pangkat' => $kasus->pangkatName->name,
                'jabatan' => $kasus->jabatan,
                'kesatuan' => $kasus->kesatuan,
                'no_sprin' => $request->no_sprin != '' ? $request->no_sprin : $sprinHistory->no_sprin,
                'tanggal_ttd' => Carbon::parse($sprinHistory->created_at)->translatedFormat('F Y')
            ];

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'document_data' => $documentData,
                'kasus' => $kasus,
                'penyidik' => $penyelidik,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function updateSprinRiksa(Request $request, $kasus_id)
    {
        DB::beginTransaction();
        try {
            $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa');
            $sprinHistory->update([
                'no_sprin' => $request->no_sprin,
                'is_draft' => 0
            ]);

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error'
                ],
                'detail' => $th,
            ], 500);
        }
    }

    public function updateDP3D(Request $request, $kasus_id)
    {
        DB::beginTransaction();
        try {
            $lpa = DP3D::where('data_pelanggar_id', $kasus_id);
            $lpa->update([
                'no_dp3d' => $request->no_dp3d,
                'is_draft' => 0
            ]);

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ]
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error'
                ],
                'detail' => $th,
            ], 500);
        }
    }
}
