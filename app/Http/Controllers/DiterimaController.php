<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\Disposisi;
use App\Models\DokumenPelanggar;
use App\Models\MasterPenyidik;
use App\Models\Penyidik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

class DiterimaController extends Controller
{
    public function DisposisiKaro(Request $request){
        try {
            $disposisi = Disposisi::where('data_pelanggar_id', $request->kasus_id)->where('type', 'Karo')->first();
            $kasus = DataPelanggar::find($request->kasus_id);
            $data = [
                'tgl_diterima' => Carbon::parse($request->tanggal)->translatedFormat('d F Y'),
                'jam' => $request->jam,
                'created_at' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
                'no_nota_dinas' => $kasus->no_nota_dinas,
                'no_agenda' => $request->nomor_agenda,
                'perihal_nota_dinas' => $kasus->perihal_nota_dinas,
                'klasifikasi' => strtoupper($request->klasifikasi),
                'derajat' => strtoupper($request->derajat),
            ];

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->status_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'process_id' => 2,
                    'sub_process_id' => 2,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            if($kasus->status_id < 2){
                $kasus->status_id = 2;
                $kasus->save();
            }

            if($disposisi == null){
                Disposisi::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'no_agenda' => $request->nomor_agenda,
                    'klasifikasi' => $request->klasifikasi,
                    'derajat' => $request->derajat,
                    'type' => 'Karo'
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
                'jam' => $request->jam,
                'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
                'no_surat' => $request->nomor_surat,
                'no_agenda' => $request->nomor_agenda,
                'perihal' => $kasus->perihal_nota_dinas,
                'klasifikasi' => strtoupper($request->klasifikasi),
                'derajat' => strtoupper($request->derajat),
                'tgl_diterima' => Carbon::parse($request->tanggal)->translatedFormat('d F Y'),
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

            $disposisi = Disposisi::where('data_pelanggar_id', $request->kasus_id)->where('type', 'Sesro')->first();
            if($disposisi == null){
                Disposisi::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'no_agenda' => $request->nomor_agenda,
                    'klasifikasi' => $request->klasifikasi,
                    'derajat' => $request->derajat,
                    'type' => 'Sesro'
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

    public function DisposisiKabag(Request $request){
        try {
            $kasus = DataPelanggar::find($request->kasus_id);
            $data = [
                'jam' => $request->jam,
                'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
                'no_surat' => $request->nomor_surat,
                'no_agenda' => $request->nomor_agenda,
                'perihal' => $kasus->perihal_nota_dinas,
                'klasifikasi' => strtoupper($request->klasifikasi),
                'derajat' => strtoupper($request->derajat),
                'tgl_diterima' => Carbon::parse($request->tanggal)->translatedFormat('d F Y'),
                // 'tgl_diterima' => $request->tanggal,
                // 'no_agenda' => $request->nomor_agenda,
                // 'klasifikasi' => strtoupper($request->klasifikasi),
                // 'derajat' => strtoupper($request->derajat),
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

            $disposisi = Disposisi::where('data_pelanggar_id', $request->kasus_id)->where('type', 'Kabag')->first();
            if($disposisi != null){
                Disposisi::where('data_pelanggar_id', $request->kasus_id)->where('type', 'Kabag')->delete();
            }
            Disposisi::create([
                'data_pelanggar_id' => $request->kasus_id,
                'no_agenda' => $request->nomor_agenda,
                'klasifikasi' => $request->klasifikasi,
                'derajat' => $request->derajat,
                'type' => 'Kabag'
            ]);

            $masterPenyelidik = MasterPenyidik::where('unit', $request->unit_pemeriksa)->with('pangkats')->get();
            foreach ($masterPenyelidik as $value) {
                Penyidik::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'name' => strtoupper($value->name),
                    'nrp' => $value->nrp,
                    'pangkat' => strtoupper($value->pangkats->name),
                    'jabatan' => strtoupper($value->jabatan),
                    'kesatuan' => strtoupper($value->kesatuan),
                    'type' => 'lidik',
                    'unit_pemeriksa' => $request->unit_pemeriksa
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
}
