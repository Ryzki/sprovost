<?php

namespace App\Http\Controllers;

use App\Models\Polda;
use Illuminate\Http\Request;
use PDF;

define('PHPWORD_BASE_DIR', realpath(__DIR__));

class LimpahPoldaController extends Controller
{
    public function generateLimpahPolda(Request $request)
    {
        // dd($request->all());
        $data['ticketDesc'] = $request->ticketDesc;
        $pdf =  PDF::setOptions(['isRemoteEnabled' => TRUE])
        ->setPaper('A4', 'potrait')
        ->loadView('pages.data_pelanggaran.generate.limpah-polda', $data);

        return $pdf->download('limpah-polda.pdf');
    }
}
