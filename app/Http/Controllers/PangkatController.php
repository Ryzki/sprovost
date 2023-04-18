<?php

namespace App\Http\Controllers;

use App\Models\Pangkat;
use App\Models\DataPelanggar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class PangkatController extends Controller
{
    public function index()
    {
        $data['pangkats'] = pangkat::get();
        return view('pages.data_pangkat.index', $data);
    }

    public function inputPangkat()
    {
        return view('pages.data_pangkat.input_pangkat.input');
    }

    public function editPangkat($id)
    {
        $pangkat = Pangkat::where('id', $id)->first();
        $data = [
            'pangkat' => $pangkat,
        ];

        return view('pages.data_pangkat.input_pangkat.input',$data);
    }

    public function storePangkat(Request $request)
    {
        $DP = pangkat::create([
            'name' => $request->name,
        ]);
        
        return redirect()->action([PangkatController::class, 'index']);
    }

    public function data(Request $request)
    {
        $query = Pangkat::select('*')->orderBy('id','desc')->get();

        return Datatables::of($query)->addColumn('action', function ($row) {
            return '<a href="' . route('pangkat.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
    
                  <button type="button" onclick="hapus('.$row->id.')" class="btn btn-danger btn-circle sa-params"
                  data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
        })->make(true);
    }

    public function updateData(Request $request)
    {
        $data_pangkat = Pangkat::where('id', $request->id)->first();
        $data_pangkat->update([
            'name' => $request->name,
        ]);

        return redirect()->action([PangkatController::class, 'index']);

    }

    public function hapusData($id)
    {
         Pangkat::where('id', $id)
            ->delete();
    }
}