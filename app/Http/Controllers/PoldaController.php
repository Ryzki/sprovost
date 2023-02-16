<?php

namespace App\Http\Controllers;

use App\Models\Polda;
use Illuminate\Http\Request;

class PoldaController extends Controller
{
    public function getAllPolda()
    {
        $data['poldas'] = Polda::all();
        return view('pages.data_pelanggaran.select-polda', $data);
    }
}