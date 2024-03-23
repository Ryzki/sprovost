<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\LimpahPolda;
use App\Models\MasterPenyidik;
use App\Models\Pangkat;
use App\Models\Polda;
use App\Models\Process;
use App\Models\SprinHistory;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data['polda'] = Polda::get();
        $data['pelanggar'] = DataPelanggar::get();
        $data['pengaduan_diproses'] = $data['pelanggar']->where('status_id','>',1)->where('status_id', '<', 8);

        // foreach ($data['pelanggar'] as $val_plg) {
        //     $pangkat = Pangkat::where('id', $val_plg->pangkat)->first();
        //     $data['kasus_by_pangkat'][$pangkat->name] = DataPelanggar::where('pangkat', $val_plg->pangkat)->count();
        // }

        $data['list_status'] = Process::get();
        $data['list_polda'] = Polda::get();
        $data['list_unit'] = DB::table('master_penyidiks')->select('unit')->groupBy('unit')->get();

        return view('pages.dashboard.index',$data);
    }

    public function DataByStatus($status_id = ''){
        $data['dumas_by_status'] = DataPelanggar::where('status_id', 1)->count();
        if($status_id != ''){
            $data['dumas_by_status'] = DataPelanggar::where('status_id', $status_id)->count();
        }

        return response()->json($data['dumas_by_status'])->header('Content-Type','application/json; charset=utf-8');
    }

    public function DataByLimpah($limpah_id = ''){
        $data = DataPelanggar::whereIn('id', LimpahPolda::where('polda_id', 0)->select('data_pelanggar_id')->pluck('data_pelanggar_id'))->count();
        if($limpah_id != ''){
            $data = DataPelanggar::whereIn('id', LimpahPolda::where('polda_id', $limpah_id)->select('data_pelanggar_id')->pluck('data_pelanggar_id'))->count();
        }

        return response()->json($data)->header('Content-Type','application/json; charset=utf-8');
    }

    public function DataByUnit($unit = ''){
        $data = DataPelanggar::whereIn('id', SprinHistory::where('unit_pemeriksa', 'BAGGAKKUM')->select('data_pelanggar_id')->groupBy('data_pelanggar_id')->pluck('data_pelanggar_id'))->count();
        if($unit != ''){
            $data = DataPelanggar::whereIn('id', SprinHistory::where('unit_pemeriksa', $unit)->select('data_pelanggar_id')->groupBy('data_pelanggar_id')->pluck('data_pelanggar_id'))->count();
        }

        return response()->json($data)->header('Content-Type','application/json; charset=utf-8');
    }

    public function ChartData($tipe = '', Request $request){
        if($tipe == 'rekap_tahunan'){
            $currentYear = Carbon::now()->translatedFormat('Y');
            foreach (range(1,12) as $month) {
                $monthStr = date('M', mktime(0, 0, 0, $month, 10));
                $data['kasus_by_month'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)->whereYear('created_at', $currentYear)->count();
            }
        } else if (str_contains($tipe, 'triwulan')){
            $data['dumas_triwulan']['T1 : Januari - Maret'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 1)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 3)->lastOfQuarter()])->count();
            $data['dumas_triwulan']['T2 : April - Juni'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 4)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 6)->lastOfQuarter()])->count();
            $data['dumas_triwulan']['T3 : Juli - September'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 7)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 9)->lastOfQuarter()])->count();
            $data['dumas_triwulan']['T4 : Oktober - Desember'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 10)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 12)->lastOfQuarter()])->count();
        } else if (str_contains($tipe, 'semester')){
            $data['dumas_semester']['S1 : Januari - Juni'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 1)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 6)->lastOfQuarter()])->count();
            $data['dumas_semester']['S2 : Juli - Desember'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 7)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 12)->lastOfQuarter()])->count();

        } else if($tipe == 'persentase_by_unit'){
            $currentYear = Carbon::now()->translatedFormat('Y');
            foreach (range(1,12) as $month) {
                $monthStr = date('M', mktime(0, 0, 0, $month, 10));
                $data['Diproses'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->whereIn('id',
                        SprinHistory::where('unit_pemeriksa', 'BAGGAKKUM')
                                    ->select('data_pelanggar_id')
                                    ->groupBy('data_pelanggar_id')
                                    ->pluck('data_pelanggar_id')
                    )
                    ->whereBetween('status_id', [2,7])
                    ->whereNot('status_id', 5)
                    ->count();
                $data['Selesai'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->whereIn('id',
                        SprinHistory::where('unit_pemeriksa', 'BAGGAKKUM')
                                    ->select('data_pelanggar_id')
                                    ->groupBy('data_pelanggar_id')
                                    ->pluck('data_pelanggar_id')
                    )
                    ->where('status_id', 8)
                    ->count();

                $data['Dihentikan'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->whereIn('id',
                        SprinHistory::where('unit_pemeriksa', 'BAGGAKKUM')
                                    ->select('data_pelanggar_id')
                                    ->groupBy('data_pelanggar_id')
                                    ->pluck('data_pelanggar_id')
                    )
                    ->where('status_id', 9)
                    ->count();

                $data['Dihentikan (RJ)'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                ->whereYear('created_at', $currentYear)
                ->whereIn('id',
                    SprinHistory::where('unit_pemeriksa', 'BAGGAKKUM')
                                ->select('data_pelanggar_id')
                                ->groupBy('data_pelanggar_id')
                                ->pluck('data_pelanggar_id')
                )
                ->where('status_id', 10)
                ->count();
            }

            if($request->has('unit')){
                foreach (range(1,12) as $month) {
                    $monthStr = date('M', mktime(0, 0, 0, $month, 10));
                    $data['Diproses'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                        ->whereYear('created_at', $currentYear)
                        ->whereIn('id',
                            SprinHistory::where('unit_pemeriksa', $request->unit)
                                        ->select('data_pelanggar_id')
                                        ->groupBy('data_pelanggar_id')
                                        ->pluck('data_pelanggar_id')
                        )
                        ->whereBetween('status_id', [2,7])
                        ->whereNot('status_id', 5)
                        ->count();
                    $data['Selesai'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                        ->whereYear('created_at', $currentYear)
                        ->whereIn('id',
                            SprinHistory::where('unit_pemeriksa', $request->unit)
                                        ->select('data_pelanggar_id')
                                        ->groupBy('data_pelanggar_id')
                                        ->pluck('data_pelanggar_id')
                        )
                        ->where('status_id', 8)
                        ->count();

                    $data['Dihentikan'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                        ->whereYear('created_at', $currentYear)
                        ->whereIn('id',
                            SprinHistory::where('unit_pemeriksa', $request->unit)
                                        ->select('data_pelanggar_id')
                                        ->groupBy('data_pelanggar_id')
                                        ->pluck('data_pelanggar_id')
                        )
                        ->where('status_id', 9)
                        ->count();

                    $data['Dihentikan (RJ)'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->whereIn('id',
                        SprinHistory::where('unit_pemeriksa', $request->unit)
                                    ->select('data_pelanggar_id')
                                    ->groupBy('data_pelanggar_id')
                                    ->pluck('data_pelanggar_id')
                    )
                    ->where('status_id', 10)
                    ->count();
                }
            }
        } else if($tipe == 'total_by_status'){
            $currentYear = Carbon::now()->translatedFormat('Y');
            foreach (range(1,12) as $month) {
                $monthStr = date('M', mktime(0, 0, 0, $month, 10));
                $data['Diproses'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->whereBetween('status_id', [2,7])
                    ->whereNot('status_id', 5)
                    ->count();
                $data['Selesai'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->where('status_id', 8)
                    ->count();

                $data['Dihentikan'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                    ->whereYear('created_at', $currentYear)
                    ->where('status_id', 9)
                    ->count();

                $data['Dihentikan (RJ)'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)
                ->whereYear('created_at', $currentYear)
                ->where('status_id', 10)
                ->count();
            }
        }

        return response()->json($data)->header('Content-Type','application/json; charset=utf-8');
    }
}
