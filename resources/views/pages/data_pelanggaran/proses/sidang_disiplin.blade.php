<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(6)">Sebelumnya</button>
            </div>
            <div>
                @if ($kasus->status_id > 7)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(7)">Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">

                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="100" data-number-of-steps="5" style="width: 100%;">
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
                <div class="f1-step active">
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
                            {{ $kasus->status_now > 6 ? 'disabled' : '' }}>Selesai</button>
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

<div class="modal fade" id="sprin_perangkat_sidang" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="tgl_sidang">Tanggal Pelaksanaan Sidang</label>
                                    <input type="date" name="tgl_sidang" class="form-control" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="waktu_sidang">Waktu Pelaksanaan Sidang</label>
                                    <input type="time" name="waktu_sidang" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lokasi_sidang">Lokasi Sidang</label>
                                <input type="text" class="form-control" name="lokasi_sidang" required>
                            </div>
                        </div>
                    @else
                        <div class="row justify-content-around items-center mt-4">
                            <p>
                                <a href="/print/sprin_perangkat_sidang/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Ulang SPRIN Sidang
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

<div class="modal fade" id="undangan_sidang_disiplin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Undangan Sidang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-undangan">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row mb-4">
                        {{-- <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="no_undangan" class="form-label">No. Undangan</label>
                                <input type="number" class="form-control" name="no_undangan" placeholder='Masukan Nomor Undangan'>
                            </div>
                        </div> --}}
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tgl" class="form-label">Tanggal Sidang</label>
                                <input type="date" class="form-control" name="tgl" value="{{!empty($sidang) ? $sidang->tgl_sidang : ''}}" @empty(!$sidang) readonly @endempty placeholder='Pilih Tanggal'>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="jam" class="form-label">Jam Pelaksanaan Sidang</label>
                                <input type="time" class="form-control" name="jam" value="{{!empty($sidang) ? $sidang->waktu_sidang : ''}}" @empty(!$sidang) readonly @endempty>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="lokasi" class="form-label">Ruang Sidang</label>
                                <input type="text" class="form-control" name="lokasi" value="{{!empty($sidang) ? $sidang->lokasi_sidang : ''}}" @empty(!$sidang) readonly @endempty>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat Surat</button>
                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="hasil_putusan_sidang_disiplin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hasil Putusan Sidang Disiplin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-hasil-putusan">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="card">
                        <div class="card-header">
                            <h6>
                                Tanggal Pelaksanaan Sidang
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <p class="font-weight-bold">Tanggal Sidang</p>
                                    <p> {{!empty($sidang) ? $sidang->tgl_sidang : '-'}} </p>
                                </div>
                                <div class="col-md-4 col-12">
                                    <p class="font-weight-bold">Waktu Sidang</p>
                                    <p> {{!empty($sidang) ? \Carbon\Carbon::parse($sidang->waktu_sidang)->translatedFormat('H:i') : '-'}} </p>
                                </div>
                                <div class="col-md-4 col-12">
                                    <p class="font-weight-bold">Lokasi Sidang</p>
                                    <p> {{!empty($sidang) ? $sidang->lokasi_sidang : '-'}} </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-3">
                        <div class="card-header">
                            <h6>Hasil Putusan Sidang</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Hasil Putusan</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_sidang" id="hasil_sidang1" value="Terbukti">
                                            <label class="form-check-label" for="hasil_sidang1">
                                              Terbukti
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="hasil_sidang" id="hasil_sidang2" value="Tidak Terbukti">
                                            <label class="form-check-label" for="hasil_sidang2">
                                              Tidak Terbukti
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label for="hukuman">Hukuman Disiplin</label>
                                    <input type="text" name="hukuman" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Buat Surat</button>
                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button> --}}
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.generate_document').on('click', function(){
            $('input[name="sub_process"]').val($(this).data('subprocess'))
            $('input[name="process_id"]').val($(this).data('process_id'))

            var subProcess = $(this).data('subprocess_name').split(' ').join('_')
            subProcess = subProcess.toLowerCase()
            let kasus_id = $(this).data('kasus_id')

            if ($(`#${subProcess}`).length > 0){
                $(`#${subProcess}`).modal('show')
            } else {
                let url = `/print/${subProcess}/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`
                window.location.href = url
            }

        })

        $('#form-generate-sprin').on('submit', function() {
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/sprin_perangkat_sidang/{{ $kasus->id }}/not-generated`,
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

        $('#form-generate-undangan').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/undangan_sidang_disiplin/{{ $kasus->id }}`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    console.log(res)
                    window.location.href = `/download-file/${res.file}`

                    var tempDownload = document.createElement("a");
                    tempDownload.style.display = 'none';

                    document.body.appendChild( tempDownload );

                    for( var n = 0; n < res.file_undangan_saksi.length; n++ )
                    {
                        var download = res.file_undangan_saksi[n];
                        tempDownload.setAttribute( 'href', `/download-file/${res.file_undangan_saksi[n]}` );
                        tempDownload.setAttribute( 'download', res.file_undangan_saksi );

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

                    // setTimeout(() => {
                    //     // window.location.reload()
                    // }, 2000);
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

        $('#form-generate-hasil-putusan').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/hasil_putusan_sidang_disiplin/{{ $kasus->id }}`,
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

                    // setTimeout(() => {
                    //     // window.location.reload()
                    // }, 2000);
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
            var done = false

            Swal.fire({
                title: 'Apakah anda yakin ingin menyelesaikan kasus ini?',
                text: 'Kasus yang sudah diselesaikan tidak dapat dilakukan proses apapun (cetak dokumen, dll)',
                icon: 'question',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Ya, Selesaikan Kasus',
                denyButtonText: `Tidak`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
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
                } else {
                    swal.close()
                }
            })


        })

    })
</script>
