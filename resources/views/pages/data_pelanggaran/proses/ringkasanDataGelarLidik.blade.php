<h4>Ringkasan Data Gelar Lidik</h4>
<div class="col-lg-12 mb-3 mt-4 mb-4 p-3"  style="background-color:#e3f2fd; border-radius:1rem">
    <div class="row align-items-center" style="font-size: 1.1rem">
        <div class="col-md-3 col-sm-12">
            No. SPRIN Gelar Lidik
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprinGelar != null ? $sprinGelar->no_sprin : ' - '}} @if ($sprinGelar != null && $sprinGelar->is_draft) <span class="badge bg-warning">Nomor SPRIN Masih Draft</span> @endif
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. SPRIN Gelar Lidik
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprinGelar != null ? \carbon\Carbon::parse($sprinGelar->created_at)->translatedFormat('d, F Y') : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. Pelaksanaan Gelar Perkara
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? \carbon\Carbon::parse($gelarPerkara->tgl_pelaksanaan)->translatedFormat('d, F Y') : ' - '}}, Pukul : {{$gelarPerkara != null ? \carbon\Carbon::parse($gelarPerkara->waktu_pelaksanaan)->translatedFormat('G:i').' WIB' : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Tempat Pelaksanaan Gelar Perkara
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? $gelarPerkara->tempat_pelaksanaan : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Hasil Gelar Perkara
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? $gelarPerkara->hasil_gelar : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Pimpinan Gelar Perkara
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$gelarPerkara != null ? ($gelarPerkara->penyidik != null ? $gelarPerkara->penyidik->pangkats->name .' '. $gelarPerkara->penyidik->name : ' - ') : ' - '}}
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
