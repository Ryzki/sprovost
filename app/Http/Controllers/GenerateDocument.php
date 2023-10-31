<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\BAI;
use App\Models\BAP;
use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\DP3D;
use App\Models\GelarPerkara;
use App\Models\LimpahPolda;
use App\Models\LPA;
use App\Models\MasterPenyidik;
use App\Models\Penyidik;
use App\Models\PublicWitness;
use App\Models\SidangDisiplin;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use App\Models\UndanganKlarifikasiHistories;
use App\Models\Witness;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\TemplateProcessor;
use ZipArchive;

class GenerateDocument extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadFile($filename)
    {
        $path = storage_path('document/'.$filename);
        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function generateDisposisi(Request $request)
    {
        $disposisi = (new DiterimaController)->LembarDisposisi($request);
        $statusCode = $disposisi->getData()->status->code;
        $msg = isset($disposisi->getData()->detail) ? $disposisi->getData()->detail : '' ;

        $kasus = $disposisi->getData()->kasus;
        $data = $disposisi->getData()->document_data;
        $data = json_decode(json_encode($data), true);

        $filename = $kasus->pelapor.' - Lembar Disposisi';
        $path = storage_path('document/'.$filename.'.docx');
        $template = new TemplateProcessor(storage_path('template/template disposisi.docx'));

        $template->setValue('no_surat', $data['nomor_surat']);
        $template->setValue('no_agenda', $data['nomor_agenda']);
        $template->setValue('surat_dati', $data['surat_dati']);
        $template->setValue('tanggal', $data['tanggal']);
        $template->setValue('perihal', $data['perihal']);

        $template->saveAs($path);
        return response()->json(['file' => $filename.'.docx']);
    }

    public function generateDisposisiKaro(Request $request){
        $this->validate($request, [
            'nomor_surat' => 'required',
            'nomor_agenda' => 'required',
            'klasifikasi' => 'required',
            'derajat' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ],[
            'tanggal' => 'kolom tanggal diterima wajib diisi.',
            'jam' => 'kolom jam diterima wajib diisi.'
        ]);

        try {
            $disposisi = (new DiterimaController)->DisposisiKaro($request);

            $kasus = $disposisi->getData()->kasus;
            $data = $disposisi->getData()->document_data;
            $data = json_decode(json_encode($data), true);

            $filename = "$kasus->pelapor - Lembar Disposisi Karo";
            $path = storage_path('document/'.$filename.'.docx');
            $template = new TemplateProcessor(storage_path('template/template_disposisi_karo.docx'));
            $template->setValues($data);
            $template->saveAs($path);

            return response()->json(['file' => $filename.'.docx']);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'msg' => 'Err',
                    'code' => 500,
                ],
                'data' => null,
                'err_detail' => $th,
            ], 500);
        }

    }

    public function generateDisposisiSesro(Request $request){
        $this->validate($request, [
            'nomor_surat' => 'required',
            'nomor_agenda' => 'required',
            'klasifikasi' => 'required',
            'derajat' => 'required',
            'tanggal' => 'required',
            'jam' => 'required',
        ],[
            'tanggal' => 'kolom tanggal diterima wajib diisi.',
            'jam' => 'kolom jam diterima wajib diisi.'
        ]);
        try {
            $disposisi = (new DiterimaController)->DisposisiSesro($request);

            $kasus = $disposisi->getData()->kasus;
            $data = $disposisi->getData()->document_data;
            $data = json_decode(json_encode($data), true);

            $filename = "$kasus->pelapor - Lembar Disposisi Sesro";
            $path = storage_path('document/'.$filename.'.docx');
            $template = new TemplateProcessor(storage_path('template/template_disposisi_sesro.docx'));
            $template->setValues($data);
            $template->saveAs($path);

            return response()->json(['file' => $filename.'.docx']);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'msg' => 'Err',
                    'code' => 500,
                ],
                'data' => null,
                'err_detail' => $th,
            ], 500);
        }
    }

    public function generateDisposisiKabag(Request $request){
        $this->validate($request, [
            'nomor_surat' => 'required',
            'nomor_agenda' => 'required',
            'klasifikasi' => 'required',
            'derajat' => 'required',
            'tanggal' => 'required',
        ],[
            'tanggal' => 'kolom tanggal diterima wajib diisi.',
        ]);

        try {
            $disposisi = (new DiterimaController)->DisposisiKabag($request);

            $kasus = $disposisi->getData()->kasus;
            $data = $disposisi->getData()->document_data;
            $data = json_decode(json_encode($data), true);

            $filename = "$kasus->pelapor - Lembar Disposisi Kabaggakkum";
            $path = storage_path('document/'.$filename.'.docx');
            $template = new TemplateProcessor(storage_path('template/template_disposisi_kabag.docx'));
            $template->setValues($data);
            $template->saveAs($path);

            return response()->json(['file' => $filename.'.docx']);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'msg' => 'Err',
                    'code' => 500,
                ],
                'data' => null,
                'err_detail' => $th,
            ], 500);
        }
    }

    // Document Pulbaket
    public function SuratPerintah(Request $request, $kasus_id)
    {
        if($request->method() != 'GET'){
            $this->validate($request, [
                'no_sprin' => 'required',
                // 'pangkat' => 'required',
                // 'nama' => 'required',
                // 'nrp' => 'required',
                // 'jabatan' => 'required',
                // 'kesatuan' => 'required',
                'unit_pemeriksa' => 'required'
            ]);
        }

        try {
            $kasus = DataPelanggar::find($kasus_id);
            $sprin = (new PulbaketController)->SuratPerintah($request, $kasus_id);
            $penyelidik = $sprin->getData()->penyelidik;
            $sprinHistory = $sprin->getData()->sprinHistory;

            $template_document = new TemplateProcessor(storage_path('template/template_sprin.docx'));

            $template_document->cloneRow('pangkat_penyelidik', count($penyelidik));
            foreach ($penyelidik as $i => $val) {
                $template_document->setValues(array(
                    "no#".$i+1 => $i+1,
                    'pangkat_penyelidik#'.$i+1 => strtoupper($val->pangkat),
                    'jabatan_penyelidik#'.$i+1 => strtoupper($val->jabatan),
                    'kesatuan_penyelidik#'.$i+1 => strtoupper($val->kesatuan),
                    'nama_penyelidik#'.$i+1 => strtoupper($val->name),
                    'nrp_penyelidik#'.$i+1 => $val->nrp,
                ));
            }

            $template_document->setValues(array(
                'no_nd' => $kasus->no_nota_dinas,
                'tgl_nd' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
                'perihal_nd' => $kasus->perihal_nota_dinas,
                'pelapor' => $kasus->pelapor,
                'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                'terlapor' => $kasus->terlapor,
                'pangkat' => $kasus->pangkatName->name,
                'jabatan' => $kasus->jabatan,
                'kesatuan' => $kasus->kesatuan,
                'no_sprin' => $request->no_sprin != '' ? $request->no_sprin : $sprinHistory->no_sprin,
                'tanggal_ttd' => Carbon::parse($sprinHistory->created_at)->translatedFormat('F Y')
            ));

            $filename = "$kasus->pelapor - SPRIN Lidik.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            if ($request->method() == 'GET'){
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return response()->json(['file' => $filename]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'Terjadi Masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function SuratPerintahPengantar($kasus_id){
        DB::beginTransaction();
        try {
            $kasus = DataPelanggar::find($kasus_id);

            $template_document = new TemplateProcessor(storage_path('template/pengantar_sprin.docx'));
            $template_document->setValues(array(
                'nrp' => $kasus->no_pengaduan,
                'tgl_nd' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
                'kronologi' => $kasus->kronologi,
                'pangkat' => $kasus->pangkatName->name,
                'terlapor' => $kasus->terlapor,
                'jabatan' => $kasus->jabatan,
                'kesatuan' => $kasus->kesatuan,
                'tgl_ttd' => Carbon::now()->translatedFormat('F Y')
            ));

            $filename = "$kasus->pelapor - Pengantar SPRIN Lidik";
            $path = storage_path('document/'.$filename.'.docx');
            $template_document->saveAs($path);

            DB::commit();
            return response()->download($path)->deleteFileAfterSend(true);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function undangan_klarifikasi(Request $request, $kasus_id){
        $this->validate($request, [
            'no_undangan' => 'required',
            'tgl_pertemuan' => 'required',
            'ruang_pertemuan' => 'required',
            'jam_pertemuan' => 'required',
            'penyidik' => 'required',
            'no_telp_penyidik' => 'required',
        ], [
            'tgl_pertemuan' => 'Kolom Tanggal undangan wajib diisi',
            'ruang_pertemuan' => 'Kolom Ruang penyelidikan wajib diisi',
            'jam_pertemuan' => 'Kolom Jam undangan wajib diisi',
        ]);

        DB::beginTransaction();
        try {
            $kasus = DataPelanggar::find($kasus_id);
            $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
            $penyidik = Penyidik::find($request->penyidik);

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            UndanganKlarifikasiHistories::create([
                'data_pelanggar_id' => $kasus_id,
                'no_undangan' => $request->no_undangan,
                'tgl_pertemuan' => $request->tgl_pertemuan,
                'ruang_pertemuan' => $request->ruang_pertemuan,
                'jam_pertemuan' => $request->jam_pertemuan,
                'penyidik' => $request->penyidik,
                'no_telp_penyidik' => $request->no_telp_penyidik
            ]);

            $template_document = new TemplateProcessor(storage_path('template/template_undangan_klarifikasi.docx'));
            $template_document->setValues(array(
                'no' => $request->no_undangan,
                'create_date' => Carbon::now()->translatedFormat('d F Y'),
                'pangkat' => strtoupper($kasus->pangkatName->name),
                'terlapor' => strtoupper($kasus->terlapor),
                'no_nd' => $kasus->no_nota_dinas,
                'tgl_nd' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'pelapor' => strtoupper($kasus->pelapor),
                'no_sprin' => $sprin->no_sprin,
                'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'tgl_lapor' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
                'perihal_nd' => $kasus->perihal_nota_dinas,
                'jabatan_terlapor' => strtoupper($kasus->jabatan),
                'kesatuan_terlapor' => strtoupper($kasus->kesatuan),
                'pangkat_penyidik'=> strtoupper($penyidik->pangkat),
                'penyelidik'=> strtoupper($penyidik->name),
                'no_telp' => $request->no_telp_penyidik,
                'jabatan_penyelidik'=> strtoupper($penyidik->jabatan),
                'kesatuan_penyelidik'=> strtoupper($penyidik->kesatuan),
                'hari_pertemuan' => Carbon::parse($request->tgl_pertemuan)->translatedFormat('l'),
                'tgl_pertemuan' => Carbon::parse($request->tgl_pertemuan)->translatedFormat('d F Y'),
                'ruang_pertemuan' => $request->ruang_pertemuan,
                'jam_pertemuan' => $request->jam_pertemuan.' WIB'
            ));

            $filename = "$kasus->pelapor - Undangan Klarifikasi.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            DB::commit();
            return response()->json(['file' => $filename]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
        // return response()->download($path)->deleteFileAfterSend(true);
    }

    public function bai(Request $request, $kasus_id){
        DB::beginTransaction();
        $this->validate($request,[
            'penyidik1' => 'required',
            'penyidik2' => 'required',
            'nama.*' => 'required',
            'pangkat.*' => 'required',
            'jabatan.*' => 'required',
            'nrp.*' => 'required|digits:8',
            'kesatuan.*' => 'required',
            'ttl.*' => 'required',
            'warga_negara.*' => 'required',
            'agama.*' => 'required',
            'alamat.*' => 'required',
            'no_telp.*' => 'required',
        ],[
            'penyidik1' => 'Kolom penyidik pertama harus diisi',
            'penyidik2' => 'Kolom penyidik kedua harus diisi',
            'ttl.*' => 'Kolom tempat tanggal lahir harus diisi',
            'nama.*' => 'Kolom Nama Saksi harus diisi',
            'pangkat.*' => 'Kolom Pangkat Saksi harus diisi',
            'jabatan.*' => 'Kolom Jabatan Saksi harus diisi',
            'kesatuan.*' => 'Kolom Kesatuan Saksi harus diisi',
            'warga_negara.*' => 'Kolom Warga Negara harus diisi',
            'agama.*' => 'Kolom Agama harus diisi',
            'alamat.*' => 'Kolom Alamat Saksi harus diisi',
            'no_telp.*' => 'Kolom No. Telp Saksi harus diisi',
            'nrp.*.required' => 'Kolom NRP Saksi harus diisi',
            'nrp.*.digits' => 'Kolom NRP Saksi harus 8 Digit Angka',
        ]);
        try {
            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            $bai = BAI::where('data_pelanggar_id', $kasus_id)->first();
            $penyidik1 = Penyidik::where('id', $request->penyidik1)->where('data_pelanggar_id', $kasus_id)->first();
            $penyidik2 = Penyidik::where('id', $request->penyidik2)->where('data_pelanggar_id', $kasus_id)->first();
            $dataSaksi = Witness::where('data_pelanggar_id', $kasus_id)->get();
            $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();

            $file = array();
            $kasus = DataPelanggar::find($kasus_id);

            if ($bai == null){
                BAI::create([
                  'data_pelanggar_id' => $kasus_id,
                  'penyidik1' => $request->penyidik1,
                  'penyidik2' => $request->penyidik2
                ]);
            }

            if (count($dataSaksi) == 0){
                for ($i=0; $i < count($request->nama) ; $i++) {
                    $template_document = new TemplateProcessor(storage_path('template/template_bai.docx'));
                    Witness::create([
                        'data_pelanggar_id' => $kasus_id,
                        'nama' => strtoupper($request->nama[$i]),
                        'pangkat' => $request->pangkat[$i],
                        'nrp' => strtoupper($request->nrp[$i]),
                        'jabatan' => strtoupper($request->jabatan[$i]),
                        'warga_negara' => $request->warga_negara[$i],
                        'kesatuan' => $request->kesatuan[$i],
                        'agama' => $request->agama[$i],
                        'alamat' => $request->alamat[$i],
                        'ttl' => $request->ttl[$i],
                        'no_telp' => $request->no_telp[$i],
                    ]);

                    $template_document->setValues(array(
                        'saksi' => strtoupper($request->nama[$i]),
                        'pangkat_saksi' => strtoupper($request->pangkat[$i]),
                        'nrp_saksi' => $request->nrp[$i],
                        'jabatan_saksi' => strtoupper($request->jabatan[$i]),
                        'kesatuan_saksi' => strtoupper($request->kesatuan[$i]),
                        'ttl_saksi' => $request->ttl[$i],
                        'warga_negara_saksi' => strtoupper($request->warga_negara[$i]),
                        'agama_saksi' => $request->agamaText[$i],
                        'alamat_saksi' => $request->alamat[$i],
                        'no_telp_saksi' => $request->no_telp[$i],
                    ));

                    $template_document->setValues(array(
                        'hari' => Carbon::now()->translatedFormat('l'),
                        'tanggal' => dateToWord(Carbon::now()->translatedFormat('d')),
                        'bulan' => Carbon::now()->translatedFormat('F'),
                        'tahun' => dateToWord(Carbon::now()->translatedFormat('Y')),
                        'tgl' => Carbon::now()->translatedFormat('d-F-Y'),
                        'jam' => date('H:i') . ' WIB',
                        // Data Pemeriksa
                        'pemeriksa1' => strtoupper($penyidik1->name),
                        'pangkat1' => strtoupper($penyidik1->pangkat),
                        'nrp1' => $penyidik1->nrp,
                        'jabatan1' => strtoupper($penyidik1->jabatan),
                        'kesatuan1' => strtoupper($penyidik1->kesatuan),
                        'pemeriksa2' => strtoupper($penyidik2->name),
                        'pangkat2' => strtoupper($penyidik2->pangkat),
                        'nrp2' => $penyidik2->nrp,
                        'jabatan2' => strtoupper($penyidik2->jabatan),
                        'kesatuan2' => strtoupper($penyidik2->kesatuan),
                        // Data Kasus
                        'pangkat' => strtoupper($kasus->pangkatName->name),
                        'terlapor' => strtoupper($kasus->terlapor),
                        'jabatan' => strtoupper($kasus->jabatan),
                        'kesatuan' => strtoupper($kasus->kesatuan),
                        'kronologi' => strtoupper($kasus->kronologi),
                        'no_nd' => strtoupper($kasus->no_nota_dinas),
                        'tgl_nd' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                        // Data SPRIN
                        'no_sprin' => $sprin->no_sprin,
                        'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d-F-Y'),
                    ));

                    $filename = 'BAI - '.$request->pangkat[$i].' '.$request->nama[$i].'.docx';
                    $path = storage_path('document/'.$filename);
                    $template_document->saveAs($path);
                    array_push($file, $filename);
                }
            } else {
                foreach ($dataSaksi as $saksi) {
                    $agama = Agama::where('id', $saksi->agama)->first();
                    $template_document = new TemplateProcessor(storage_path('template/template_bai.docx'));

                    $template_document->setValues(array(
                        'saksi' => strtoupper($saksi->nama),
                        'pangkat_saksi' => strtoupper($saksi->pangkat),
                        'nrp_saksi' => $saksi->nrp,
                        'jabatan_saksi' => strtoupper($saksi->jabatan),
                        'kesatuan_saksi' => strtoupper($saksi->kesatuan),
                        'ttl_saksi' => $saksi->ttl,
                        'warga_negara_saksi' => strtoupper($saksi->warga_negara),
                        'agama_saksi' => $agama->name,
                        'alamat_saksi' => $saksi->alamat,
                        'no_telp_saksi' => $saksi->no_telp,
                    ));

                    $template_document->setValues(array(
                        'hari' => Carbon::now()->translatedFormat('l'),
                        'tanggal' => dateToWord(Carbon::now()->translatedFormat('d')),
                        'bulan' => Carbon::now()->translatedFormat('F'),
                        'tahun' => dateToWord(Carbon::now()->translatedFormat('Y')),
                        'tgl' => Carbon::now()->translatedFormat('d-F-Y'),
                        'jam' => date('H:i') . ' WIB',
                        // Data Pemeriksa
                        'pemeriksa1' => strtoupper($penyidik1->name),
                        'pangkat1' => strtoupper($penyidik1->pangkat),
                        'nrp1' => $penyidik1->nrp,
                        'jabatan1' => strtoupper($penyidik1->jabatan),
                        'kesatuan1' => strtoupper($penyidik1->kesatuan),
                        'pemeriksa2' => strtoupper($penyidik2->name),
                        'pangkat2' => strtoupper($penyidik2->pangkat),
                        'nrp2' => $penyidik2->nrp,
                        'jabatan2' => strtoupper($penyidik2->jabatan),
                        'kesatuan2' => strtoupper($penyidik2->kesatuan),
                        // Data Kasus
                        'pangkat' => strtoupper($kasus->pangkatName->name),
                        'terlapor' => strtoupper($kasus->terlapor),
                        'jabatan' => strtoupper($kasus->jabatan),
                        'kesatuan' => strtoupper($kasus->kesatuan),
                        'kronologi' => strtoupper($kasus->kronologi),
                        'no_nd' => strtoupper($kasus->no_nota_dinas),
                        'tgl_nd' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
                        // Data SPRIN
                        'no_sprin' => $sprin->no_sprin,
                        'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                    ));

                    $filename = $kasus->pelapor.' - BAI - '.$saksi->pangkat.' '.$saksi->nama.'.docx';
                    $path = storage_path('document/'.$filename);
                    $template_document->saveAs($path);
                    array_push($file, $filename);
                }
            }

            DB::commit();
            return response()->json(['file' => $file]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    /** GA DIPAKE */
    public function nd_permohonan_gelar_perkara(Request $request, $kasus_id){
        $hari = Carbon::parse($request->tgl)->translatedFormat('l');
        $tgl = Carbon::parse($request->tgl)->translatedFormat('d F Y');

        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $request->process_id,
                'sub_process_id' => $request->sub_process,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $template_document = new TemplateProcessor(storage_path('template/template_nd_gelar_perkara.docx'));
        $template_document->setValues(array(
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            'hari' => $hari,
            'tgl' => $tgl,
            'jam' => $request->jam,
            'tempat' => $request->tempat,
            'pimpinan' => $request->pimpinan
        ));

        $filename = 'Dokumen Nota Dinas Permohonan Gelar Perkara'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);
        return response()->json(['file' => $filename]);
    }
    // End of document pulbaket

    // Document Gelar Lidik
    public function sprin_gelar(Request $request, $kasus_id){
        if($request->method() != 'GET'){
            $this->validate($request, [
                'no_sprin' => 'required',
                'tgl' => 'required',
                'tempat' => 'required',
                'waktu' => 'required',
            ], [
                'no_sprin' => 'Kolom No. SPRIN wajib diisi',
                'tgl' => 'Kolom Tanggal Pelaksanaan Gelar wajib diisi',
                'tempat' => 'Kolom Tempat Pelaksanaan Gelar wajib diisi',
                'waktu' => 'Kolom Waktu Pelaksanaan Gelar wajib diisi',
            ]);
        }

        DB::beginTransaction();
        try {
            $no_sprin = str_replace('_', '', $request->no_sprin);
            $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'gelar')->first();
            $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();

            $hari = Carbon::parse($request->tgl != ''? $request->tgl : $gelarPerkara->tgl_pelaksanaan )->translatedFormat('l');
            $tgl = Carbon::parse($request->tgl != '' ? $request->tgl : $gelarPerkara->tgl_pelaksanaan )->translatedFormat('d F Y');

            if($gelarPerkara == null){
                $gelarPerkara = GelarPerkara::create([
                    'data_pelanggar_id' => $kasus_id,
                    'tgl_pelaksanaan' => $request->tgl,
                    'tempat_pelaksanaan' => $request->tempat,
                    'waktu_pelaksanaan' => $request->waktu,
                ]);
            } else {
                $gelarPerkara->tgl_pelaksanaan = $request->tgl;
                $gelarPerkara->tempat_pelaksanaan = $request->tempat;
                $gelarPerkara->waktu_pelaksanaan = $request->waktu;
                $gelarPerkara->save();
            }

            $kasus = DataPelanggar::find($kasus_id);
            if ($sprinHistory == null){
                $sprinHistory = SprinHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_sprin' => $no_sprin,
                    'created_by' => Auth::user()->id,
                    'type' => 'gelar',
                ]);

                $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
                if($dokumen == null){
                    DokumenPelanggar::create([
                        'data_pelanggar_id' => $kasus_id,
                        'process_id' => $request->process_id,
                        'sub_process_id' => $request->sub_process,
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }
            }

            $template_document = new TemplateProcessor(storage_path('template/template_sprin_gelar_perkara.docx'));
            $template_document->setValues(array(
                'no_sprin' => $no_sprin != '' ? $no_sprin : $sprinHistory->no_sprin,
                'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
                'hari' => $hari,
                'tgl' => $tgl
            ));

            $filename = "$kasus->pelapor - SPRIN Gelar Perkara.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            DB::commit();
            if ($request->method() == 'GET'){
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return response()->json(['file' => $filename]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function berkas_undangan_gelar(Request $request, $kasus_id){
        $this->validate($request, [
            'no_undangan' => 'required',
            'pimpinan' => 'required',
        ], [
            'no_undangan' => 'Kolom No. Undangan Gelar Perkara wajib diisi',
            'pimpinan' => 'kolom Pimpinan Gelar Perkara Wajib diisi',
        ]);

        try {
            $hari = Carbon::parse($request->tgl)->translatedFormat('l');
            $tgl = Carbon::parse($request->tgl)->translatedFormat('d F Y');
            $kasus = DataPelanggar::find($kasus_id);
            $thn = Carbon::now()->translatedFormat('Y');

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();
            $gelarPerkara->pimpinan = $request->pimpinan;
            $gelarPerkara->save();

            // $pimpinan = Penyidik::where('id', $request->pimpinan)->where('data_pelanggar_id', $kasus_id)->first();
            $pimpinan = MasterPenyidik::where('id', $request->pimpinan)->first();

            $template_document = new TemplateProcessor(storage_path('template/undangan_gelar.docx'));
            $template_document->setValues(array(
                'no_undangan' => $request->no_undangan,
                'bulan_surat' => getBulanRomawi(Carbon::now()->translatedFormat('m')),
                'thn_surat' => $thn,
                'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
                'hari' => $hari,
                'tgl' => $tgl,
                'jam' => $request->jam,
                'tempat' => $request->tempat,
                'pimpinan' => $pimpinan->pangkats->name." ".$pimpinan->name,
            ));

            $filename = "$kasus->pelapor - Undangan Gelar Perkara.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);
            return response()->json(['file' => $filename]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function notulen_hasil_gelar($kasus_id, $process_id, $subprocess){
        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $process_id,
                'sub_process_id' => $subprocess,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }
        return redirect()->back()->with('msg', 'Proses cetak Notulen Hasil Gelar sedang dalam pengerjaan');
    }

    public function laporan_hasil_gelar(Request $request, $kasus_id){
        $this->validate($request, [
            'pimpinan' => 'required',
            'pemapar' => 'required',
            'notulen' => 'required',
            'operator' => 'required',
            'hasil_gp' => 'required',
            'landasan_hukum' => 'required',
            'tindak_lanjut' => 'required'
        ], [
            'pimpinan' => 'kolom Pimpinan Gelar Perkara Wajib diisi',
            'pemapar' => 'kolom Pemapar Gelar Perkara Wajib diisi',
            'notulen' => 'kolom Notulen Gelar Perkara Wajib diisi',
            'operator' => 'kolom Operator Gelar Perkara Wajib diisi',
            'hasil_gp' => 'kolom Hasil Gelar Perkara Wajib diisi',
            'landasan_hukum' => 'kolom Landasan Hukum Wajib diisi',
            'tindak_lanjut' => 'kolom Tindak Lanjut Wajib diisi',
        ]);
        try {
            $dataPelanggaran = DataPelanggar::find($kasus_id);
            $sprinLidik = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
            $sprinGelar = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'gelar')->first();

            $pimpinan = MasterPenyidik::where('id', $request->pimpinan)->first();
            // $pimpinan = Penyidik::where('id', $request->pimpinan)->where('data_pelanggar_id', $kasus_id)->first();
            $pemapar = Penyidik::where('id', $request->pemapar)->where('data_pelanggar_id', $kasus_id)->first();
            $notulen = Penyidik::where('id', $request->notulen)->where('data_pelanggar_id', $kasus_id)->first();
            $operator = Penyidik::where('id', $request->operator)->where('data_pelanggar_id', $kasus_id)->first();

            $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();
            $gelarPerkara->pemapar = $request->pemapar;
            $gelarPerkara->notulen = $request->notulen;
            $gelarPerkara->operator = $request->operator;
            $gelarPerkara->hasil_gelar = $request->hasil_gp;
            $gelarPerkara->landasan_hukum = $request->landasan_hukum;
            $gelarPerkara->saran_penyidik = $request->tindak_lanjut;
            $gelarPerkara->save();

            $template_document = new TemplateProcessor(storage_path('template/template_lap_hasil_gp.docx'));

            $template_document->setValues(array(
                'no_nd' => $dataPelanggaran->no_nota_dinas,
                'tgl_nd' => Carbon::parse($dataPelanggaran->tanggal_nota_dinas)->translatedFormat('d F Y'),
                'no_sprin_lidik' => $sprinLidik->no_sprin,
                'tgl_sprin_lidik' => Carbon::parse($sprinLidik->created_at)->translatedFormat('d F Y'),
                'pangkat_pimpinan' => strtoupper($pimpinan->pangkats->name),
                'nama_pimpinan' => strtoupper($pimpinan->name),
                'jabatan_pimpinan' => strtoupper($pimpinan->jabatan),
                'kesatuan_pimpinan' => strtoupper($pimpinan->kesatuan),
                'pangkat_pemapar' => strtoupper($pemapar->pangkat),
                'nama_pemapar' => strtoupper($pemapar->name),
                'nrp_pemapar' => strtoupper($pemapar->nrp),
                'jabatan_pemapar' => strtoupper($pemapar->jabatan),
                'kesatuan_pemapar' => strtoupper($pemapar->kesatuan),
                'pangkat_notulen' => strtoupper($notulen->pangkat),
                'nama_notulen' => strtoupper($notulen->name),
                'nrp_notulen' => strtoupper($notulen->nrp),
                'jabatan_notulen' => strtoupper($notulen->jabatan),
                'kesatuan_notulen' => strtoupper($notulen->kesatuan),
                'pangkat_operator' => strtoupper($operator->pangkat),
                'nama_operator' => strtoupper($operator->name),
                'jabatan_operator' => strtoupper($operator->jabatan),
                'kesatuan_operator' => strtoupper($operator->kesatuan),

                'hari_sidang' => Carbon::parse($request->tgl)->translatedFormat('l'),
                'tgl_sidang' => Carbon::parse($request->tgl)->translatedFormat('d F Y'),
                'jam_sidang' => $request->jam,
                'tempat_sidang' => $request->tempat,

                'hasil_gp' => $request->hasil_gp,
                'wujud_perbuatan' => $dataPelanggaran->wujudPerbuatan->keterangan_wp,
                'kronologi' => $dataPelanggaran->kronologi,
                'landasan_hukum' => $request->landasan_hukum,
                'tindak_lanjut' => $request->tindak_lanjut,

                'pangkat_terlapor' => strtoupper($dataPelanggaran->pangkatName->name),
                'nama_terlapor' => strtoupper($dataPelanggaran->terlapor),
                'jabatan_terlapor' => strtoupper($dataPelanggaran->jabatan),
                'kesatuan_terlapor' => strtoupper($dataPelanggaran->kesatuan),

                'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            ));

            $filename = "$dataPelanggaran->pelapor - Dokumen Laporan Hasil Gelar Perkara.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            if($request->hasil_gp == 'Tidak Cukup Bukti'){
                $dataPelanggaran->status_id = 9;
                $dataPelanggaran->save();
            }

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            return response()->json(['file' => $filename]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
        // return response()->download($path)->deleteFileAfterSend(true);
    }

    public function sp2hp($kasus_id, $process_id, $subprocess){
        $dataPelanggaran = DataPelanggar::where('id', $kasus_id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
        $sprinGelar = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'gelar')->first();
        $jk = $dataPelanggaran->jenis_kelamin == 1 ? 'Sdr' : 'Sdri';
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id',$kasus_id)->first();

        switch ($gelarPerkara->hasil_gelar) {
            case 'Cukup Bukti':
                $keterangan = 'dan Dilanjutkan ke Pemeriksaan';
                break;
            case 'Tidak Cukup Bukti':
                $keterangan = 'oleh karena Tidak cukup bukti';
                break;
            case 'Dihentikan':
                $keterangan = 'oleh karena adanya pencabutan laporan dan kesepakatan bersama';
                break;
            default:
                $keterangan = '';
                break;
        }

        $template_document = new TemplateProcessor(storage_path('template/template_sp2hp.docx'));
        $template_document->setValues(array(
            'tgl_cetak' => Carbon::now()->translatedFormat('F Y'),
            'jk' => $jk,
            'pelapor' => strtoupper($dataPelanggaran->pelapor),
            'no_nd' => $dataPelanggaran->no_nota_dinas,
            'tgl_nd' => Carbon::parse($dataPelanggaran->tangal_nota_dinas)->translatedFormat('d F Y'),
            'no_sprin' => $sprin->no_sprin,
            'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'tgl_laporan' => Carbon::parse($dataPelanggaran->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $dataPelanggaran->wujud_perbuatan,
            'kronologi' => $dataPelanggaran->kronologi,
            'tgl_gp' => Carbon::parse($sprinGelar->tgl_pelaksanaan_gelar)->translatedFormat('d F Y'),
            'hasil_gelar' => $gelarPerkara->hasil_gelar == 'Tidak Cukup Bukti' ? 'Dihentikan' : $gelarPerkara->hasil_gelar,
            'keterangan' => $keterangan
        ));

        $filename = "$dataPelanggaran->pelapor - SP2HP.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $process_id,
                'sub_process_id' => $subprocess,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        if($dataPelanggaran->status_id != 9){
            return response()->download($path)->deleteFileAfterSend(true);
        } else {
            return $filename;
        }
    }

    public function limpah_polda(Request $request){
        DB::beginTransaction();
        try {
            $kasus = DataPelanggar::find($request->kasus_id);
            $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $request->kasus_id)->with(['penyidik', 'pemaparDetail', 'operatorDetail', 'notulenDetail'])->first();
            $sprin = SprinHistory::where('data_pelanggar_id', $request->kasus_id)->where('type', 'lidik')->first();

            LimpahPolda::create([
                'data_pelanggar_id' => $request->kasus_id,
                'polda_id' => $request->polda_id,
                'tanggal_limpah' => Carbon::now()->translatedFormat('Y/m/d'),
                'created_by' => Auth::user()->id,
            ]);

            $template_document = new TemplateProcessor(storage_path('template/template_limpah.docx'));
            $template_document->setValues(array(
                'no_nd' => $kasus->no_nota_dinas,
                'tgl_nd' => Carbon::parse($kasus->tangal_nota_dinas)->translatedFormat('d F Y'),
                'perihal_nd' => $kasus->perihal_nota_dinas,
                'sprin_lidik' => $sprin->no_sprin,
                'tgl_sprin_lidik' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'tgl_hasil_gp' => Carbon::parse($gelarPerkara->updated_at)->translatedFormat('d F Y'),
                'perihal' => $kasus->perihal_nota_dinas,
                'pangkat' => strtoupper($kasus->pangkatName->name),
                'terlapor' => strtoupper($kasus->terlapor),
                'jabatan' => strtoupper($kasus->jabatan),
                'kesatuan' => strtoupper($kasus->kesatuan),
                'wujud_perbuatan' => strtoupper($kasus->wujudPerbuatan->keterangan_wp),
                'lokasi_gp' => $gelarPerkara->tempat_pelaksanaan,
                'hasil_gp' => $gelarPerkara->hasil_gelar,
                'pimpinan_gp' => strtoupper($gelarPerkara->penyidik->pangkats->name).' '.strtoupper($gelarPerkara->penyidik->name),
                'jabatan_gp' => strtoupper($gelarPerkara->penyidik->jabatan).' '.strtoupper($gelarPerkara->penyidik->kesatuan),
                'keterangan_hasil' => $gelarPerkara->hasil_gelar == 'Cukup Bukti' ? 'terbukti melakukan pelanggaran KEPP' : 'tidak terbukti melakukan pelanggaran KEPP',
                'pelapor' => $kasus->nama_korban,
                'landasan_hukum' => $gelarPerkara->landasan_hukum,
                'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            ));

            $filename = "$kasus->pelapor - Surat Limpah.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            DB::commit();
            return $filename;
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
        //  response()->json(['file' => $filename]);
        // return response()->download($path)->deleteFileAfterSend(true);
    }

    // End of Document Gelar Lidik


    // Sidik / LPA
    public function lpa(Request $request, $kasus_id){
        if($request->method() != 'GET'){
            $this->validate($request, [
                'no_lpa' => 'required',
            ], [
                'no_lpa' => 'Kolom No. LPA wajib diisi',
            ]);
        }

        try {
            $kasus = DataPelanggar::find($kasus_id);

            if($request->method() != 'GET'){
                $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
                if($dokumen == null){
                    DokumenPelanggar::create([
                        'data_pelanggar_id' => $kasus_id,
                        'process_id' => $request->process_id,
                        'sub_process_id' => $request->sub_process,
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }
            }

            $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();
            if ($lpa == null){
                LPA::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_lpa' => $request->no_lpa,
                    'created_by' => Auth::user()->id,
                ]);
            }

            $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();
            // $penyidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('id', $gelarPerkara->pimpinan)->first();
            $penyidik = MasterPenyidik::where('id', $gelarPerkara->pimpinan)->first();

            $template_document = new TemplateProcessor(storage_path('template/template_lpa.docx'));
            $template_document->setValues(array(
                'kronologi' => $kasus->kronologi,
                'pasal_dilanggar' => $gelarPerkara->landasan_hukum,
                'hari' => Carbon::now()->translatedFormat('l'),
                'tanggal' => dateToWord(Carbon::now()->translatedFormat('d')),
                'bulan' => Carbon::now()->translatedFormat('F'),
                'tahun' => dateToWord(Carbon::now()->translatedFormat('Y')),
                'tgl' => Carbon::now()->translatedFormat('d F Y'),
                'jam' => date('H:i') . ' WIB',
                'no_laporan' => $lpa == null ? $request->no_lpa : $lpa->no_lpa,
                'nama' => strtoupper($penyidik->name),
                'pangkat' => strtoupper($penyidik->pangkats->name),
                'nrp' => $penyidik->nrp,
                'jabatan' => strtoupper($penyidik->jabatan),
                'kesatuan' => strtoupper($penyidik->kesatuan),
                'nama_terlapor' => strtoupper($kasus->terlapor),
                'pangkat_terlapor' => strtoupper($kasus->pangkatName->name),
                'kesatuan_terlapor' => strtoupper($kasus->kesatuan),
            ));

            $filename = "$kasus->pelapor - LPA.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);
            if ($request->method() == 'GET'){
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return response()->json(['file' => $filename]);
            }
            // return response()->json(['file' => $filename]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
        //response()->download($path)->deleteFileAfterSend(true);
    }

    public function sprin_riksa(Request $request, $kasus_id){
        if($request->method() != 'GET'){
            $this->validate($request, [
                'no_sprin' => 'required',
                // 'pangkat.*' => 'required',
                // 'nama.*' => 'required',
                // 'nrp.*' => 'required|digits:8',
                // 'jabatan.*' => 'required',
                // 'kesatuan.*' => 'required',
                'unit_pemeriksa' => 'required'
            ], [
                'nama.*.required' => 'Kolom Nama Penyelidik wajib diisi',
                'pangkat.*.required' => 'Kolom Pangkat Penyelidik wajib diisi',
                'nrp.*.required' => 'Kolom NRP Penyelidik wajib diisi',
                'nrp.*.digits' => 'Kolom NRP Penyelidik harus 8 digit',
                'jabatan.*.required' => 'Kolom Jabatan Penyelidik wajib diisi',
                'kesatuan.*.required' => 'Kolom Kesatuan Penyelidik wajib diisi',
            ]);
        }
        try {
            $kasus = DataPelanggar::find($kasus_id);
            $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();
            $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->get();

            $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();

            if ($sprinHistory == null){
                $sprinHistory = SprinHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_sprin' => $request->no_sprin,
                    'created_by' => Auth::user()->id,
                    'type' => 'riksa',
                    'unit_pemeriksa' => $request->unit_pemeriksa
                ]);


                $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
                if($dokumen == null){
                    DokumenPelanggar::create([
                        'data_pelanggar_id' => $kasus_id,
                        'process_id' => $request->process_id,
                        'sub_process_id' => $request->sub_process,
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }
            }

            $template_document = new TemplateProcessor(storage_path('template/template_sprin_riksa.docx'));
            if (count($penyelidik) == 0){
                $masterPenyelidik = MasterPenyidik::where('unit', $request->unit_pemeriksa)->with('pangkats')->get();

                foreach ($masterPenyelidik as $value) {
                    Penyidik::create([
                        'data_pelanggar_id' => $kasus_id,
                        'name' => strtoupper($value->name),
                        'nrp' => $value->nrp,
                        'pangkat' => strtoupper($value->pangkats->name),
                        'jabatan' => strtoupper($value->jabatan),
                        'kesatuan' => strtoupper($value->kesatuan),
                        'type' => 'riksa'
                    ]);
                }

                $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->get();
            }

            $template_document->cloneRow('pangkat_penyelidik', count($penyelidik));

            foreach ($penyelidik as $i => $val) {
                $template_document->setValues(array(
                    "no#".$i+1 => $i+1,
                    'pangkat_penyelidik#'.$i+1 => strtoupper($val->pangkat),
                    'jabatan_penyelidik#'.$i+1 => strtoupper($val->jabatan),
                    'kesatuan_penyelidik#'.$i+1 => strtoupper($val->kesatuan),
                    'nama_penyelidik#'.$i+1 => strtoupper($val->name),
                    'nrp_penyelidik#'.$i+1 => $val->nrp,
                ));
            }

            $template_document->setValues(array(
                'no_lpa' => $lpa->no_lpa,
                'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
                'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                'terlapor' => $kasus->terlapor,
                'pangkat' => $kasus->pangkatName->name,
                'jabatan' => $kasus->jabatan,
                'kesatuan' => $kasus->kesatuan,
                'no_sprin' => $request->no_sprin != '' ? $request->no_sprin : $sprinHistory->no_sprin,
                'tanggal_ttd' => Carbon::parse($sprinHistory->created_at)->translatedFormat('F Y')
            ));

            $filename = "$kasus->pelapor - SPRIN Riksa.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);
            if ($request->method() == 'GET'){
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return response()->json(['file' => $filename]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function surat_panggilan_saksi(Request $request, $kasus_id){
        $this->validate($request,[
            'penyidik1' => 'required',
            'tgl' => 'required',
            'waktu' => 'required',
            'no_telp_penyidik' => 'required',
            'lokasi' => 'required',
            'nama.*' => 'required',
            'pekerjaan.*' => 'required',
            'ttl.*' => 'required',
            'warga_negara.*' => 'required',
            'agama.*' => 'required',
            'no_telp.*' => 'required',
            'alamat.*' => 'required',
        ],[
            'penyidik1' => 'Kolom penyidik harus diisi',
            'tgl' => 'Kolom tanggal wajib diisi',
            'waktu' => 'Kolom waktu wajib diisi',
            'no_telp_penyidik' => 'Kolom No. Telpon Penyidik wajib diisi',
            'lokasi' => 'Kolom lokasi wajib diisi',
            'nama.*' => 'Kolom Nama Saksi harus diisi',
            'pekerjaan.*' => 'Kolom Pekerjaan Saksi harus diisi',
            'ttl.*' => 'Kolom tempat tanggal lahir harus diisi',
            'warga_negara.*' => 'Kolom Warga Negara harus diisi',
            'agama.*' => 'Kolom Agama harus diisi',
            'no_telp.*' => 'Kolom No. Telp Saksi harus diisi',
            'alamat.*' => 'Kolom Alamat Saksi harus diisi',
        ]);
        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $request->process_id,
                'sub_process_id' => $request->sub_process,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $penyidik1 = Penyidik::where('id', $request->penyidik1)->where('data_pelanggar_id', $kasus_id)->first();
        $dataSaksi = PublicWitness::where('data_pelanggar_id', $kasus_id)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();
        $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();
        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();


        $file = array();
        $kasus = DataPelanggar::find($kasus_id);

        if (count($dataSaksi) == 0){
            $template_document = new TemplateProcessor(storage_path('template/template_surat_panggilan_saksi.docx'));
            for ($i=0; $i < count($request->nama) ; $i++) {
                PublicWitness::create([
                    'data_pelanggar_id' => $kasus_id,
                    'nama' => strtoupper($request->nama[$i]),
                    'pekerjaan' => $request->pekerjaan[$i],
                    'warga_negara' => $request->warga_negara[$i],
                    'agama' => $request->agama[$i],
                    'alamat' => $request->alamat[$i],
                    'ttl' => $request->ttl[$i],
                    'no_telp' => $request->no_telp[$i],
                ]);

                $template_document->setValues(array(
                    'nama_saksi' => strtoupper($request->nama[$i]),
                    'pekerjaan_saksi' => strtoupper($request->pekerjaan[$i]),
                    'alamat_saksi' => $request->alamat[$i],
                ));

                $template_document->setValues(array(
                    'hari' => Carbon::parse($request->tgl)->translatedFormat('l'),
                    'tanggal' => dateToWord(Carbon::parse($request->tgl)->translatedFormat('d F Y')),
                    'jam' => $request->waktu,
                    'lokasi' => $request->lokasi,
                    // Data Pemeriksa
                    'penyidik' => strtoupper($penyidik1->pangkat).' '.strtoupper($penyidik1->name),
                    'jabatan_penyidik' => strtoupper($penyidik1->jabatan).' '.strtoupper($penyidik1->kesatuan),
                    'no_telp' => $request->no_telp_penyidik,
                    // Data Kasus
                    'terlapor' => strtoupper($kasus->pangkatName->name).' '.strtoupper($kasus->terlapor),
                    'jabatan' => strtoupper($kasus->jabatan).' '.strtoupper($kasus->kesatuan),
                    'wujud_perbuatan' => strtoupper($kasus->wujudPerbuatan->keterangan_wp),
                    // Data SPRIN & LPA
                    'no_sprin' => $sprin->no_sprin,
                    'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d-F-Y'),
                    'no_lpa' => $lpa->no_lpa,
                    'tgl_lpa' => $lpa->created_at,
                    'gelar_perkara' => $gelarPerkara->landasan_hukum,

                    'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
                ));

                $filename = "$kasus->pelapor - Surat Panggilan Saksi.docx";
                $path = storage_path('document/'.$filename);
                $template_document->saveAs($path);
                array_push($file, $filename);
            }
        } else {
            foreach ($dataSaksi as $saksi) {
                $template_document = new TemplateProcessor(storage_path('template/template_surat_panggilan_saksi.docx'));
                $template_document->setValues(array(
                    'nama_saksi' => strtoupper($saksi->nama),
                    'pekerjaan_saksi' => strtoupper($saksi->pekerjaan),
                    'alamat_saksi' => $saksi->alamat,
                ));

                $template_document->setValues(array(
                    'hari' => Carbon::parse($request->tgl)->translatedFormat('l'),
                    'tanggal' => dateToWord(Carbon::parse($request->tgl)->translatedFormat('d F Y')),
                    'jam' => $request->waktu,
                    'lokasi' => $request->lokasi,
                    // Data Pemeriksa
                    'penyidik' => strtoupper($penyidik1->pangkat).' '.strtoupper($penyidik1->name),
                    'jabatan_penyidik' => strtoupper($penyidik1->jabatan).' '.strtoupper($penyidik1->kesatuan),
                    'no_telp' => $request->no_telp_penyidik,
                    // Data Kasus
                    'terlapor' => strtoupper($kasus->pangkatName->name).' '.strtoupper($kasus->terlapor),
                    'jabatan' => strtoupper($kasus->jabatan).' '.strtoupper($kasus->kesatuan),
                    'wujud_perbuatan' => strtoupper($kasus->wujudPerbuatan->keterangan_wp),
                    // Data SPRIN & LPA
                    'no_sprin' => $sprin->no_sprin,
                    'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d-F-Y'),
                    'no_lpa' => $lpa->no_lpa,
                    'tgl_lpa' => $lpa->created_at,
                    'gelar_perkara' => $gelarPerkara->landasan_hukum,

                    'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
                ));

                $filename = "$kasus->pelapor - Surat Panggilan Saksi.docx";
                $path = storage_path('document/'.$filename);
                $template_document->saveAs($path);
                array_push($file, $filename);
            }
        }

        return response()->json(['file' => $file]);
    }

    public function surat_panggilan_terduga(Request $request, $kasus_id){
        $this->validate($request,[
            'penyidik_1' => 'required',
            'tgl' => 'required',
            'waktu' => 'required',
            'no_telp_penyidik' => 'required',
            'lokasi' => 'required',
        ],[
            'penyidik_1' => 'Kolom penyidik harus diisi',
            'tgl' => 'Kolom tanggal wajib diisi',
            'waktu' => 'Kolom waktu wajib diisi',
            'no_telp_penyidik' => 'Kolom No. Telpon Penyidik wajib diisi',
            'lokasi' => 'Kolom lokasi wajib diisi',
        ]);
        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $request->process_id,
                'sub_process_id' => $request->sub_process,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $template_document = new TemplateProcessor(storage_path('template/template_surat_panggilan_terduga.docx'));
        $kasus = DataPelanggar::find($kasus_id);
        $penyidik = Penyidik::where('id', $request->penyidik_1)->where('data_pelanggar_id', $kasus_id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_pengaduan,
            'tanggal_nota_dinas' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
            'no_sprin_riksa' => $sprin->no_sprin,
            'tanggal_sprin_riksa' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkatName->name,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'penyidik' => strtoupper($penyidik->pangkat).' '.strtoupper($penyidik->name),
            'jabatan_penyidik' => strtoupper($penyidik->jabatan),
            'hari' => Carbon::parse($request->tgl)->translatedFormat('l'),
            'tgl' => Carbon::parse($request->tgl)->translatedFormat('d F Y'),
            'jam' => $request->waktu,
            'lokasi' => $request->lokasi,
            'kronologi' => $kasus->kronologi,
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
        ));
        $filename = "$kasus->pelapor - Surat Panggilan Terduga.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->json(['file' => $filename]);
    }

    public function bap(Request $request, $kasus_id){
        DB::beginTransaction();
        $this->validate($request,[
            'penyidik1' => 'required',
            'penyidik2' => 'required',
        ],[
            'penyidik1' => 'Kolom penyidik pertama harus diisi',
            'penyidik2' => 'Kolom penyidik kedua harus diisi',
        ]);
        try {
            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            $bap = BAP::where('data_pelanggar_id', $kasus_id)->first();
            if($bap == null){
                BAP::create([
                    'data_pelanggar_id' => $kasus_id,
                    'penyidik1' => $request->penyidik1,
                    'penyidik2' => $request->penyidik2,
                ]);
            }

            $penyidik1 = Penyidik::where('id', $request->penyidik1)->where('data_pelanggar_id', $kasus_id)->first();
            $penyidik2 = Penyidik::where('id', $request->penyidik2)->where('data_pelanggar_id', $kasus_id)->first();
            $dataSaksi = Witness::where('data_pelanggar_id', $kasus_id)->get();
            $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();
            $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();

            $file = array();
            $kasus = DataPelanggar::find($kasus_id);

            if (count($dataSaksi) == 0){
                for ($i=0; $i < count($request->nama) ; $i++) {
                    $template_document = new TemplateProcessor(storage_path('template/template_bap.docx'));
                    Witness::create([
                        'data_pelanggar_id' => $kasus_id,
                        'nama' => strtoupper($request->nama[$i]),
                        'pangkat' => $request->pangkat[$i],
                        'nrp' => strtoupper($request->nrp[$i]),
                        'jabatan' => strtoupper($request->jabatan[$i]),
                        'warga_negara' => $request->warga_negara[$i],
                        'kesatuan' => $request->kesatuan[$i],
                        'agama' => $request->agama[$i],
                        'alamat' => $request->alamat[$i],
                        'ttl' => $request->ttl[$i],
                        'no_telp' => $request->no_telp[$i],
                    ]);

                    $template_document->setValues(array(
                        'saksi' => strtoupper($request->nama[$i]),
                        'pangkat_saksi' => strtoupper($request->pangkat[$i]),
                        'nrp_saksi' => $request->nrp[$i],
                        'jabatan_saksi' => strtoupper($request->jabatan[$i]),
                        'kesatuan_saksi' => strtoupper($request->kesatuan[$i]),
                        'ttl_saksi' => $request->ttl[$i],
                        'warga_negara_saksi' => strtoupper($request->warga_negara[$i]),
                        'agama_saksi' => $request->agamaText[$i],
                        'alamat_saksi' => $request->alamat[$i],
                        'no_telp_saksi' => $request->no_telp[$i],
                    ));

                    $template_document->setValues(array(
                        'hari' => Carbon::now()->translatedFormat('l'),
                        'tanggal' => dateToWord(Carbon::now()->translatedFormat('d')),
                        'bulan' => Carbon::now()->translatedFormat('F'),
                        'tahun' => dateToWord(Carbon::now()->translatedFormat('Y')),
                        'tgl' => Carbon::now()->translatedFormat('d-F-Y'),
                        'jam' => date('H:i') . ' WIB',
                        // Data Pemeriksa
                        'pemeriksa1' => strtoupper($penyidik1->name),
                        'pangkat1' => strtoupper($penyidik1->pangkat),
                        'nrp1' => $penyidik1->nrp,
                        'jabatan1' => strtoupper($penyidik1->jabatan),
                        'kesatuan1' => strtoupper($penyidik1->kesatuan),
                        'pemeriksa2' => strtoupper($penyidik2->name),
                        'pangkat2' => strtoupper($penyidik2->pangkat),
                        'nrp2' => $penyidik2->nrp,
                        'jabatan2' => strtoupper($penyidik2->jabatan),
                        'kesatuan2' => strtoupper($penyidik2->kesatuan),
                        // Data Kasus
                        'pangkat' => strtoupper($kasus->pangkatName->name),
                        'terlapor' => strtoupper($kasus->terlapor),
                        'jabatan' => strtoupper($kasus->jabatan),
                        'kesatuan' => strtoupper($kasus->kesatuan),
                        'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                        'kronologi' => strtoupper($kasus->kronologi),
                        'no_lpa' => strtoupper($lpa->no_lpa),
                        'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
                        // Data SPRIN
                        'no_sprin' => $sprin->no_sprin,
                        'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d-F-Y'),
                    ));

                    $filename = $kasus->pelapor.' - '.'BAP - '.$request->pangkat[$i].' '.$request->nama[$i].'.docx';
                    $path = storage_path('document/'.$filename);
                    $template_document->saveAs($path);
                    array_push($file, $filename);
                }
            } else {
                foreach ($dataSaksi as $saksi) {
                    $agama = Agama::where('id', $saksi->agama)->first();
                    $template_document = new TemplateProcessor(storage_path('template/template_bap.docx'));

                    $template_document->setValues(array(
                        'saksi' => strtoupper($saksi->nama),
                        'pangkat_saksi' => strtoupper($saksi->pangkat),
                        'nrp_saksi' => $saksi->nrp,
                        'jabatan_saksi' => strtoupper($saksi->jabatan),
                        'kesatuan_saksi' => strtoupper($saksi->kesatuan),
                        'ttl_saksi' => $saksi->ttl,
                        'warga_negara_saksi' => strtoupper($saksi->warga_negara),
                        'agama_saksi' => $agama->name,
                        'alamat_saksi' => $saksi->alamat,
                        'no_telp_saksi' => $saksi->no_telp,
                    ));

                    $template_document->setValues(array(
                        'hari' => Carbon::now()->translatedFormat('l'),
                        'tanggal' => dateToWord(Carbon::now()->translatedFormat('d')),
                        'bulan' => Carbon::now()->translatedFormat('F'),
                        'tahun' => dateToWord(Carbon::now()->translatedFormat('Y')),
                        'tgl' => Carbon::now()->translatedFormat('d-F-Y'),
                        'jam' => date('H:i') . ' WIB',
                        // Data Pemeriksa
                        'pemeriksa1' => strtoupper($penyidik1->name),
                        'pangkat1' => strtoupper($penyidik1->pangkat),
                        'nrp1' => $penyidik1->nrp,
                        'jabatan1' => strtoupper($penyidik1->jabatan),
                        'kesatuan1' => strtoupper($penyidik1->kesatuan),
                        'pemeriksa2' => strtoupper($penyidik2->name),
                        'pangkat2' => strtoupper($penyidik2->pangkat),
                        'nrp2' => $penyidik2->nrp,
                        'jabatan2' => strtoupper($penyidik2->jabatan),
                        'kesatuan2' => strtoupper($penyidik2->kesatuan),
                        // Data Kasus
                        'pangkat' => strtoupper($kasus->pangkatName->name),
                        'terlapor' => strtoupper($kasus->terlapor),
                        'jabatan' => strtoupper($kasus->jabatan),
                        'kesatuan' => strtoupper($kasus->kesatuan),
                        'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                        'kronologi' => strtoupper($kasus->kronologi),
                        'no_lpa' => strtoupper($lpa->no_lpa),
                        'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
                        // Data SPRIN
                        'no_sprin' => $sprin->no_sprin,
                        'tgl_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('d-F-Y'),
                    ));

                    $filename = $kasus->pelapor.' - BAP - '.$saksi->pangkat.' '.$saksi->nama.'.docx';
                    $path = storage_path('document/'.$filename);
                    $template_document->saveAs($path);
                    array_push($file, $filename);
                }
            }

            DB::commit();
            return response()->json(['file' => $file]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function dp3d(Request $request, $kasus_id){
        if($request->method() != 'GET'){
            $this->validate($request, [
                'no_dp3d' => 'required',
                'pasal' => 'required'
            ],[
                'no_dp3d' => 'Kolom No. DP3D wajib diisi',
                'pasal' => 'Kolom Pasal yang Dilanggar wajib diisi'
            ]);
        }
        try {
            $kasus = DataPelanggar::find($kasus_id);
            $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();
            $dp3d = DP3D::where('data_pelanggar_id', $kasus_id)->first();
            $template_document = new TemplateProcessor(storage_path('template/template_dp3d.docx'));

            if($dp3d == null){
                $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
                if($dokumen == null){
                    DokumenPelanggar::create([
                        'data_pelanggar_id' => $kasus_id,
                        'process_id' => $request->process_id,
                        'sub_process_id' => $request->sub_process,
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }

                DP3D::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_dp3d' => $request->no_dp3d,
                    'pasal' => $request->pasal,
                ]);

                $template_document->setValues(array(
                    'no_dp3d' => $request->no_dp3d,
                    'no_lpa' => $lpa->no_lpa,
                    'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
                    'terlapor' => strtoupper($kasus->terlapor),
                    'pangkat' => strtoupper($kasus->pangkatName->name),
                    'nrp' => $kasus->nrp,
                    'jabatan' => strtoupper($kasus->jabatan),
                    'kesatuan' => strtoupper($kasus->kesatuan),
                    'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                    'pasal' => $request->pasal,
                    'tgl' => Carbon::now()->translatedFormat('d F Y'),
                ));
            } else {
                $template_document->setValues(array(
                    'no_dp3d' => $dp3d->no_dp3d,
                    'no_lpa' => $lpa->no_lpa,
                    'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
                    'terlapor' => strtoupper($kasus->terlapor),
                    'pangkat' => strtoupper($kasus->pangkatName->name),
                    'nrp' => $kasus->nrp,
                    'jabatan' => strtoupper($kasus->jabatan),
                    'kesatuan' => strtoupper($kasus->kesatuan),
                    'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
                    'pasal' => $dp3d->pasal,
                    'tgl' => Carbon::now()->translatedFormat('d F Y'),
                ));
            }


            $filename = "$kasus->pelapor - Dokumen DP3D.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            if ($request->method() == 'GET'){
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return response()->json(['file' => $filename]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function pelimpahan_ankum($kasus_id, $process_id, $subprocess){
        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $process_id,
                'sub_process_id' => $subprocess,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $kasus = DataPelanggar::find($kasus_id);
        $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();
        $dp3d = DP3D::where('data_pelanggar_id', $kasus_id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();

        $template_document = new TemplateProcessor(storage_path('template/template_pelimpahan_ankum.docx'));
        $template_document->setValues(array(
            'tgl' => Carbon::now()->translatedFormat('d F Y'),
            'bulan_surat' => getBulanRomawi(Carbon::now()->translatedFormat('m')),
            'thn_surat' => Carbon::now()->translatedFormat('Y'),
            'pangkat' => strtoupper($kasus->pangkatName->name),
            'terlapor' => strtoupper($kasus->terlapor),
            'nrp' => $kasus->nrp,
            'no_lpa' => $lpa->no_lpa,
            'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $kasus->wujudPerbuatan->keterangan_wp,
            'kronologi' => $kasus->kronologi,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pasal' => $dp3d->pasal,
            'no_dp3d' => $dp3d->no_dp3d,
            'tgl_dp3d' => Carbon::parse($dp3d->created_at)->translatedFormat('d F Y'),

            'no_sprin_riksa' => $sprin->no_sprin,
            'tgl_sprin_riksa' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
        ));

        $filename = "$kasus->pelapor - Surat Pelimpahan Ke Ankum.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }


    //Sidang Disiplin
    public function nota_dina_perangkat_sidang($kasus_id, $process_id, $subprocess){
        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $process_id,
                'sub_process_id' => $subprocess,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $template_document = new TemplateProcessor(storage_path('template/template_perangkat_sidang.docx'));
        $filename = 'Nota Dinas Perangkat Sidang'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function sprin_perangkat_sidang(Request $request, $kasus_id){
        if($request->method() != 'GET'){
            $this->validate($request, [
                'no_sprin' => 'required',
                'tgl_sidang' => 'required',
                'waktu_sidang' => 'required',
                'lokasi_sidang' => 'required',
                'no_nd_rehabpers' => 'required',
                'tgl_nd_rehabpers' => 'required'
            ], [
                'no_sprin' => 'Kolom No. SPRIN wajib diisi',
                'tgl_sidang' => 'Kolom Tanggal Pelaksanaan Sidang wajib diisi',
                'waktu_sidang' => 'Kolom Waktu Pelaksanaan Sidang wajib diisi',
                'lokasi_sidang' => 'Kolom Tempat Pelaksanaan Sidang wajib diisi',
                'no_nd_rehabpers' => 'Kolom Nomor Nota Dinas Bag. Rehabpers wajib diisi',
                'tgl_nd_rehabpers' => 'Kolom Tanggal Nota Dinas Bag. Rehabpers wajib diisi'
            ]);
        }

        DB::beginTransaction();
        try {
            $kasus = DataPelanggar::find($kasus_id);
            $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'sidang')->first();
            $dp3d = DP3D::where('data_pelanggar_id', $kasus_id)->first();
            $sidang = SidangDisiplin::where('data_pelanggar_id', $kasus_id)->first();

            if ($sprinHistory == null){
                $sprinHistory = SprinHistory::create([
                    'data_pelanggar_id' => $kasus_id,
                    'no_sprin' => $request->no_sprin,
                    'created_by' => Auth::user()->id,
                    'type' => 'sidang',
                    'no_nd_rehabpers' => $request->no_nd_rehabpers,
                    'tgl_nd_rehabpers' => $request->tgl_nd_rehabpers,
                ]);


                $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
                if($dokumen == null){
                    DokumenPelanggar::create([
                        'data_pelanggar_id' => $kasus_id,
                        'process_id' => $request->process_id,
                        'sub_process_id' => $request->sub_process,
                        'created_by' => Auth::user()->id,
                        'status' => 1
                    ]);
                }

                if($sidang == null){
                    $sidang = SidangDisiplin::create([
                        'data_pelanggar_id' => $kasus_id,
                        'tgl_sidang' => $request->tgl_sidang,
                        'waktu_sidang' => $request->waktu_sidang,
                        'lokasi_sidang' => $request->lokasi_sidang
                    ]);
                }
            }


            $template_document = new TemplateProcessor(storage_path('template/template_perangkat_sidang.docx'));

            $template_document->setValues(array(
                'no_sprin' => $request->no_sprin != '' ? $request->no_sprin : $sprinHistory->no_sprin,
                'terlapor' => strtoupper($kasus->terlapor),
                'pangkat' => strtoupper($kasus->pangkatName->name),
                'nrp' => $kasus->nrp,
                'jabatan' => strtoupper($kasus->jabatan.' '.$kasus->kesatuan),
                'tgl_sidang' => Carbon::parse($request->tgl_sidang != '' ? $request->tgl_sidang : $sidang->tgl_sidang)->translatedFormat('d F Y'),
                'waktu_sidang' => $request->waktu_sidang != '' ? $request->waktu_sidang : Carbon::parse($sidang->waktu_sidang)->translatedFormat('H:i'),
                'ruang_sidang' => $request->lokasi_sidang != '' ? $request->lokasi_sidang : $sidang->lokasi_sidang,
                'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
                'no_dp3d' => $dp3d->no_dp3d,
                'tgl_dp3d' => Carbon::parse($dp3d->created_at)->translatedFormat('d F Y'),
                'no_nd_rehabpers' => $request->no_nd_rehabpers != '' ? $request->no_nd_rehabpers : $sprinHistory->no_nd_rehabpers,
                'tgl_nd_rehabpers' => Carbon::parse($request->tgl_nd_rehabpers != '' ? $request->tgl_nd_rehabpers : $sprinHistory->tgl_nd_rehabpers)->translatedFormat('d F Y'),
            ));

            $filename = $kasus->pelapor.' - SPRIN Perangkat Sidang'.'.docx';
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            DB::commit();
            if ($request->method() == 'GET'){
                return response()->download($path)->deleteFileAfterSend(true);
            } else {
                return response()->json(['file' => $filename]);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function undangan_sidang_disiplin(Request $request, $kasus_id){
        $kasus = DataPelanggar::find($kasus_id);
        $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'sidang')->first();
        $saksi = Witness::where('data_pelanggar_id', $kasus_id)->get();
        $saksiUmum = PublicWitness::where('data_pelanggar_id', $kasus_id)->get();
        $undanganSaksi = array();

        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $kasus_id,
                'process_id' => $request->process_id,
                'sub_process_id' => $request->sub_process,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $template_document = new TemplateProcessor(storage_path('template/template_undangan_sidang.docx'));
        $template_document->setValues(array(
            'tgl_ttd' => Carbon::now()->translatedFormat('d F Y'),
            'hari' => Carbon::parse($request->tgl)->translatedFormat('l'),
            'tgl' => Carbon::parse($request->tgl)->translatedFormat('d F Y'),
            'jam' => Carbon::parse($request->jam)->translatedFormat('H:i'),
            'lokasi' => $request->lokasi,
            'terlapor' => strtoupper($kasus->terlapor),
            'pangkat' => strtoupper($kasus->pangkatName->name),
            'nrp' => $kasus->nrp,
            'jabatan' => strtoupper($kasus->jabatan),
            'kesatuan' => strtoupper($kasus->kesatuan),
            'no_sprin' => $sprinHistory->no_sprin,
            'tgl_sprin' => Carbon::parse($sprinHistory->crated_at)->translatedFormat('d F Y')
        ));

        $filenameTerlapor = $kasus->pelapor.' - Surat Undangan Sidang Disiplin'.'.docx';
        $path = storage_path('document/'.$filenameTerlapor);
        $template_document->saveAs($path);

        // Undangan Saksi
        foreach ($saksi as $val) {
            $template_saksi = new TemplateProcessor(storage_path('template/template_undangan_saksi_polisi_sidang.docx'));
            $template_saksi->setValues(array(
                'tgl_ttd' => Carbon::now()->translatedFormat('d F Y'),
                'hari' => Carbon::parse($request->tgl)->translatedFormat('l'),
                'tgl' => Carbon::parse($request->tgl)->translatedFormat('d F Y'),
                'jam' => $request->jam,
                'lokasi' => $request->lokasi,
                'terlapor' => strtoupper($kasus->terlapor),
                'pangkat' => strtoupper($kasus->pangkatName->name),
                'nrp' => $kasus->nrp,
                'jabatan' => strtoupper($kasus->jabatan),
                'kesatuan' => strtoupper($kasus->kesatuan),
                'no_sprin' => $sprinHistory->no_sprin,
                'tgl_sprin' => Carbon::parse($sprinHistory->crated_at)->translatedFormat('d F Y'),
                'saksi' => $val->nama,
                'pangkat_saksi' => $val->pangkat,
            ));
            $filename = $kasus->pelapor.' - Surat Undangan Sidang Disiplin (Saksi - '.$val->pangkat.' '.$val->nama.').docx';
            $path = storage_path('document/'.$filename);
            $template_saksi->saveAs($path);
            array_push($undanganSaksi, $filename);
        }

        foreach ($saksiUmum as $val) {
            $template_saksi = new TemplateProcessor(storage_path('template/template_undangan_saksi_sidang.docx'));
            $template_saksi->setValues(array(
                'tgl_ttd' => Carbon::now()->translatedFormat('d F Y'),
                'hari' => Carbon::parse($request->tgl)->translatedFormat('l'),
                'tgl' => Carbon::parse($request->tgl)->translatedFormat('d F Y'),
                'jam' => $request->jam,
                'lokasi' => $request->lokasi,
                'terlapor' => strtoupper($kasus->terlapor),
                'pangkat' => strtoupper($kasus->pangkatName->name),
                'nrp' => $kasus->nrp,
                'jabatan' => strtoupper($kasus->jabatan),
                'kesatuan' => strtoupper($kasus->kesatuan),
                'no_sprin' => $sprinHistory->no_sprin,
                'tgl_sprin' => Carbon::parse($sprinHistory->crated_at)->translatedFormat('d F Y'),
                'saksi' => $val->nama,
                'alamat' => $val->alamat
            ));
            $filename = $kasus->pelapor.' - Surat Undangan Sidang Disiplin (Saksi - '.$val->nama.').docx';
            $path = storage_path('document/'.$filename);
            $template_saksi->saveAs($path);
            array_push($undanganSaksi, $filename);
        }

        return response()->json(['file' => $filenameTerlapor, 'file_undangan_saksi' => $undanganSaksi]);
    }

    public function hasil_putusan_sidang_disiplin(Request $request, $kasus_id){
        $this->validate($request, [
            'hasil_sidang' => 'required',
            'hukuman' => 'required'
        ],[
            'hasil_sidang' => 'Kolom Hasil Putusan Sidang wajib diisi',
            'hukuman' => 'Kolom Hukuman Disiplin wajib diisi'
        ]);
        DB::beginTransaction();
        try {
            //code...
            $kasus = DataPelanggar::find($kasus_id);
            $dp3d = DP3D::where('data_pelanggar_id', $kasus_id)->first();
            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();

            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            $hukuman = '';
            for ($i=0; $i < count($request->hukuman); $i++) {
                $hukuman .= $request->hukuman[$i].',';
            }
            $hukuman = rtrim($hukuman, ',');

            $sidang = SidangDisiplin::where('data_pelanggar_id', $kasus_id)->first();
            $sidang->hasil_sidang = $request->hasil_sidang;
            $sidang->hukuman_disiplin = $hukuman;
            $sidang->save();

            $kasus->status_id = 8;
            $kasus->save();

            $template_document = new TemplateProcessor(storage_path('template/template_hasil_putusan_sidang.docx'));
            $template_document->cloneRow('no', count($request->hukuman));

            for ($i=0; $i < count($request->hukuman); $i++) {
                $template_document->setValues(array(
                    'no#'.$i+1 => '-',
                    'jenis_hukuman#'.$i+1 => $request->hukuman[$i],
                ));
            }

            $template_document->setValues(array(
                'tgl_ttd' => Carbon::now()->translatedFormat('l'). ', '.Carbon::now()->translatedFormat('d F Y'),
                'no_dp3d' => $dp3d->no_dp3d,
                'tgl_dp3d' => Carbon::parse($dp3d->created_at)->translatedFormat('d F Y'),
                'terlapor' => strtoupper($kasus->terlapor),
                'pangkat' => strtoupper($kasus->pangkatName->name),
                'nrp' => $kasus->nrp,
                'jabatan' => strtoupper($kasus->jabatan),
                'kesatuan' => strtoupper($kasus->kesatuan),
                'kronologi' => $kasus->kronologi,
                'pasal' => $dp3d->pasal,
                'hari_sidang' => Carbon::parse($sidang->tgl_sidang)->translatedFormat('l'),
                'tgl_sidang' => Carbon::parse($sidang->tgl_sidang)->translatedFormat('d F Y'),
                'hasil_sidang' => $request->hasil_sidang,
                // 'jenis_hukuman' => $request->hukuman
            ));

            $filename = $kasus->pelapor.' - Hasil Putusan Sidang Disiplin'.'.docx';
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            DB::commit();
            return response()->json(['file' => $filename]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => [
                    'code' => 500,
                    'msg' => 'terjadi masalah saat generate document'
                ],
                'detail' => $th,
                'kasus' => null,
                'document_data' => null
            ], 500);
        }
    }

    public function nota_hasil_putusan($data, $request){
        $template_document = new TemplateProcessor(storage_path('template/template_nota_hasil_putusan.docx'));

        $total = count($data) > 1 ? (int)count($data)-1 : 0;
        $total_text = dateToWord($total);

        $yearStart = explode('-', $request->month_start)[0];
        $monthStart = explode('-', $request->month_start)[1];
        $yearEnd = explode('-', $request->month_end)[0];
        $monthEnd = explode('-', $request->month_end)[1];

        $monthStartString = Carbon::create()->day(1)->month($monthStart)->translatedFormat('F');
        $monthEndString = Carbon::create()->day(1)->month($monthEnd)->translatedFormat('F');

        $template_document->setValues(array(
            'pangkat_0' => $data[0]->pangkatName->name,
            'nama_0' => $data[0]->terlapor,
            'total' => $total,
            'total_text' => $total_text,
            'month_start' => $monthStartString,
            'year_start' => $yearStart == $yearEnd ? '' : $yearStart,
            'month_end' => $monthEndString,
            'year_end' => $yearEnd
        ));

        $template_document->cloneBlock('terlapor_section', count($data),true,true);
        foreach ($data as $i => $val) {
            $template_document->setValues(array(
                "pangkat#".$i+1 => strtoupper($val->pangkatName->name),
                'nama#'.$i+1 => strtoupper($val->terlapor),
                'nrp#'.$i+1 => strtoupper($val->nrp),
                'jabatan#'.$i+1 => strtoupper($val->jabatan),
                'kesatuan#'.$i+1 => strtoupper($val->kesatuan),
            ));
        }

        $filename = 'Nota Hasil Putusan Sidang periode'.$monthStartString.' - '.$monthEndString.' '.$yearEnd.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return $filename;
    }
}
