<?php

namespace App\Http\Controllers;

use App\Models\Penyidik;
use App\Models\Pangkat;
use App\Models\DataPelanggar;
use App\Models\MasterPenyidik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;

class PenyidikController extends Controller
{
    public function index()
    {
        $data['penyidiks'] = MasterPenyidik::get();
        return view('pages.data_penyidik.index', $data);
    }

    public function inputPenyidik()
    {
        $pangkat = Pangkat::get();
        $data_pelanggar = DataPelanggar::get();
        $data = [
            'pangkats' => $pangkat,
            'data_pelanggars' => $data_pelanggar,
        ];

        return view('pages.data_penyidik.input_penyidik.input', $data);
    }

    public function editPenyidik($id)
    {
        $pangkat = Pangkat::get();
        $penyidik = MasterPenyidik::where('id', $id)->first();
        $data_pelanggar = DataPelanggar::get();
        $data = [
            'pangkats' => $pangkat,
            'data_pelanggars' => $data_pelanggar,
            'penyidik' => $penyidik,
        ];

        return view('pages.data_penyidik.input_penyidik.input', $data);
    }

    public function storePenyidik(Request $request)
    {
        $DP = MasterPenyidik::create([
            'name' => $request->name,
            'nrp' => $request->nrp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'tim' => $request->tim,
            'unit' => $request->unit,
        ]);

        return redirect()->action([PenyidikController::class, 'index']);
    }

    public function data(Request $request)
    {
        $query = MasterPenyidik::select('*')->orderBy('id', 'desc')->with('pangkats');

        if(isset($request->unit)){
            $query->where('unit', $request->unit);
        }

        return Datatables::of($query->get())->addColumn('action', function ($row) {
            return '<a href="' . route('penyidik.edit', [$row->id]) . '" class="btn btn-info btn-circle"
                  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>

                  <button type="button" onclick="hapus(' . $row->id . ')" class="btn btn-danger btn-circle sa-params"
                  data-toggle="tooltip" data-user-id="' . $row->id . '" data-original-title="Delete"><i class="fa fa-times" aria-hidden="true"></i></button>';
        })->make(true);
    }

    public function updateData(Request $request)
    {
        $data_penyidik = MasterPenyidik::where('id', $request->id)->first();
        $data_penyidik->update([
            'data_pelanggar' => $request->kasus_id,
            'name' => $request->name,
            'nrp' => $request->nrp,
            'pangkat' => $request->pangkat,
            'jabatan' => $request->jabatan,
            'tim' => $request->tim,
            'unit' => $request->unit,
        ]);

        return redirect()->action([PenyidikController::class, 'index']);
    }

    public function hapusData($id)
    {
        MasterPenyidik::where('id', $id)
            ->delete();
    }

    public function masterPenyidik()
    {
        $data = MasterPenyidik::get();
        return response()->json(['penyidik' => $data]);
    }
}
