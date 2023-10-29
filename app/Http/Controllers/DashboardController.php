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
        $data['pengaduan_diproses'] = $data['pelanggar']->where('status','>',1)->where('status', '<', 8);

        foreach ($data['pelanggar'] as $val_plg) {
            $pangkat = Pangkat::where('id', $val_plg->pangkat)->first();
            $data['kasus_by_pangkat'][$pangkat->name] = DataPelanggar::where('pangkat', $val_plg->pangkat)->count();
        }

        // foreach ($data['pelanggar'] as $val_plg) {
        //     $wujudPerbuatan = WujudPerbuatan::where('id', $val_plg->wujud_perbuatan)->first();
        //     $data['kasus_by_wujud'][$wujudPerbuatan->jenis_wp] = DataPelanggar::with('wujudPerbuatan', $val_plg->wujud_perbuatan)->count();
        // }

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
