<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

class DiterimaController extends Controller
{
    public function LembarDisposisi(Request $request)
    {
        try {
            $kasus = DataPelanggar::find($request->kasus_id);
            $document_data = [
                'tanggal' => $request->tanggal,
                'surat_dati' => $request->surat_dari,
                'nomor_surat' => $request->nomor_surat,
                'perihal' => $kasus->perihal_nota_dinas,
                'nomor_agenda' => $request->nomor_agenda
            ];

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', 2)->where('sub_process_id', 2)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'process_id' => 2,
                    'sub_process_id' => 2,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            $data = DataPelanggar::find($request->kasus_id);
            if($data->status_id < 2){
                $data->status_id = 2;
                $data->save();
            }

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'document_data' => $document_data,
                'kasus' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Error'
                ],
                'detail' => $th,
                'document_data' => null,
                'kasus' => null,
            ], 500);
        }
    }

    public function DisposisiKaro(Request $request){
        try {
            $kasus = DataPelanggar::find($request->kasus_id);
            $data = [
                'tanggal' => $request->tanggal,
                'no_surat' => $request->nomor_surat,
                'no_agenda' => $request->nomor_agenda,
                'perihal' => $kasus->perihal_nota_dinas,
                'klasifikasi' => strtoupper($request->klasifikasi),
                'derajat' => strtoupper($request->derajat),
            ];

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->status_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'process_id' => $request->status_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'document_data' => $data,
                'kasus' => $kasus,
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

    public function DisposisiSesro(Request $request){
        try {
            $kasus = DataPelanggar::find($request->kasus_id);
            $data = [
                'tanggal' => $request->tanggal,
                'no_surat' => $request->nomor_surat,
                'no_agenda' => $request->nomor_agenda,
                'perihal' => $kasus->perihal_nota_dinas,
                'klasifikasi' => strtoupper($request->klasifikasi),
                'derajat' => strtoupper($request->derajat),
            ];

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->status_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'process_id' => $request->status_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'document_data' => $data,
                'kasus' => $kasus,
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

    public function DisposisiKabag($kasus_id, $process_id, $subprocess){
        try {
            $kasus = DataPelanggar::find($kasus_id);
            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $process_id,
                    'sub_process_id' => $subprocess,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }
            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'document_data' => null,
                'kasus' => $kasus,
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
}
