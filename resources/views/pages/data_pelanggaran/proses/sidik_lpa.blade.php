<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(4)">Sebelumnya</button>
            </div>
            <div>
                @if ($kasus->status_id > 6)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(7)">Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">

                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="80" data-number-of-steps="5" style="width: 80%;">
                    </div>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>Diterima</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Pulbaket</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Gelar Lidik</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Sidik / LPA</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                    <p>Sidang Disiplin</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 mt-4">
        {{-- <form action="/data-kasus/update" method="post"> --}}
        <form action="javascript:void(0)" id="form">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input type="text" class="form-control" value="{{ $kasus->status_id }}" hidden name="status">

            <h4>Ringkasan Data Pelanggaran</h4>
            <div class="col-lg-12 mb-3 mt-4 mb-4 p-3"  style="background-color:#e3f2fd; border-radius:1rem">
                <div class="row align-items-center" style="font-size: 1.1rem">
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
                        Dugaan Kasus
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$kasus->wujudPerbuatan->keterangan_wp}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Terlapor
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$kasus->pangkatName->name}} {{$kasus->terlapor}} {{$kasus->jabatan}}, {{$kasus->kesatuan}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Tanggal Kejadian
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{date('l, F Y', strtotime($kasus->tanggal_kejadian)) }}
                    </div>
                </div>
            </div>
            <hr>

            @if ($kasus->status_id != 8)
                <h4 class="mt-5">Download Berkas Pendukung</h4>
                <div class="col-lg-12 mb-3 mt-4 mb-5">
                    <div class="row">
                        @foreach ($sub_process as $sb)
                            <div class="col-md-3 col-sm-12">
                                <h6>Berkas {{$sb->name}}</h6>
                            </div>
                            <div class="col-md-1">
                                :
                            </div>
                            <div class="col-md-8 col-sm-12">
                                <a href="#" class="text-primary generate_document" style="text-decoration: none; width: 100%"  data-process_id="{{$kasus->status_id}}" data-kasus_id="{{$kasus->id}}" data-subprocess_name="{{$sb->name}}" data-subprocess="{{$sb->id}}">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Berkas {{$sb->name}}
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12" style="float: right;">
                        {{-- <button class="btn btn-success submit" type="submit" value="update_data" name="type_submit">Update
                            Data</button> --}}
                        <button class="btn btn-primary submit" type="submit" value="{{$kasus->status_id}}" name="type_submit"
                            {{ $kasus->status_id > 6 ? 'disabled' : '' }}>Update
                            Status (Sidang Disiplin)</button>
                    </div>
                </div>
            @else
                <h2 class="text-center text-info mt-4">
                    <i class="mdi mdi-information"></i> Kasus ini telah selesai
                </h2>
            @endif
        </form>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="lpa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan LPA</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-lpa">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Cetak LPA</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($lpa) ? date('d-m-Y H:i', strtotime($lpa->created_at)) . ' WIB' : '-' }}"
                                    readonly style="border:none">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Dicetak Oleh</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($lpa) ? $lpa->user[0]->name: '-' }}"
                                    readonly style="border:none">
                            </div>
                        </div>
                    </div>
                    <hr>
                    @if ($lpa == null)
                        <div class="form-group">
                            <label for="no_lpa" class="form-label">No. LPA</label>
                            <input type="text" class="form-control" name="no_lpa" value="{{!empty($lpa) ? $lpa->no_lpa : ''}}" placeholder="{{!empty($lpa) ? '' : 'Masukan Nomor LPA'}}">
                        </div>
                    @else
                        <div class="row justify-content-around items-center mt-4">
                            <p>
                                <a href="/print/lpa/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Ulang LPA
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($lpa == null)
                        <button type="submit" class="btn btn-primary">Buat Surat</button>
                    @else
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="sprin_riksa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan SPRIN Riksa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-sprin">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Cetak Surat SPRIN</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sprin) ? date('d-m-Y H:i', strtotime($sprin->created_at)) . ' WIB' : '-' }}"
                                    readonly style="border:none">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Dicetak Oleh</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sprin) ? $sprin->user[0]->name: '-' }}"
                                    readonly style="border:none">
                            </div>
                        </div>
                    </div>
                    <hr>
                    @if ($sprin == null)
                        <div class="form-group">
                            <label for="no_sprin" class="form-label">No. SPRIN</label>
                            <input type="text" class="form-control" name="no_sprin" value="{{!empty($sprin) ? $sprin->no_sprin : ''}}" placeholder="{{!empty($sprin) ? '' : 'Masukan Nomor SPRIN'}}">
                        </div>

                        <!-- Input data penyidik -->
                        <div class="card card-data-penyidik">
                            <div class="card-header">Input Data Penyelidik</div>
                            <div class="card-body">
                                <div class="mb-3" id="form_input_anggota">
                                    <div class="row form_penyelidik">
                                        <div class="col-lg-4">
                                            <div class="form-outline mb-3">
                                                <input type="text" class="form-control" name="pangkat"
                                                    id="pangkat" placeholder="Pangkat Penyelidik">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-outline mb-3">
                                                <input type="text" class="form-control" name="nama_penyelidik"
                                                    id="nama_penyidik" placeholder="Nama Penyelidik">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-outline mb-3">
                                                <input type="text" class="form-control num" name="nrp"
                                                    id="nrp" placeholder="NRP" onfocus="mask(this, '99999999')">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-outline mb-3">
                                                <input type="text" class="form-control" name="jabatan"
                                                    id="jabatan" placeholder="Jabatan Penyelidik">
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-outline mb-3">
                                                <input type="text" class="form-control" name="kesatuan"
                                                    id="kesatuan" placeholder="Kesatuan Penyelidik">
                                            </div>
                                        </div>

                                        {{-- <div class="col-lg-12">
                                            <div class="form-outline mb-3">
                                                <label for="tipe_tim" class="form-label">Jabatan TIM : </label>
                                                <select name="tipe_tim" id="tipe_tim" class="form-control"
                                                    disabeled>
                                                    <option value="1" class="text-center" selected>Ketua</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <hr>
                                </div>

                                <div class="d-flex mb-3 justify-content-between">
                                    <span onclick="tambahAnggota()" class="text-primary" style="cursor: pointer"> <i class="far fa-plus-square"></i>
                                        Anggota </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-around items-center mt-4">
                            <p>
                                <a href="/print/sprin_riksa/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Ulang SPRIN Riksa
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($sprin == null)
                        <button type="submit" class="btn btn-primary">Buat Surat</button>
                    @else
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="surat_panggilan_saksi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Panggilan Saksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-sp-saksi">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    {{-- @if (count($saksi) == 0) --}}
                        <div class="card" id="data-dihadap">
                            <div class="card-header">
                                Form yang akan dihadap
                            </div>
                            <div class="card-body row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="">Pilih Penyidik</label>
                                        <select name="penyidik_1" id="select_penyidik_1" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Penyidik Pertama"></select>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="tgl">Tanggal</label>
                                        <input type="date" name="tgl" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="waktu">Waktu</label>
                                        <input type="time" name="waktu" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="waktu">No. Telp Penyidik</label>
                                        <input type="text" name="no_telp_penyidik" class="form-control" onfocus="mask(this, '99999999999999')">
                                    </div>
                                </div>

                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <label for="">Lokasi</label>
                                        <textarea name="lokasi" class="form-control" cols="15" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                    @if (count($saksi) == 0)
                        <div class="card" id="data-saksi">
                            <div class="card-header" id="header-saksi" style="cursor: pointer">Tambah Saksi <br> <small class="text-info">*click untuk menambahkan saksi</small></div>
                            <div class="card-body" id="body-saksi" style="display:none">
                                <div class="mb-3" id="container_saksi">
                                    <div class="row mb-3 form_saksi">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" name="nama" class="form-control" placeholder="Masukan Nama">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="pekerjaan">Pekerjaan</label>
                                                <input type="text" name="pekerjaan" class="form-control" placeholder="Masukan Pekerjaan">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ttl">Tempat Tanggal Lahir</label>
                                                <input type="text" name="ttl" class="form-control" placeholder="Masukan Tempat Tanggal Lahir">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="warga_negara">Warga Negara</label>
                                                <input type="text" name="warga_negara" class="form-control" placeholder="Masukan Warga Negara">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="agama">Agama</label>
                                                <select name="agama" class="form-select">
                                                    <option value="0" selected disabled>----- Harap Pilih Agama -----</option>
                                                    @foreach ($agamas as $agama)
                                                        <option value="{{$agama->id}}">{{$agama->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="no_telp">No. Telp</label>
                                                <input type="text" name="no_telp" class="form-control" placeholder="Masukan Nomor Telepon"onclick="mask(this, '999999999999999')" onchange="mask(this, '999999999999999')">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <textarea name="alamat" class="form-control" cols="8" rows="5"></textarea>
                                                {{-- <input type="text" name="agama" class="form-control" placeholder="Masukan Warga Negara"> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="d-flex mb-3 mt-5 justify-content-between">
                                    <span onclick="tambahSaksi()" class="text-primary" style="cursor: pointer"> <i class="far fa-plus-square"></i>
                                        Saksi </span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header" style="cursor: pointer">List Data Saksi</div>
                            <ul class="list-group">
                                @foreach ($saksi as $s)
                                    <li class="list-group-item" style="background-color: #a0d7fffb">
                                        <p> {{$s->nama}} - {{$s->no_telp}} </p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select-penyidik').map((k, v) => {
            $(v).select2({
                theme: 'bootstrap-5'
            })
        })

        $('#header-saksi').on('click', function(){
            if($('#body-saksi').css('display') == 'none'){
                $('#body-saksi').slideDown()
            } else {
                $('#body-saksi').slideUp()
            }
        })

        $('.generate_document').on('click', function(){
            $('input[name="sub_process"]').val($(this).data('subprocess'))
            $('input[name="process_id"]').val($(this).data('process_id'))

            var subProcess = $(this).data('subprocess_name').split(' ').join('_')
            subProcess = subProcess.toLowerCase()
            let kasus_id = $(this).data('kasus_id')

            if ($(`#${subProcess}`).length > 0){
                if (subProcess == 'surat_panggilan_saksi'){
                    getPenyidik(kasus_id)
                }
                $(`#${subProcess}`).modal('show')
            } else {
                let url = `/print/${subProcess}/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`
                window.location.href = url
            }

        })

        $('#form-generate-lpa').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/lpa/{{ $kasus->id }}/not-generated`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    window.location.href = `/download-file/${res.file}`
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil generate dan download dokumen',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    setTimeout(() => {
                        window.location.reload()
                    }, 1750);
                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: `Terjadi Kesalahan`,
                        text: xhr.responseJSON.status.msg,
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                }
            })
        })

        $('#form-generate-sprin').on('submit', function(){
            var data = new FormData()
            const elemPenyelidik = $('#form_input_anggota').find('.form_penyelidik')
            for (let i = 0; i < elemPenyelidik.length; i++) {
                var nrp = $(elemPenyelidik).find('input[name="nrp"]')[i].value
                nrp = nrp.split('_').join('');
                data.append(`pangkat[${i}]`, $(elemPenyelidik).find('input[name="pangkat"]')[i].value)
                data.append(`nama[${i}]`, $(elemPenyelidik).find('input[name="nama_penyelidik"]')[i].value)
                data.append(`nrp[${i}]`, nrp)
                data.append(`jabatan[${i}]`, $(elemPenyelidik).find('input[name="jabatan"]')[i].value)
                data.append(`kesatuan[${i}]`, $(elemPenyelidik).find('input[name="kesatuan"]')[i].value)
            }

            data.append('no_sprin', $('input[name="no_sprin"]').val())
            data.append('process_id', $('input[name="process_id"]').val())
            data.append('sub_process', $('input[name="sub_process"]').val())

            $.ajax({
                url: `/print/sprin_riksa/{{ $kasus->id }}/not_generated`,
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                data: data,
                processData : false,
                contentType: false,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    window.location.href = `/download-file/${res.file}`
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil generate dan download dokumen',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    setTimeout(() => {
                        window.location.reload()
                    }, 2000);
                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: `Terjadi Kesalahan`,
                        text: xhr.responseJSON.status.msg,
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                }
            })
        })

        $('#form-generate-sp-saksi').on('submit', function(){
            var data = new FormData()
            const elem = $('#container_saksi').find('.form_saksi')
            for (let i = 0; i < elem.length; i++) {
                var telp = $(elem).find('input[name="no_telp"]')[i].value
                telp = telp.split('_').join('')

                data.append(`nama[${i}]`, $(elem).find('input[name="nama"]')[i].value)
                data.append(`pekerjaan[${i}]`, $(elem).find('input[name="pekerjaan"]')[i].value)
                data.append(`warga_negara[${i}]`, $(elem).find('input[name="warga_negara"]')[i].value)
                data.append(`agama[${i}]`, $(elem).find('select[name="agama"] option').filter(':selected')[i].value)
                data.append(`agamaText[${i}]`, $(elem).find('select[name="agama"] option').filter(':selected')[i].innerHTML)
                data.append(`alamat[${i}]`, $(elem).find('textarea[name="alamat"]')[i].value)
                data.append(`ttl[${i}]`, $(elem).find('input[name="ttl"]')[i].value)
                data.append(`no_telp[${i}]`, telp)
            }

            data.append('penyidik1', $('select[name="penyidik_1"] option').filter(':selected').val())
            data.append('process_id', $('input[name="process_id"]').val())
            data.append('sub_process', $('input[name="sub_process"]').val())
            data.append('no_telp_penyidik', $('input[name="no_telp_penyidik"]').val())

            $.ajax({
                url: `/print/surat_panggilan_saksi/{{$kasus->id}}`,
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                data: data,
                processData : false,
                contentType: false,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success: (res) => {
                    var tempDownload = document.createElement("a");
                    tempDownload.style.display = 'none';

                    document.body.appendChild( tempDownload );

                    for( var n = 0; n < res.file.length; n++ )
                    {
                        var download = res.file[n];
                        tempDownload.setAttribute( 'href', `/download-file/${res.file[n]}` );
                        tempDownload.setAttribute( 'download', res.file );

                        tempDownload.click();
                    }

                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil generate dan download dokumen',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    setTimeout(() => {
                        window.location.reload()
                    }, 1000);

                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: `Terjadi Kesalahan`,
                        text: xhr.responseJSON.status.msg,
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                }
            })
        })

        $('.submit').on('click', function(){
            var data = $('#form').serializeArray()
            data.push({name: 'status', value: $(this).val()})

            $.ajax({
                url: '/data-kasus/update',
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil rubah status',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })

                    window.location.reload()
                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: `Terjadi Kesalahan`,
                        text: xhr.responseJSON.status.msg,
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                }
            })
        })
    })

    function mask(el, maskVal){
        $(el).inputmask({"mask": maskVal, "placeholder": ''});
    }

    function getPenyidik(kasus_id){
        $.ajax({
            url: `{{url('data-penyidik-riksa/${kasus_id}')}}`,
            method: 'GET',
            success: (res) => {
                var option = '<option><option>'
                res.map((v, k) => {
                    option += `<option value="${v.id}"> ${v.pangkat} ${v.name} (${v.jabatan}) </option>`
                })

                $('.select-penyidik').map((k, v) => {
                    $(v).html(option)
                })
            }
        })
    }

    function tambahSaksi(){
        let html = `
        <div class="row mb-3 form_saksi">
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukan Nama">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="pekerjaan">Pekerjaan</label>
                    <input type="text" name="pekerjaan" class="form-control" placeholder="Masukan Pekerjaan">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="ttl">Tempat Tanggal Lahir</label>
                    <input type="text" name="ttl" class="form-control" placeholder="Masukan Tempat Tanggal Lahir">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="warga_negara">Warga Negara</label>
                    <input type="text" name="warga_negara" class="form-control" placeholder="Masukan Warga Negara">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="agama">Agama</label>
                    <select name="agama" class="form-select">
                        <option value="0" selected disabled>----- Harap Pilih Agama -----</option>
                        @foreach ($agamas as $agama)
                            <option value="{{$agama->id}}">{{$agama->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="no_telp">No. Telp</label>
                    <input type="text" name="no_telp" class="form-control" placeholder="Masukan Nomor Telepon" onclick="mask(this, '999999999999999')" onchange="mask(this, '999999999999999')">
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" class="form-control" cols="8" rows="5"></textarea>
                    {{-- <input type="text" name="agama" class="form-control" placeholder="Masukan Warga Negara"> --}}
                </div>
            </div>

            <div class="d-flex mb-3 mt-4 justify-content-end">
                    <span onclick="removeSaksi($(this))" class="text-danger" style="cursor: pointer"> <i class="far fa-minus-square"></i>
                        Saksi </span>
                </div>
        </div><hr>
        `

        $('#container_saksi').append(html);
    }
    function tambahAnggota() {
        var addAnggota = localStorage.getItem('addAnggota')

        let inHtml =
            `<div class="row form_penyelidik">
                <div class="col-lg-4">
                    <div class="form-outline mb-3">
                        <input type="text" class="form-control" name="pangkat" id="pangkat" placeholder="Pangkat Penyelidik">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-outline mb-3">
                        <input type="text" class="form-control" name="nama_penyelidik" id="nama_penyidik" placeholder="Nama Penyelidik">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-outline mb-3">
                        <input type="text" class="form-control" name="nrp" id="nrp" placeholder="NRP" onfocus="mask(this, '99999999')">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-outline mb-3">
                        <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="Jabatan Penyelidik">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-outline mb-3">
                        <input type="text" class="form-control" name="kesatuan" id="kesatuan" placeholder="Kesatuan Penyelidik">
                    </div>
                </div>

                <div class="d-flex mb-3 justify-content-end">
                    <span onclick="removeAnggota($(this))" class="text-danger" style="cursor: pointer"> <i class="far fa-minus-square"></i>
                        Anggota </span>
                </div>
            </div>
        <hr>`;
        addAnggota = parseInt(addAnggota) + 1
        localStorage.setItem('addAnggota', addAnggota)

        if(addAnggota <= 5){
            $('#form_input_anggota').append(inHtml);
        } else {
            Swal.fire({
                title: `Tidak bisa menambahkan lebih dari 5`,
                icon: 'error',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
        }
    }
    function removeSaksi(el){
        $(el).parent().parent().next().remove()
        $(el).parent().parent().remove()
    }
</script>
