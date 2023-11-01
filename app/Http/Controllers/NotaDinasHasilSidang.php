<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotaDinasHasilSidang extends Controller
{
    public function index(){
        return view('pages.nota_dinas_hasil_sidang.index');
    }

    public function data(Request $request)
    {
        $query = DataPelanggar::where('print_nd', 0)->where('status_id', 8)->orderBy('id', 'desc')->with('status')->whereHas('sidangDisiplin', function($sidang){
            $sidang->where('hasil_sidang', 'Terbukti');
        })->get();

        return DataTables::of($query)
            ->editColumn('no_nota_dinas', function($query) {
                // return $query->no_nota_dinas;
                return '<a href="/data-kasus/detail/'.$query->id.'">'.$query->no_nota_dinas.'</a>';
            })
            ->rawColumns(['no_nota_dinas'])
            ->make(true);
    }

    public function print(Request $request)
    {
        $this->validate($request, [
            'month_start' => 'required',
            'month_end' => 'required|after_or_equal:month_start'
        ],[
            'month_start' => 'Form bulan mulai periode sidang wajib diisi',
            'month_end.required' => 'Form bulan akhir periode sidang wajib diisi',
            'month_end.after' => 'Form bulan akhir periode sidang harus lebih besar dari bulan mulai periode',
        ]);

        try {
            $yearStart = explode('-', $request->month_start)[0];
            $monthStart = explode('-', $request->month_start)[1];
            $yearEnd = explode('-', $request->month_end)[0];
            $monthEnd = explode('-', $request->month_end)[1];

            $data = DataPelanggar::where('status_id', 8)->where('print_nd', 0)->whereHas('sidangDisiplin',function($sidang) use ($yearStart, $yearEnd, $monthStart, $monthEnd){
                $sidang->where('hasil_sidang', 'Terbukti')
                        ->where(function($year) use ($yearStart, $yearEnd){
                            $year->whereYear('tgl_sidang', '>=', $yearStart)
                                ->WhereYear('tgl_sidang', '<=', $yearEnd);
                        })
                        ->where(function($month) use ($monthStart, $monthEnd){
                            $month->whereMonth('tgl_sidang', '>=', $monthStart)
                                ->WhereMonth('tgl_sidang', '<=', $monthEnd);
                        });
                        ;
            })->with('pangkatName')->with('sidangDisiplin')->get();

            if(count($data) > 0){
                $generateDocument = (new GenerateDocument)->nota_hasil_putusan($data, $request);

                foreach ($data as $val) {
                    $val->print_nd = 1;
                    $val->save();
                }
            } else {
                throw new Exception('Tidak ada data yang bisa ditampilkan', 422);
            }

            return response()->json([
                'status' => [
                    'code' => 200,
                    'msg' => 'Success Processing Data',
                ],
                'document_data' => $generateDocument,
            ], 200);
        } catch (\Throwable $th) {
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
}
