<?php

namespace App\Http\Controllers;

use App\Models\Agama;
use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\GelarPerkara;
use App\Models\LPA;
use App\Models\Penyidik;
use App\Models\PublicWitness;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use App\Models\Witness;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $kasus = DataPelanggar::find($request->kasus_id);

        $data = [
            'tanggal' => $request->tanggal,
            'surat_dati' => $request->surat_dari,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $kasus->perihal_nota_dinas,
            'nomor_agenda' => $request->nomor_agenda
        ];

        $filename = $kasus->pelapor.' - Lembar Disposisi';
        $path = storage_path('document/'.$filename.'.docx');
        $template = new TemplateProcessor(storage_path('template/template disposisi.docx'));

        $template->setValue('no_surat', $data['nomor_surat']);
        $template->setValue('no_agenda', $data['nomor_agenda']);
        $template->setValue('surat_dati', $data['surat_dati']);
        $template->setValue('tanggal', $data['tanggal']);
        $template->setValue('perihal', $data['perihal']);

        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', null)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $request->kasus_id,
                'process_id' => 2,
                'sub_process_id' => null,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $data = DataPelanggar::find($request->kasus_id);
        if($data->status_id < 2){
            $data->status_id = 2;
            $data->save();
        }

        $template->saveAs($path);
        return response()->json(['file' => $filename.'.docx']);

        // Convert PDF (Kalau butuh nanti)
        // $pdfPath = storage_path('app/public/document/disposisi/');
        // $convert='"C:/Program Files/LibreOffice/program/soffice" --headless --convert-to pdf "'.$path.'" --outdir "'.$pdfPath.'"';
        // $result=exec($convert);
    }

    public function generateDisposisiKaro(Request $request){
        $kasus = DataPelanggar::find($request->kasus_id);

        $data = [
            'tanggal' => $request->tanggal,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $kasus->perihal_nota_dinas
        ];

        $filename = "$kasus->pelapor - Lembar Disposisi Karo";
        $path = storage_path('document/'.$filename.'.docx');
        $template = new TemplateProcessor(storage_path('template/template_disposisi_karo.docx'));

        $template->setValue('no_surat', $data['nomor_surat']);
        $template->setValue('tanggal', $data['tanggal']);
        $template->setValue('perihal', $data['perihal']);

        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', null)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $request->kasus_id,
                'process_id' => 2,
                'sub_process_id' => null,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $template->saveAs($path);
        return response()->json(['file' => $filename.'.docx']);
    }

    public function generateDisposisiSesro(Request $request){
        $kasus = DataPelanggar::find($request->kasus_id);

        $data = [
            'tanggal' => $request->tanggal,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $kasus->perihal_nota_dinas
        ];

        $filename = "$kasus->pelapor - Lembar Disposisi Sesro";
        $path = storage_path('document/'.$filename.'.docx');
        $template = new TemplateProcessor(storage_path('template/template_disposisi_sesro.docx'));

        $template->setValue('no_surat', $data['nomor_surat']);
        $template->setValue('tanggal', $data['tanggal']);
        $template->setValue('perihal', $data['perihal']);

        $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', null)->first();
        if($dokumen == null){
            DokumenPelanggar::create([
                'data_pelanggar_id' => $request->kasus_id,
                'process_id' => 2,
                'sub_process_id' => null,
                'created_by' => Auth::user()->id,
                'status' => 1
            ]);
        }

        $template->saveAs($path);
        return response()->json(['file' => $filename.'.docx']);
    }

    public function generateDisposisiKabag($kasus_id, $process_id, $subprocess){
        $kasus = DataPelanggar::find($kasus_id);

        $template_document = new TemplateProcessor(storage_path('template\template_disposisi_kabag.docx'));
        $template_document->setValues(array(
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y')
        ));

        $filename = "$kasus->pelapor - Surat Pengantar Disposisi Kabag";
        $path = storage_path('document/'.$filename.'.docx');
        $template_document->saveAs($path);
        return response()->download($path)->deleteFileAfterSend(true);

    }

    // Document Pulbaket
    public function SuratPerintah(Request $request, $kasus_id)
    {
        $kasus = DataPelanggar::find($kasus_id);
        $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
        $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->get();
        if ($sprinHistory == null){
            $sprinHistory = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_sprin' => $request->no_sprin,
                'created_by' => Auth::user()->id,
                'type' => 'lidik'
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

        $template_document = new TemplateProcessor(storage_path('template\template_sprin.docx'));
        if (count($penyelidik) == 0){
            for ($i=0; $i < count($request->nama); $i++) {
                Penyidik::create([
                    'data_pelanggar_id' => $kasus_id,
                    'name' => strtoupper($request->nama[$i]),
                    'nrp' => $request->nrp[$i],
                    'pangkat' => strtoupper($request->pangkat[$i]),
                    'jabatan' => strtoupper($request->jabatan[$i]),
                    'kesatuan' => strtoupper($request->kesatuan[$i]),
                    'type' => 'lidik'
                ]);
            }

            $template_document->cloneRow('pangkat_penyelidik', count($request->jabatan));

            for ($i=0; $i < count($request->jabatan); $i++) {
                $template_document->setValues(array(
                    "no#".$i+1 => $i+1,
                    'pangkat_penyelidik#'.$i+1 => strtoupper($request->pangkat[$i]),
                    'jabatan_penyelidik#'.$i+1 => strtoupper($request->jabatan[$i]),
                    'nama_penyelidik#'.$i+1 => strtoupper($request->nama[$i]),
                    'kesatuan_penyelidik#'.$i+1 => strtoupper($request->kesatuan[$i]),
                    'nrp_penyelidik#'.$i+1 => $request->nrp[$i]
                ));
            }
        } else {
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
        }

        $template_document->setValues(array(
            'no_nd' => $kasus->no_nota_dinas,
            'tgl_nd' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'perihal_nd' => $kasus->perihal_nota_dinas,
            'pelapor' => $kasus->pelapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'pangkat' => $kasus->pangkat,
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
    }

    public function SuratPerintahPengantar($kasus_id){
        $kasus = DataPelanggar::find($kasus_id);

        $template_document = new TemplateProcessor(storage_path('template\pengantar_sprin.docx'));
        $template_document->setValues(array(
            'nrp' => $kasus->no_pengaduan,
            'tgl_nd' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'kronologi' => $kasus->kronologi,
            'pangkat' => $kasus->pangkat,
            'terlapor' => $kasus->terlapor,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y')
        ));

        $filename = "$kasus->pelapor - Pengantar SPRIN Lidik";
        $path = storage_path('document/'.$filename.'.docx');
        $template_document->saveAs($path);
        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function undangan_klarifikasi(Request $request, $kasus_id){
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
        $penyidik = Penyidik::find($request->penyidik);

        $template_document = new TemplateProcessor(storage_path('template\template_undangan_klarifikasi.docx'));
        $template_document->setValues(array(
            'no' => $request->no_undangan,
            'create_date' => Carbon::now()->translatedFormat('d F Y'),
            'pangkat' => strtoupper($kasus->pangkat),
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

        return response()->json(['file' => $filename]);
        // return response()->download($path)->deleteFileAfterSend(true);
    }

    public function bai(Request $request, $kasus_id){
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
        $penyidik2 = Penyidik::where('id', $request->penyidik2)->where('data_pelanggar_id', $kasus_id)->first();
        $dataSaksi = Witness::where('data_pelanggar_id', $kasus_id)->get();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();

        $file = array();
        $kasus = DataPelanggar::find($kasus_id);

        if (count($dataSaksi) == 0){
            for ($i=0; $i < count($request->nama) ; $i++) {
                $template_document = new TemplateProcessor(storage_path('template\template_bai.docx'));
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
                    'pangkat' => strtoupper($kasus->pangkat),
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
                $template_document = new TemplateProcessor(storage_path('template\template_bai.docx'));
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
                    'pangkat' => strtoupper($kasus->pangkat),
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

        return response()->json(['file' => $file]);
    }

    public function laporanHasilPenyelidikan($kasus_id, $process_id, $subprocess){
        return redirect()->back()->with('msg', 'Proses cetak Laporan Hasil Penyelidikan sedang dalam pengerjaan');

        // $kasus = DataPelanggar::find($kasus_id);
        // $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        // $template_document = new TemplateProcessor(storage_path('template\lhp.docx'));

        // $template_document->setValues(array(
        //     'no_nota_dinas' => $kasus->no_nota_dinas,
        //     'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
        //     'pangkat' => $kasus->pangkat,
        //     'jabatan' => $kasus->jabatan,
        //     'kwn' => $kasus->kewarganegaraan,
        //     'terlapor' => $kasus->terlapor,
        //     'wujud_perbuatan' => $kasus->wujud_perbuatan,
        //     'terlapor' => $kasus->terlapor,
        //     'nrp' => $kasus->nrp,
        //     'jabatan' => $kasus->jabatan,
        //     'kesatuan' => $kasus->kesatuan,
        //     'pelapor' => $kasus->pelapor,
        //     'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        // ));

        // $filename = 'Dokumen LHP'.'.docx';
        // $path = storage_path('document/'.$filename);
        // $template_document->saveAs($path);

        // // $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        // // if($dokumen == null){
        // //     DokumenPelanggar::create([
        // //         'data_pelanggar_id' => $kasus_id,
        // //         'process_id' => $process_id,
        // //         'sub_process_id' => $subprocess,
        // //         'created_by' => Auth::user()->id,
        // //         'status' => 1
        // //     ]);
        // // }

        // return response()->download($path)->deleteFileAfterSend(true);
    }

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

        $template_document = new TemplateProcessor(storage_path('template\template_nd_gelar_perkara.docx'));
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

        $template_document = new TemplateProcessor(storage_path('template\template_sprin_gelar_perkara.docx'));
        $template_document->setValues(array(
            'no_sprin' => $no_sprin != '' ? $no_sprin : $sprinHistory->no_sprin,
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            'hari' => $hari,
            'tgl' => $tgl
        ));

        $filename = "$kasus->pelapor - SPRIN Gelar Perkara.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);
        if ($request->method() == 'GET'){
            return response()->download($path)->deleteFileAfterSend(true);
        } else {
            return response()->json(['file' => $filename]);
        }
    }

    public function berkas_undangan_gelar(Request $request, $kasus_id){
        $hari = Carbon::parse($request->tgl)->translatedFormat('l');
        $tgl = Carbon::parse($request->tgl)->translatedFormat('d F Y');
        $kasus = DataPelanggar::find($kasus_id);

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

        $template_document = new TemplateProcessor(storage_path('template\undangan_gelar.docx'));
        $template_document->setValues(array(
            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            'hari' => $hari,
            'tgl' => $tgl,
            'jam' => $request->jam,
            'tempat' => $request->tempat,
            'pimpinan' => $request->pimpinan
        ));

        $filename = "$kasus->pelapor - Undangan Gelar Perkara.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);
        return response()->json(['file' => $filename]);
    }

    public function notulen_hasil_gelar($kasus_id, $process_id, $subprocess){
        return redirect()->back()->with('msg', 'Proses cetak Notulen Hasil Gelar sedang dalam pengerjaan');
    }

    public function laporan_hasil_gelar(Request $request, $kasus_id){
        $dataPelanggaran = DataPelanggar::where('id', $kasus_id)->first();
        $sprinLidik = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
        $sprinGelar = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'gelar')->first();

        $pimpinan = Penyidik::where('id', $request->pimpinan)->where('data_pelanggar_id', $kasus_id)->first();
        $pemapar = Penyidik::where('id', $request->pemapar)->where('data_pelanggar_id', $kasus_id)->first();
        $notulen = Penyidik::where('id', $request->notulen)->where('data_pelanggar_id', $kasus_id)->first();
        $operator = Penyidik::where('id', $request->operator)->where('data_pelanggar_id', $kasus_id)->first();

        $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $kasus_id)->first();
        $gelarPerkara->pemapar = $request->pemapar;
        $gelarPerkara->notulen = $request->notulen;
        $gelarPerkara->operator = $request->operator;
        $gelarPerkara->hasil_gelar = $request->hasil_gp;
        $gelarPerkara->keterangan_hasil = $request->keterangan;
        $gelarPerkara->landasan_hukum = $request->landasan_hukum;
        $gelarPerkara->save();

        $template_document = new TemplateProcessor(storage_path('template\template_lap_hasil_gp.docx'));

        $template_document->setValues(array(
            'no_nd' => $dataPelanggaran->no_nota_dinas,
            'tgl_nd' => Carbon::parse($dataPelanggaran->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'no_sprin_lidik' => $sprinLidik->no_sprin,
            'tgl_sprin_lidik' => Carbon::parse($sprinLidik->created_at)->translatedFormat('d F Y'),
            'pangkat_pimpinan' => strtoupper($pimpinan->pangkat),
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
            'wujud_perbuatan' => $dataPelanggaran->wujud_perbuatan,
            'landasan_hukum' => $request->landasan_hukum,
            'tindak_lanjut' => $request->tindak_lanjut,

            'pangkat_terlapor' => strtoupper($dataPelanggaran->pangkat),
            'nama_terlapor' => strtoupper($dataPelanggaran->terlapor),
            'jabatan_terlapor' => strtoupper($dataPelanggaran->jabatan),
            'kesatuan_terlapor' => strtoupper($dataPelanggaran->kesatuan),

            'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
        ));

        $filename = "$dataPelanggaran->pelapor - Dokumen Laporan Hasil Gelar Perkara.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

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
        // return response()->download($path)->deleteFileAfterSend(true);
    }

    public function sp2hp($kasus_id, $process_id, $subprocess){
        $dataPelanggaran = DataPelanggar::where('id', $kasus_id)->first();
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'lidik')->first();
        $sprinGelar = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'gelar')->first();
        $jk = $dataPelanggaran->jenis_kelamin == 1 ? 'Sdr' : 'Sdri';

        $template_document = new TemplateProcessor(storage_path('template\template_sp2hp.docx'));
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

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function limpah_polda(Request $request){
        (new KasusController())->updateData($request);

        if ($request->next == 'limpah'){
            $kasus = DataPelanggar::find($request->kasus_id);
            $gelarPerkara = GelarPerkara::where('data_pelanggar_id', $request->kasus_id)->with(['penyidik', 'pemapar', 'operator', 'notulen'])->first();
            $sprin = SprinHistory::where('data_pelanggar_id', $request->kasus_id)->where('type', 'lidik')->first();

            $template_document = new TemplateProcessor(storage_path('template\template_limpah.docx'));
            $template_document->setValues(array(
                'no_nd' => $kasus->no_nota_dinas,
                'tgl_nd' => Carbon::parse($kasus->tangal_nota_dinas)->translatedFormat('d F Y'),
                'sprin_lidik' => $sprin->no_sprin,
                'tgl_sprin_lidik' => Carbon::parse($sprin->created_at)->translatedFormat('d F Y'),
                'tgl_hasil_gp' => Carbon::parse($gelarPerkara->updated_at)->translatedFormat('d F Y'),
                'perihal' => $kasus->perihal_nota_dinas,
                'pangkat' => strtoupper($kasus->pangkat),
                'terlapor' => strtoupper($kasus->terlapor),
                'jabatan' => strtoupper($kasus->jabatan),
                'kesatuan' => strtoupper($kasus->kesatuan),
                'lokasi_gp' => $gelarPerkara->tempat_pelaksanaan,
                'pimpinan_gp' => strtoupper($gelarPerkara->penyidik->pangkat).' '.strtoupper($gelarPerkara->penyidik->name),
                'jabatan_gp' => strtoupper($gelarPerkara->penyidik->jabatan).' '.strtoupper($gelarPerkara->penyidik->kesatuan),
                'keterangan_hasil' => $gelarPerkara->keterangan_hasil,
                'pelapor' => $kasus->nama_korban,
                'landasan_hukum' => $gelarPerkara->landasan_hukum,
                'tgl_ttd' => Carbon::now()->translatedFormat('F Y'),
            ));

            $dokumen = DokumenPelanggar::where('data_pelanggar_id', $request->kasus_id)->where('process_id', $request->process_id)->where('sub_process_id', $request->sub_process)->first();
            if($dokumen == null){
                DokumenPelanggar::create([
                    'data_pelanggar_id' => $request->kasus_id,
                    'process_id' => $request->process_id,
                    'sub_process_id' => $request->sub_process,
                    'created_by' => Auth::user()->id,
                    'status' => 1
                ]);
            }

            $filename = "$kasus->pelapor - Surat Limpah.docx";
            $path = storage_path('document/'.$filename);
            $template_document->saveAs($path);

            return response()->json(['file' => $filename]);
            // return response()->download($path)->deleteFileAfterSend(true);
        }
    }

    // End of Document Gelar Lidik


    // Sidik / LPA
    public function lpa(Request $request, $kasus_id){
        $kasus = DataPelanggar::find($kasus_id);

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

        $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();
        if ($lpa == null){
            LPA::create([
                'data_pelanggar_id' => $kasus_id,
                'no_lpa' => $request->no_lpa,
                'created_by' => Auth::user()->id,
            ]);
        }

        $template_document = new TemplateProcessor(storage_path('template\template_lpa.docx'));
        $template_document->setValues(array(
            'no_laporan' => $request->no_lpa
        ));

        $filename = "$kasus->pelapor - LPA.docx";
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function sprin_riksa(Request $request, $kasus_id){
        $kasus = DataPelanggar::find($kasus_id);
        $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->first();
        $penyelidik = Penyidik::where('data_pelanggar_id', $kasus_id)->where('type', 'riksa')->get();

        $lpa = LPA::where('data_pelanggar_id', $kasus_id)->first();

        if ($sprinHistory == null){
            $sprinHistory = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                'no_sprin' => $request->no_sprin,
                'created_by' => Auth::user()->id,
                'type' => 'riksa'
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

        $template_document = new TemplateProcessor(storage_path('template\template_sprin_riksa.docx'));
        if (count($penyelidik) == 0){
            for ($i=0; $i < count($request->nama); $i++) {
                Penyidik::create([
                    'data_pelanggar_id' => $kasus_id,
                    'name' => strtoupper($request->nama[$i]),
                    'nrp' => $request->nrp[$i],
                    'pangkat' => strtoupper($request->pangkat[$i]),
                    'jabatan' => strtoupper($request->jabatan[$i]),
                    'kesatuan' => strtoupper($request->kesatuan[$i]),
                    'type' => 'riksa'
                ]);
            }

            $template_document->cloneRow('pangkat_penyelidik', count($request->jabatan));

            for ($i=0; $i < count($request->jabatan); $i++) {
                $template_document->setValues(array(
                    "no#".$i+1 => $i+1,
                    'pangkat_penyelidik#'.$i+1 => strtoupper($request->pangkat[$i]),
                    'jabatan_penyelidik#'.$i+1 => strtoupper($request->jabatan[$i]),
                    'nama_penyelidik#'.$i+1 => strtoupper($request->nama[$i]),
                    'kesatuan_penyelidik#'.$i+1 => strtoupper($request->kesatuan[$i]),
                    'nrp_penyelidik#'.$i+1 => $request->nrp[$i]
                ));
            }
        } else {
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
        }

        $template_document->setValues(array(
            'no_lpa' => $lpa->no_lpa,
            'tgl_lpa' => Carbon::parse($lpa->created_at)->translatedFormat('d F Y'),
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'pangkat' => $kasus->pangkat,
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
    }

    public function surat_panggilan_saksi(Request $request, $kasus_id){
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
            for ($i=0; $i < count($request->nama) ; $i++) {
                $template_document = new TemplateProcessor(storage_path('template\template_surat_panggilan_saksi.docx'));
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
                    // Data Kasus
                    'terlapor' => strtoupper($kasus->pangkat).' '.strtoupper($kasus->terlapor),
                    'jabatan' => strtoupper($kasus->jabatan).' '.strtoupper($kasus->kesatuan),
                    'wujud_perbuatan' => strtoupper($kasus->wujud_perbuatan),
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
                $agama = Agama::where('id', $saksi->agama)->first();
                $template_document = new TemplateProcessor(storage_path('template\template_surat_panggilan_saksi.docx'));
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
                    // Data Kasus
                    'terlapor' => strtoupper($kasus->pangkat).' '.strtoupper($kasus->terlapor),
                    'jabatan' => strtoupper($kasus->jabatan).' '.strtoupper($kasus->kesatuan),
                    'wujud_perbuatan' => strtoupper($kasus->wujud_perbuatan),
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

    public function surat_panggilan_terduga($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_surat_panggilan_terduga.docx'));
        $filename = 'Surat Panggilan Terduga'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function bap($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_bap.docx'));
        $filename = 'Dokumen BAP'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function dp3d($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_dp3d.docx'));
        $filename = 'Dokumen DP3D'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function pelimpahan_ankum($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_pelimpahan_ankum.docx'));
        $filename = 'Surat Pelimpahan Ke Ankum'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }


    //Sidang Disiplin
    public function nota_dina_perangkat_sidang($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_perangkat_sidang.docx'));
        $filename = 'Nota Dinas Perangkat Sidang'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function sprin_perangkat_sidang($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_perangkat_sidang.docx'));
        $filename = 'SPRIN Perangkat Sidang'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function undangan_sidang_disiplin($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_undangan_sidang.docx'));
        $filename = 'Surat Undangan Sidang Disiplin'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function hasil_putusan_sidang_disiplin($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_hasil_putusan_sidang.docx'));
        $filename = 'Hasil Putusan Sidang Disiplin'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function nota_hasil_putusan($kasus_id, $process_id, $subprocess){
        $template_document = new TemplateProcessor(storage_path('template\template_nota_hasil_putusan.docx'));
        $filename = 'Nota Hasil Putusan Sidang'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
