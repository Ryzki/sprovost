<h4>Ringkasan Data Sidang Disiplin</h4>
<div class="col-lg-12 mb-3 mt-4 mb-4 p-3"  style="background-color:#e3f2fd; border-radius:1rem">
    <div class="row align-items-start" style="font-size: 1.1rem">
        <div class="col-md-3 col-sm-12">
            No. SPRIN Perangkat Sidang
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprin != null ? $sprin->no_sprin : ' - '}} @if ($sprin != null && $sprin->is_draft) <span class="badge bg-warning">Nomor SPRIN Masih Draft</span> @endif
        </div>

        <div class="col-md-3 col-sm-12">
            Waktu / Tanggal Pelaksanaan Sidang
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sidang != null ? \Carbon\Carbon::parse($sidang->waktu_sidang)->format('H:i').' WIB, '. \carbon\Carbon::parse($sidang->tgl_sidang)->translatedFormat('d F Y') : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Lokasi Sidang
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sidang != null ? $sidang->lokasi_sidang : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            No. Nota Dinas Bag. Rehabpers
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprin != null ? $sprin->no_nd_rehabpers : ' - '}}
        </div>


        <div class="col-md-3 col-sm-12">
            Tgl. Nota Dinas Bag. Rehabpers
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sprin != null ? \Carbon\Carbon::parse($sprin->tgl_nd_rehabpers)->translatedFormat('d F Y') : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Hasil Putusan Sidang
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$sidang != null ? ($sidang->hasil_sidang != null ? $sidang->hasil_sidang : ' - ') : ' - '}}
        </div>

        <div class="col-md-3 col-sm-12">
            Hukuman Disiplin
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            @if($sidang != null && $sidang->hukuman_disiplin != null)
                @php
                    $hukuman = explode(',', $sidang->hukuman_disiplin);
                @endphp
                <ol style="padding-left: 1rem !important">
                    @foreach ($hukuman as $hk)
                        <li>{{$hk}}</li>
                    @endforeach
                </ol>
            @endif
        </div>
    </div>
</div>
