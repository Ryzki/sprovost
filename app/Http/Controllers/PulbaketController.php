<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\GelarPerkara;
use App\Models\MasterPenyidik;
use App\Models\Penyidik;
use App\Models\SprinHistory;
use App\Models\UndanganKlarifikasiHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PulbaketController extends Controller
{
    public function SuratPerintah(Request $request, $kasus_id){
        try {
            $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
            $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->get();

            if ($sprinHistory == null){
                $sprinHistory = SprinHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_sprin' => $request->no_sprin,
                    'created_by' => Auth::user()->id,
                    'type' => 'lidik',
                    'unit_pemeriksa' => $request->unit_pemeriksa_new == null ? $request->unit_pemeriksa : $request->unit_pemeriksa_new
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

            if ($request->unit_pemeriksa_new != null){
                Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->delete();

                $masterPenyelidik = MasterPenyidik::where('unit', $request->unit_pemeriksa_new)->with('pangkats')->get();
                foreach ($masterPenyelidik as $value) {
                    Penyidik::create([
                        'data_pelanggar_id' => $kasus_id,
                        'name' => strtoupper($value->name),
                        'nrp' => $value->nrp,
                        'pangkat' => strtoupper($value->pangkats->name),
                        'jabatan' => strtoupper($value->jabatan),
                        'kesatuan' => strtoupper($value->kesatuan),
                        'type' => 'lidik',
                        'unit_pemeriksa' => $request->unit_pemeriksa_new
                    ]);
                }

                $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->get();
            }

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'penyelidik' => $penyelidik,
                'sprinHistory' => $sprinHistory
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

    public function laporanHasilPenyelidikan(Request $request, $kasus_id){
        $this->validate($request, [
            'hasil_gp' => 'required',
            'landasan_hukum' => 'required',
        ],[
            'hasil_gp' => 'Hasil Penyelidikan wajib diisi',
            'landasan_hukum' => 'Pasal yang dilanggar wajib diisi'
        ]);

        DB::beginTransaction();
        try {
            $hasil_gp = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();
            if($hasil_gp == null){
                $hasil_gp = GelarPerkara::create([
                    'data_pelanggar_id' => $kasus_id,
                    'hasil_gelar' => $request->hasil_gp,
                    'landasan_hukum' => $request->landasan_hukum,
                    'saran_penyidik' => $request->tindak_lanjut,
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'data' => $hasil_gp
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

    public function dataPenyelidik(Request $request){
        $query = MasterPenyidik::Where('unit', $request->unit)->orderBy('id', 'desc')->with('pangkats')->get();

        return DataTables::of($query)->make(true);
    }

    public function updateNoSprin(Request $request, $kasus_id)
    {
        DB::beginTransaction();
        try {
            SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', $request->type)->update([
                'no_sprin' => $request->no_sprin,
                'is_draft' => 0
            ]);

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
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

    public function updateNoUndangan(Request $request, $kasus_id)
    {
        DB::beginTransaction();
        try {
            UndanganKlarifikasiHistories::where('data_pelanggar_id', $kasus_id)->update([
                'no_undangan' => $request->no_undangan,
                'is_draft' => 0
            ]);

            DB::commit();
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
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
