<h4>Ringkasan Data Pemberkasan</h4>
<div class="col-lg-12 mb-3 mt-4 mb-4 p-3"  style="background-color:#e3f2fd; border-radius:1rem">
    <div class="row align-items-center" style="font-size: 1.1rem">
        <div class="col-md-3 col-sm-12">
            No. LPA
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$lpa != null ? $lpa->no_lpa : ' - '}} @if ($lpa != null && $lpa->is_draft) <span class="badge bg-warning">Nomor LPA Masih Draft</span> @endif
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. LPA
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$lpa != null ? \carbon\Carbon::parse($lpa->created_at)->translatedFormat('d, F Y') : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            No. SPRIN Riksa
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprinRiksa != null ? $sprinRiksa->no_sprin : ' - '}} @if ($sprinRiksa != null && $sprinRiksa->is_draft) <span class="badge bg-warning">Nomor SPRIN Masih Draft</span> @endif
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. SPRIN Riksa
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprinRiksa != null ? \carbon\Carbon::parse($sprinRiksa->created_at)->translatedFormat('d, F Y') : ' - '}}
        </div>


        <div class="col-md-3 col-sm-12">
            No. DP3D
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$dp3d != null ? $dp3d->no_dp3d : ' - '}} @if ($dp3d != null && $dp3d->is_draft) <span class="badge bg-warning">Nomor DP3D Masih Draft</span> @endif
        </div>

        <div class="col-md-3 col-sm-12">
            Tgl. DP3D
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$dp3d != null ? \carbon\Carbon::parse($dp3d->created_at)->translatedFormat('d, F Y') : ' - '}}
        </div>
    </div>
</div>
