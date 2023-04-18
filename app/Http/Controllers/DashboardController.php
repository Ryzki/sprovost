<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\Polda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data['polda'] = Polda::get();
        $data['pelanggar'] = DataPelanggar::get();
        $data['pengaduan_diproses'] = $data['pelanggar']->where('status','>',1);
        return view('pages.dashboard.index',$data);
    }
}
