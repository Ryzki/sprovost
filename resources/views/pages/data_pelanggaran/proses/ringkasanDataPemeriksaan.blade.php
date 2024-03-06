<h4>Ringkasan Data Pemeriksaan</h4>
<div class="col-lg-12 mb-3 mt-4 mb-4 p-3"  style="background-color:#e3f2fd; border-radius:1rem">
    <div class="row align-items-center" style="font-size: 1.1rem">
        <div class="col-md-3 col-sm-12">
            No. SPRIN Lidik
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprin != null ? $sprin->no_sprin : ' - '}} @if ($sprin != null && $sprin->is_draft) <span class="badge bg-warning">Nomor SPRIN Masih Draft</span> @endif
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. SPRIN Lidik
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprin != null ? \carbon\Carbon::parse($sprin->created_at)->translatedFormat('d, F Y') : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Unit Pemeriksa
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprin != null ? $sprin->unit_pemeriksa : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. Undangan Klarifikasi
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$undanganKlarifikasi != null ? \carbon\Carbon::parse($undanganKlarifikasi->tgl_pertemuan)->translatedFormat('d, F Y') : ' - '}}, Pukul : {{$undanganKlarifikasi != null ? \carbon\Carbon::parse($undanganKlarifikasi->jam_pertemuan)->translatedFormat('G:i').' WIB' : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Hasil Pemeriksaan
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? $gelarPerkara->hasil_gelar : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Pasal Dilanggar
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? $gelarPerkara->landasan_hukum : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Saran Pemeriksa
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? ($gelarPerkara->saran_penyidik != null ? $gelarPerkara->saran_penyidik : ' - ') : ' - '}}
        </div>
    </div>
</div>
