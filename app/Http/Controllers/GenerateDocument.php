<?php

namespace App\Http\Controllers;

use App\Models\DataPelanggar;
use App\Models\DokumenPelanggar;
use App\Models\Sp2hp2History;
use App\Models\SprinHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;

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
        $data = [
            'tanggal' => $request->tanggal,
            'surat_dati' => $request->surat_dari,
            'nomor_surat' => $request->nomor_surat,
            'perihal' => $request->perihal,
            'nomor_agenda' => $request->nomor_agenda
        ];
        $filename = 'disposisi-'.$data['nomor_surat'].'-'.$data['tanggal'];
        $path = storage_path('document/'.$filename.'.docx');
        $template = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template/template disposisi.docx'));

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

        DokumenPelanggar::create([
            'data_pelanggar_id' => $request->kasus_id,
            'process_id' => 2,
            'sub_process_id' => 1,
            'created_by' => Auth::user()->id,
            'status' => 1
        ]);
    }

    public function generateDisposisiRikum(Request $request){
        DokumenPelanggar::create([
            'data_pelanggar_id' => $request->kasus_id,
            'process_id' => 2,
            'sub_process_id' => 2,
            'created_by' => Auth::user()->id,
            'status' => 1
        ]);
    }

    public function SuratPerintah(Request $request, $kasus_id, $generated){
        $kasus = DataPelanggar::find($kasus_id);
        $sprinHistory = SprinHistory::where('data_pelanggar_id', $kasus_id)->first();
        if ($sprinHistory == null){
            $sprinHistory = SprinHistory::create([
                'data_pelanggar_id' => $kasus_id,
                // 'isi_surat_perintah' => $request->isi_surat_perintah,
                'created_by' => Auth::user()->id,
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

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template\template_sprin.docx'));
        $template_document->setValues(array(
            // 'bulan' => date('F', strtotime($sprinHistory->created_at)),
            // 'isi_surat_perintah' => $sprinHistory->isi_surat_perintah,
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'kesatuan' => $kasus->kesatuan,
            'tanggal_ttd' => Carbon::parse($sprinHistory->created_at)->translatedFormat('F Y')
        ));

        $filename = 'Surat Perintah'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        if ($generated == 'generated'){
            return response()->download($path)->deleteFileAfterSend(true);
        } else {
            return response()->json(['file' => $filename]);
        }

    }

    public function SuratPerintahPengantar($kasus_id){
        $kasus = DataPelanggar::find($kasus_id);

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template\pengantar_sprin.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
        ));

        $filename = 'Surat Pengantar SPRIN-'.$kasus_id;
        $path = storage_path('document/'.$filename.'.docx');
        $template_document->saveAs($path);
        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function printUUK($kasus_id, $process_id, $subprocess){
        $kasus = DataPelanggar::find($kasus_id);
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

        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template\template_uuk.docx'));
        $template_document->setValues(array(
            'nama' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'tanggal' => Carbon::parse($dokumen->created_at)->translatedFormat('F Y'),
            'kronologi' => $kasus->kronologi
        ));

        $filename = 'Surat UUK'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function sp2hp_awal(Request $request, $kasus_id, $generated){
        $kasus = DataPelanggar::find($kasus_id);
        $sp2hp2 = Sp2hp2History::where('data_pelanggar_id', $kasus_id)->first();
        if (!$sp2hp2){
            $sp2hp2 = Sp2hp2History::create([
                'data_pelanggar_id' => $kasus_id,
                'penangan' => $request->penangan,
                'dihubungi' => $request->dihubungi,
                'jabatan_dihubungi' => $request->jabatan_dihubungi,
                'telp_dihubungi' => $request->telp_dihubungi,
                'created_by' => Auth::user()->id,
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
        $template_document = new \PhpOffice\PhpWord\TemplateProcessor(storage_path('template\sp2hp2_awal.docx'));

        $template_document->setValues(array(
            'penangan' => $sp2hp2->penangan,
            'dihubungi' => $sp2hp2->dihubungi,
            'jabatan_dihubungi' => $sp2hp2->jabatan_dihubungi,
            'telp_dihubungi' => $sp2hp2->telp_dihubungi,
            'pelapor' => $kasus->pelapor,
            'alamat' => $kasus->alamat,
            'bulan_tahun' => Carbon::parse($sp2hp2->created_at)->translatedFormat('F Y'),
            'tanggal' => Carbon::parse($kasus->created_at)->translatedFormat('d F Y'),
            'no_nota_dinas' => $kasus->no_nota_dinas,
        ));


        $filename = 'Surat SP2HP Awal'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        if ($generated == 'generated'){
            return response()->download($path)->deleteFileAfterSend(true);
        } else {
            return response()->json(['file' => $filename]);
        }
    }

    public function sp2hp2_akhir($kasus_id, $process_id, $subprocess){
        return redirect()->back()->with('msg', 'Proses cetak SP2HP2 akhir sedang dalam pengerjaan');
    }

    public function bai_sipil($kasus_id, $process_id, $subprocess){
        $kasus = DataPelanggar::find($kasus_id);
        $template_document = new TemplateProcessor(storage_path('template\BAI_SIPIL.docx'));

        $template_document->setValues(array(
            'pelapor' => $kasus->pelapor,
            'pekerjaan' => $kasus->pekerjaan,
            'nik' => $kasus->nik,
            'agama' => $kasus->religi->name,
            'alamat' => $kasus->alamat,
            'telp' => $kasus->no_telp,
            'pelapor' => $kasus->pelapor,
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan
        ));

        $filename = 'BAI Sipil'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        // $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        // if($dokumen == null){
        //     DokumenPelanggar::create([
        //         'data_pelanggar_id' => $kasus_id,
        //         'process_id' => $process_id,
        //         'sub_process_id' => $subprocess,
        //         'created_by' => Auth::user()->id,
        //         'status' => 1
        //     ]);
        // }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function bai_anggota($kasus_id, $process_id, $subprocess){
        $kasus = DataPelanggar::find($kasus_id);
        $template_document = new TemplateProcessor(storage_path('template\bai_anggota.docx'));

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
        ));

        $filename = 'BAI Anggota'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        // $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        // if($dokumen == null){
        //     DokumenPelanggar::create([
        //         'data_pelanggar_id' => $kasus_id,
        //         'process_id' => $process_id,
        //         'sub_process_id' => $subprocess,
        //         'created_by' => Auth::user()->id,
        //         'status' => 1
        //     ]);
        // }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function laporanHasilPenyelidikan($kasus_id, $process_id, $subprocess){
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template\lhp.docx'));

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        ));

        $filename = 'Dokumen LHP'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        // $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        // if($dokumen == null){
        //     DokumenPelanggar::create([
        //         'data_pelanggar_id' => $kasus_id,
        //         'process_id' => $process_id,
        //         'sub_process_id' => $subprocess,
        //         'created_by' => Auth::user()->id,
        //         'status' => 1
        //     ]);
        // }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function nd_permohonan_gelar_perkara($kasus_id, $process_id, $subprocess){
        $kasus = DataPelanggar::find($kasus_id);
        $sprin = SprinHistory::where('data_pelanggar_id', $kasus->id)->first();
        $template_document = new TemplateProcessor(storage_path('template\nd_permohonan_gelar.docx'));

        $template_document->setValues(array(
            'no_nota_dinas' => $kasus->no_nota_dinas,
            'tanggal_nota_dinas' => Carbon::parse($kasus->tanggal_nota_dinas)->translatedFormat('d F Y'),
            'pangkat' => $kasus->pangkat,
            'jabatan' => $kasus->jabatan,
            'kwn' => $kasus->kewarganegaraan,
            'terlapor' => $kasus->terlapor,
            'wujud_perbuatan' => $kasus->wujud_perbuatan,
            'terlapor' => $kasus->terlapor,
            'nrp' => $kasus->nrp,
            'jabatan' => $kasus->jabatan,
            'kesatuan' => $kasus->kesatuan,
            'pelapor' => $kasus->pelapor,
            'bulan_sprin' => Carbon::parse($sprin->created_at)->translatedFormat('F Y')
        ));

        $filename = 'Dokumen Nota Dinas Permohonan Gelar Perkara'.'.docx';
        $path = storage_path('document/'.$filename);
        $template_document->saveAs($path);

        // $dokumen = DokumenPelanggar::where('data_pelanggar_id', $kasus_id)->where('process_id', $process_id)->where('sub_process_id', $subprocess)->first();
        // if($dokumen == null){
        //     DokumenPelanggar::create([
        //         'data_pelanggar_id' => $kasus_id,
        //         'process_id' => $process_id,
        //         'sub_process_id' => $subprocess,
        //         'created_by' => Auth::user()->id,
        //         'status' => 1
        //     ]);
        // }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function undangan_klarifikasi($kasus_id, $process_id, $subprocess){
        return redirect()->back()->with('msg', 'Proses cetak Undangan Klarifikasi sedang dalam pengerjaan');
    }
}
