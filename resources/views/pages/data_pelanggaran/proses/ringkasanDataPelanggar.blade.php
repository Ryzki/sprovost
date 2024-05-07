<h4>Ringkasan Data Pelanggaran</h4>
<div class="col-lg-12 mb-3 mt-4 mb-4 p-3"  style="background-color:#e3f2fd; border-radius:1rem">
    <div class="row align-items-center" style="font-size: 1.1rem">
        <div class="col-md-3 col-sm-12">
            No. Nota Dinas
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            <b>{{$kasus->no_nota_dinas}} ({{\Carbon\Carbon::parse($kasus->created_at)->diff(\Carbon\Carbon::now())->format('%y tahun, %m bulan dan %d hari')}})</b>
        </div>
        <div class="col-md-3 col-sm-12">
            Pelapor
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$kasus->pelapor}}
        </div>
        <div class="col-md-3 col-sm-12">
            Pelanggaran Disiplin
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$kasus->wujudPerbuatan->keterangan_wp ?? ''}}
        </div>

        <div class="col-md-3 col-sm-12">
            Terlapor
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$kasus->pangkatName->name ?? ''}} {{$kasus->terlapor}} {{$kasus->jabatan}}, {{$kasus->kesatuan}} - {{$kasus->nrp}}
        </div>

        <div class="col-md-3 col-sm-12">
            Tempat & Tanggal Kejadian
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {{$kasus->tempat_kejadian == null ? ' - ' : $kasus->tempat_kejadian}} | {{\Carbon\Carbon::parse($kasus->tanggal_kejadian)->translatedFormat('l, d F Y')}}
        </div>

        <div class="col-md-3 col-sm-12">
            Kronologi
        </div>
        <div class="col-md-1">
            :
        </div>
        <div class="col-md-8 col-sm-12">
            {!! $kasus->kronologi !!}
        </div>

        @if ($kasus->data_from == 'yanduan' && count($kasus->evidenceReference) > 0)
            <div class="col-md-3 col-sm-12">
                Evidence Detail
            </div>
            <div class="col-md-1">
                :
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    @foreach ($kasus->evidenceReference as $key => $evidence)
                        <div class="col-md-3">
                                <a href="{{$evidence->evidence_path}}" target="_blank">Evidence {{$key+1}}</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        @if ($kasus->data_from == 'yanduan' && $kasus->identityReference != null)
            <div class="col-md-3 col-sm-12">
                Identity Detail
            </div>
            <div class="col-md-1">
                :
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{$kasus->identityReference->id_card}}" target="_blank">ID Card</a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{$kasus->identityReference->selfie}}" target="_blank">Selfie</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
