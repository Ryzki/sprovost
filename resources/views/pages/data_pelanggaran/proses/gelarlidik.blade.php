<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(3)">Sebelumnya</button>
            </div>
            <div>
                @if ($kasus->status_id > 4 && $kasus->status_id != 5)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(6)">Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">

                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="60" data-number-of-steps="5" style="width: 60%;">
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
                    <p>
                        @if($kasus->status_id == 5)
                            Limpah Polda / Jajaran
                        @else
                            Gelar Lidik
                        @endif
                    </p>
                </div>
                <div class="f1-step">
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
                        {{$kasus->wujud_perbuatan}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Terlapor
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$kasus->pangkat}} {{$kasus->terlapor}} {{$kasus->jabatan}}, {{$kasus->kesatuan}}
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
                @if($kasus->status_id == 5)
                    <h2 class="text-center text-warning mt-4">
                        <i class="mdi mdi-information"></i> Kasus telah dilimpahkan ke Polda / Jajaran
                    </h2>
                @else
                    <h4 class="mt-5">Download Berkas Pendukung</h4>
                    <div class="col-lg-12 mb-3 mt-4 mb-5">
                        <div class="row">
                            @foreach ($sub_process as $sb)
                                @if ($sb->required == 1)
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
                                @else
                                    @if ($sprinGelar != null)
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
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12" style="float: right;">
                            <button class="btn btn-info text-white dropdown-toggle" id="actionButton" data-bs-toggle="dropdown" {{ $kasus->status_id > 4 ? 'disabled' : '' }}>Update Status</button>
                            <ul class="dropdown-menu" aria-labelledby="actionButton" id="ActionListBtn">
                                <li><a class="dropdown-item submit" href="javascript:void(0)" data-next="limpah">Limpah Polda / Jajaran</a></li>
                                <li><a class="dropdown-item submit" href="javascript:void(0)" data-next="sidik">Sidik / LPA</a></li>
                            </ul>
                        </div>
                    </div>
                @endif
            @else
                <h2 class="text-center text-info mt-4">
                    <i class="mdi mdi-information"></i> Kasus ini telah selesai
                </h2>
            @endif
        </form>
    </div>
</div>

