<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\Pangkat;
use App\Models\Polda;
use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['polda'] = Polda::get();
        $data['pelanggar'] = DataPelanggar::get();
        $data['pengaduan_diproses'] = $data['pelanggar']->where('status_id','>',1)->where('status_id', '<', 8);

        foreach ($data['pelanggar'] as $val_plg) {
            $pangkat = Pangkat::where('id', $val_plg->pangkat)->first();
            $data['kasus_by_pangkat'][$pangkat->name] = DataPelanggar::where('pangkat', $val_plg->pangkat)->count();
        }

        $data['dumas_triwulan']['T1'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 1)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 3)->lastOfQuarter()])->count();
        $data['dumas_triwulan']['T2'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 4)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 6)->lastOfQuarter()])->count();
        $data['dumas_triwulan']['T3'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 7)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 9)->lastOfQuarter()])->count();
        $data['dumas_triwulan']['T4'] = DataPelanggar::whereBetween('tanggal_nota_dinas', [Carbon::create(Carbon::now()->format('Y'), 10)->firstOfQuarter(), Carbon::create(Carbon::now()->format('Y'), 12)->lastOfQuarter()])->count();

        // dd($data['dumas_triwulan']);

        $currentYear = Carbon::now()->translatedFormat('Y');
        foreach (range(1,12) as $month) {
            $monthStr = date('M', mktime(0, 0, 0, $month, 10));
            // dump($monthStr);
            $data['kasus_by_month'][$monthStr] = (int)DataPelanggar::whereMonth('created_at','=',$month)->whereYear('created_at', $currentYear)->count();
        }

        // dd($data['kasus_by_month']);

        return view('pages.dashboard.index',$data);
    }
}
