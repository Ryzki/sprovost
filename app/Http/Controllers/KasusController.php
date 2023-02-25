<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\LimpahPolda;
use App\Models\Penyidik;
use App\Models\Process;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use App\Models\SubProcess;
use App\Models\UndanganKlarifikasiHistory;
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
        if ($request->status == '2'){
            // $status = $this->cek_requirement($request->kasus_id, $request->process_id);
            // if ($status == true){
            //     return response()->json([
            //         'status' => [
            //             'code' => 400,
            //             'msg' => 'Harap cetak semua dokumen terlebi dahulu'
            //         ]
            //     ], 400);
            // } else {
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

    public function updateStatus(Request $request)
    {
        $kasus_id = $request->kasus_id;
        $documentgenerated = $this->cek_requirement($kasus_id, $request->process_id);
        return $documentgenerated;
    }

    public function viewProcess($kasus_id,$status_id)
    {
        switch ($status_id) {
            case 1:
                return $this->viewDiterima($kasus_id);
                break;
            case 2:
                return $this->viewDiterima($kasus_id);
                break;
            case 3:
                return $this->viewPulbaket($kasus_id);
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
                return $this->viewDiterima($kasus_id);
                break;
            default:
                return 404;
                break;
        }
    }

    private function viewDiterima($id)
    {
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $process = Process::where('sort', '<=', $status->id)->get();
        $sub_process = SubProcess::where('process_id', 2)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'process' =>  $process,
            'sub_process' => $sub_process
        ];

        return view('pages.data_pelanggaran.proses.diterima', $data);
    }

    private function viewPulbaket($id){
        $kasus = DataPelanggar::find($id);

        if ($kasus->status_id > 3){
            $kasus->status_now = $kasus->status_id;
            $kasus->status_id = 3;
        }

        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();
        // $sub_process = SubProcess::where('process_id', 3)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $id)->with('user')->first();
        $sp2hp2 = Sp2hp2History::where('data_pelanggar_id', $id)->with('user')->first();
        $agama = Agama::get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
            'sprin' => $sprin,
            'sp2hp2' => $sp2hp2,
            'agamas' => $agama
        ];

        return view('pages.data_pelanggaran.proses.pulbaket', $data);
    }

    private function gelarLidik($id){
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
        ];

        return view('pages.data_pelanggaran.proses.gelarlidik', $data);
    }

    private function sidik($id){
        $kasus = DataPelanggar::find($id);
        $status = Process::find($kasus->status_id);
        $sub_process = SubProcess::where('process_id', $kasus->status_id)->get();

        $data = [
            'kasus' => $kasus,
            'status' => $status,
            'sub_process' => $sub_process,
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

    public function getDataPenyidik($kasus_id){
        $data = Penyidik::where('data_pelanggar_id', $kasus_id)->get();
        return response()->json($data);
    }

    private function cek_requirement($kasus_id, $process_id){
        $cek = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->get();
        $subProcess = SubProcess::where('process_id', (int)$process_id + 1)->get();
        if (count($cek) == count($subProcess) + 1){
            return true;
        } else {
            return false;
        }
    }
}