<div class="modal fade" id="sprin_gelar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Dokumen SPRIN Gelar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-sprin-gelar">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    @if ($sprinGelar == null)
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="no_sprin" class="form-label">No. SPRIN</label>
                                    <input type="text" class="form-control" name="no_sprin" placeholder='Masukan Nomor SPRIN'>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tgl" class="form-label">Tanggal Pelaksanaan Gelar Perkara</label>
                                    <input type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal'>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tempat" class="form-label">Lokasi Pelaksanaan Gelar Perkara</label>
                                    <input type="text" class="form-control" name="tempat" placeholder='Masukan Lokasi Pelaksanaan'>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="waktu" class="form-label">Waktu Pelaksanaan Gelar Perkara</label>
                                    <input type="time" class="form-control" name="waktu" placeholder='Masukan Waktu Pelaksanaan'>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-around items-center mt-4">
                            <p>
                                <a href="/print/sprin_gelar/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Ulang SPRIN Gelar Perkara
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    @if ($sprinGelar == null)
                        <button type="submit" class="btn btn-primary">Buat Dokumen</button>
                    @else
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="undangan_gelar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Dokumen Undangan Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-undangan-gelar">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tgl" class="form-label">Tanggal Pelaksanaan Gelar Perkara</label>
                                <input type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal' value="{{ isset($gelarPerkara) ? $gelarPerkara->tgl_pelaksanaan : '' }}"
                                @if (isset($gelarPerkara))
                                    readonly
                                @endif>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="jam" class="form-label">Waktu Pelaksanaan Gelar Perkara</label>
                                <input type="time" class="form-control" name="jam" placeholder='Pilih Jam' value="{{ isset($gelarPerkara) ? $gelarPerkara->waktu_pelaksanaan : '' }}"
                                @if (isset($gelarPerkara))
                                    readonly
                                @endif>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tempat" class="form-label">Tempat Pelaksanaan</label>
                                <input type="text" class="form-control" name="tempat" placeholder='Masukan Tempat Pelaksanaan' value="{{ isset($gelarPerkara) ? $gelarPerkara->tempat_pelaksanaan : '' }}"
                                @if (isset($gelarPerkara))
                                    readonly
                                @endif>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="pimpinan">Pimpinan Gelar Perkara</label>
                                <select name="pimpinan" id="select-pimpinan" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Pimpinan">
                                </select>
                                {{-- <input type="text" class="form-control" name="pimpinan" placeholder='Masukan Pimpinan Pelaksanaan'> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="laporan_hasil_gelar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Dokumen Laporan Hasil Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-laporan-gelar">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">Form Peserta Gelar Perkara</div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-4">
                                                <label for="pimpinan">Pimpinan</label>
                                                <input type="hidden" name="pimpinan" value="{{ isset($gelarPerkara) ? $gelarPerkara->pimpinan : '' }}" class="form-control" readonly>
                                                <input type="text" name="pimpinan_text" value="{{ isset($gelarPerkara) ? $gelarPerkara->penyidik->pangkat.' '.$gelarPerkara->penyidik->name : '' }}" class="form-control" readonly>
                                                {{-- <select name="pimpinan" id="select-pimpinan" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Pimpinan">
                                                </select> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-4">
                                                <label for="pemapar">Pemapar</label>
                                                <select name="pemapar" id="select-pemapar" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Pemapar">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-4">
                                                <label for="notulen">Notulen</label>
                                                <select name="notulen" id="select-notulen" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Notulen">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mb-4">
                                                <label for="operator">Operator</label>
                                                <select name="operator" id="select-operator" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Operator">
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header">Form Waktu dan Tempat Pelaksanaan Gelar Perkara</div>
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tgl" class="form-label">Tanggal Pelaksanaan</label>
                                                <input type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal' value="{{ isset($gelarPerkara) ? $gelarPerkara->tgl_pelaksanaan : '' }}"
                                                @if (isset($gelarPerkara))
                                                    readonly
                                                @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="jam" class="form-label">Waktu Pelaksanaan</label>
                                                <input type="time" class="form-control" name="jam" placeholder='Pilih Jam' value="{{ isset($gelarPerkara) ? $gelarPerkara->waktu_pelaksanaan : '' }}"
                                                @if (isset($gelarPerkara))
                                                    readonly
                                                @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="tempat" class="form-label">Tempat Pelaksanaan</label>
                                                <input type="text" class="form-control" name="tempat" placeholder='Masukan Tempat Pelaksanaan' value="{{ isset($gelarPerkara) ? $gelarPerkara->tempat_pelaksanaan : '' }}"
                                                @if (isset($gelarPerkara))
                                                    readonly
                                                @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Form Hasil Putusan Gelar Perkara</div>
                        <div class="card-body">
                            <div class="row mb-4">
                                {{-- <div class="col-md-6 col-12"> --}}
                                    <fieldset class="form-group row mb-4">
                                        <legend class="col-form-label">Hasil Putusan Gelar</legend>
                                        <div class="col-sm-10">
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_gp" id="hasil_gp1" value="Bersalah">
                                            <label class="form-check-label" for="hasil_gp1">
                                              Bersalah
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_gp" id="hasil_gp2" value="Tidak Bersalah">
                                            <label class="form-check-label" for="hasil_gp2">
                                              Tidak Bersalah
                                            </label>
                                          </div>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group mb-4">
                                        <legend class="col-form-label">Keterangan Hasil</legend>
                                        <div class="form-group">
                                            <label for="keterangan"></label>
                                            <textarea name="keterangan" id="keterangan" cols="60" rows="3" class="form-control"></textarea>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group mb-4">
                                        <legend class="col-form-label">Landasan Hukum</legend>
                                        <div class="form-group">
                                            <label for="landasan_hukum"></label>
                                            <textarea name="landasan_hukum" id="landasan_hukum" cols="60" rows="3" class="form-control"></textarea>
                                        </div>
                                    </fieldset>

                                    <fieldset class="form-group">
                                        <legend class="col-form-label">Tindak Lanjut</legend>
                                        <div class="form-group">
                                            <label for="tindak_lanjut"></label>
                                            <input type="text" name="tindak_lanjut" id="tindak_lanjut" class="form-control" />
                                        </div>
                                    </fieldset>
                                {{-- </div> --}}
                                {{-- <div class="col-md-6 col-12"> --}}
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // tinymce.remove();
        // tinymce.init({
        //     selector: ".htmlEditor",
        //     plugins: [
        //         "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        //         "template",
        //     ],
        //     menubar: "file edit view insert format tools table tc help",
        //     toolbar:
        //     "undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | fullscreen  preview save print | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment",
        //     height: 600,
        //     templates: [
        //         {
        //             title: "Laporan Hasil Gelar Perkara",
        //             description: "Laporan Hasil Gelar Perkara",
        //             url:`{{asset('template_lap_hasil_gp.html')}}`,
        //         },
        //     ],
        //     image_title: true,
        //     automatic_uploads: true,
        //     file_picker_types: "image",
        //     relative_urls: false,
        //     remove_script_host: false,
        //     convert_urls: true,
        // });

        $('.select-penyidik').map((k, v) => {
            $(v).select2({
                theme: 'bootstrap-5'
            })
        })

        $('.generate_document').on('click', function(){
            $('input[name="sub_process"]').val($(this).data('subprocess'))
            $('input[name="process_id"]').val($(this).data('process_id'))

            var subProcess = $(this).data('subprocess_name').split(' ').join('_')
            subProcess = subProcess.toLowerCase()
            let kasus_id = $(this).data('kasus_id')

            if ($(`#${subProcess}`).length > 0){
                if (subProcess == 'laporan_hasil_gelar' || subProcess == 'undangan_gelar') getPenyidik(kasus_id);
                $(`#${subProcess}`).modal('show')
            } else {
                let url = `/print/${subProcess}/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`
                window.location.href = url
            }

        })

        $('#form-sprin-gelar').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/sprin_gelar/{{ $kasus->id }}/not-generated`,
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
                    }, 1500);
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

        $('#form-undangan-gelar').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/undangan_gelar/{{ $kasus->id }}`,
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

        $('#form-laporan-gelar').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/laporan_hasil_gelar/{{ $kasus->id }}`,
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
            data.push({
                name: 'next',
                value: $(this).data('next')
            })

            $.ajax({
                url: `/limpah-polda`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    if ($(this).data('next') == 'limpah'){
                        window.location.href = `/download-file/${res.file}`

                        setTimeout(() => {
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

                            window.location.reload()
                        }, 2500);
                    } else {
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
                    }
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

    function getPenyidik(kasus_id){
        $.ajax({
            url: `{{url('data-penyidik/${kasus_id}')}}`,
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

    function mask(el, maskVal){
        $(el).inputmask({"mask": maskVal});
    }
</script>
