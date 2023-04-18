<?php

namespace App\Http\Controllers;

use App\Models\WujudPerbuatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class WujudPerbuatanController extends Controller
{
    public function index()
    {
        $data['wujud_perbuatans'] = WujudPerbuatan::get();
        return view('pages.data_wujud_perbuatan.index', $data);
    }

    public function inputWujudPerbuatan()
    {
        return view('pages.data_wujud_perbuatan.input_wujud_perbuatan.input');
    }

    public function editWujudPerbuatan($id)
    {
        $wujud_perbuatan = WujudPerbuatan::where('id', $id)->first();
        $data = [
            'wujud_perbuatan' => $wujud_perbuatan,
        ];

        return view('pages.data_wujud_perbuatan.input_wujud_perbuatan.input',$data);
    }

    public function storeWujudPerbuatan(Request $request)
    {
        $DP = WujudPerbuatan::create([
            'jenis_wp' => $request->jenis_wp,
            'keterangan_wp' => $request->keterangan_wp,
        ]);
        
        return redirect()->action([WujudPerbuatanController::class, 'index']);
    }

    public function data(Request $request)
    {
        $query = WujudPerbuatan::select('*')->orderBy('id','desc')->get();

        return Datatables::of($query)->addColumn('action', function ($row) {
            return '<a href="' . route('wujud-perbuatan.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    
                  <button type="button" onclick="hapus('.$row->id.')" class="btn btn-danger btn-circle sa-params"
                  data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
        })->make(true);
    }

    public function updateData(Request $request)
    {
        $data_wujud_perbuatan = WujudPerbuatan::where('id', $request->id)->first();
        $data_wujud_perbuatan->update([
            'jenis_wp' => $request->jenis_wp,
            'keterangan_wp' => $request->keterangan_wp,
        ]);

        return redirect()->action([WujudPerbuatanController::class, 'index']);

    }

    public function hapusData($id)
    {
         WujudPerbuatan::where('id', $id)
            ->delete();
    }
}