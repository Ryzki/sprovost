<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(1)">Sebelumnya</button>
            </div>
            <div>
                @if ($kasus->status_id > 3 || $kasus->status_now > 3)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(4)">Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">

                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="40" data-number-of-steps="5" style="width: 40%;">
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
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Gelar Lidik</p>
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
    <div class="col-lg-12">
        {{-- <form action="/data-kasus/update" method="post"> --}}
        <form action="javascript:void(0)" id="form">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input type="text" class="form-control" value="{{ $kasus->status_id }}" hidden name="process_id">

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

            <div class="row align-items-center justify-content-center">
            @if ($kasus->status_now != 8)
                <h4 class="">Download Berkas</h4>
                <div class="col-lg-12 mb-3 mt-4">
                    <div class="row align-items-end justify-content-center">
                        @foreach ($sub_process as $sb)
                            @if($sb->required == 1)
                                <div class="col-md-3 col-sm-12">
                                    <h6>Berkas {{$sb->name}}</h6>
                                </div>
                                <div class="col-md-1">
                                    :
                                </div>
                                <div class="col-md-8 col-sm-12">
                                    <a href="#" class="text-primary modal-toggle" style="text-decoration: none; width: 100%"  data-process_id="{{$kasus->status_id}}" data-kasus_id="{{$kasus->id}}" data-subprocess_name="{{$sb->name}}" data-subprocess="{{$sb->id}}">
                                        <i class="mdi mdi-file-document"></i>
                                        Download Berkas {{$sb->name}}
                                        <span class="mdi mdi-download"></span>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @if ($sprin != null)
                    <h4 class="mt-4">Download Berkas Lainnya</h4>
                    <div class="col-lg-12 mb-3 mt-4">
                        <div class="row align-items-end justify-content-center">
                            @foreach ($sub_process as $sb)
                                @if ($sb->required != 1)
                                    <div class="col-md-3 col-sm-12">
                                        <h6>Berkas {{$sb->name}}</h6>
                                    </div>
                                    <div class="col-md-1">
                                        :
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <a href="#" class="text-primary modal-toggle" style="text-decoration: none; width: 100%"  data-process_id="{{$kasus->status_id}}" data-kasus_id="{{$kasus->id}}" data-subprocess_name="{{$sb->name}}" data-subprocess="{{$sb->id}}">
                                            <i class="mdi mdi-file-document"></i>
                                            Download Berkas {{$sb->name}}
                                            <span class="mdi mdi-download"></span>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="row mt-5">
                    <div class="col-lg-12" style="float: right;">
                        {{-- <button class="btn btn-success submit" type="submit" value="update_data" name="type_submit">Update
                            Data</button> --}}
                        <button class="btn btn-primary submit" type="submit" value="{{$kasus->status_id}}" name="type_submit"
                            {{ $kasus->status_now > 3 ? 'disabled' : '' }}>Update
                            Status (Gelar Lidik)</button>
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
<div class="modal fade" id="sprin_lidik" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Perintah</h5>
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
                        {{-- <div class="form-outline mb-3 mt-4">
                            <label class="form-label" for="textAreaExample2">Isi Surat</label>
                            <textarea class="form-control htmlEditor" name="editor_surat_perintah"></textarea>
                            <textarea name="isi_surat_perintah" hidden class="value_html"></textarea>
                        </div> --}}
                    @else
                        <div class="row justify-content-around items-center mt-4">
                            <p>
                                <a href="/surat-perintah/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                    <i class="mdi mdi-file-document"></i>
                                    Download SPRIN
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </p>
                            <p>
                                <a href="/surat-perintah-pengantar/{{$kasus->id}}" class="text-primary" style="text-decoration: none; width: 100%">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Surat Pengantar SPRIN
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

<div class="modal fade" id="sp2hp2_awal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat SP2HP Awal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/surat-sp2hp2-awal/{{ $kasus->id }}" method="post"> --}}
            <form action="javascript:void(0)" id="form-generate-sp2hp2">
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    @csrf
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Tanggal Cetak Surat SP2HP2 Awal</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sp2hp2) ? date('d-m-Y H:i', strtotime($sp2hp2->created_at)) . ' WIB' : '-' }}"
                                    readonly style="border:none">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Dicetak Oleh</label>
                                <input type="text" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp"
                                    value="{{ !empty($sp2hp2) ? $sp2hp2->user[0]->name : '-' }}"
                                    readonly style="border:none">
                            </div>
                        </div>
                    </div>
                    <hr>
                    @if (!$sp2hp2)
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama yang Menangani</label>
                            <input type="text" class="form-control" name="penangan" aria-describedby="emailHelp"
                                placeholder="Unit II Detasemen A Ropaminal Divpropam Polri">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nama yang dihubungi</label>
                            <input type="text" class="form-control" name="dihubungi"
                                placeholder="AKP ERICSON SIREGAR, S.Kom., M.T., M.Sc">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Jabatan yang dihubungi</label>
                            <input type="text" class="form-control" name="jabatan_dihubungi"
                                placeholder="Kanit II Den A">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Jabatan</label>
                            <input type="text" class="form-control" name="telp_dihubungi">
                        </div>
                    @else
                        <p>
                            <a href="/surat-sp2hp2-awal/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                <i class="mdi mdi-file-document"></i>
                                Download Ulang SP2HP Awal
                                <span class="mdi mdi-download"></span>
                            </a>
                        </p>
                    @endif
                </div>
                <div class="modal-footer">
                    @if (!$sp2hp2)
                        <button type="submit" class="btn btn-primary">Buat Surat</button>
                    @else
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

{{-- <div class="modal fade" id="bai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat BAI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-between align-items-center">
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">BAI Sipil</label>
                            <p>
                                <a href="" class="text-primary bai_sipil">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Berkas
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">BAI Anggota</label>
                            <p>
                                <a href="#" class="text-primary bai_anggota">
                                    <i class="mdi mdi-file-document"></i>
                                    Download Berkas
                                    <span class="mdi mdi-download"></span>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div> --}}

<script>
    $(document).ready(function(){
        tinymce.remove();
        tinymce.init({
            selector: ".htmlEditor",
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table directionality emoticons template paste",
            ],
            menubar: "edit view insert format tools table tc help",
            toolbar:
                "undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | fullscreen  preview save | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment",
            setup: function (editor) {
                editor.on('change', function (e) {
                    var x = editor.getContent({format: 'text'})
                    $('.value_html').html(x)
                });
	        },
            height: 250
        });

        $('.modal-toggle').on('click', function(){
            $('input[name="sub_process"]').val($(this).data('subprocess'))
            $('input[name="process_id"]').val($(this).data('process_id'))

            var subProcess = $(this).data('subprocess_name').split(' ').join('_')
            subProcess = subProcess.toLowerCase()
            let kasus_id = $(this).data('kasus_id')

            // BAI
            $('.bai_sipil').attr('href', `/print/bai-sipil/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`)
            $('.bai_anggota').attr('href', `/print/bai-anggota/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`)

            if ($(`#${subProcess}`).length > 0){
                $(`#${subProcess}`).modal('show')
            } else {
                let url = `/print/${subProcess}/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`
                window.location.href = url
            }

        })

        $('#form-generate-sprin').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/surat-perintah/{{ $kasus->id }}/not_generated`,
                method: 'GET',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
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

        $('#form-generate-sp2hp2').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/surat-sp2hp2-awal/{{ $kasus->id }}/not-generated`,
                method: 'GET',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
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
</script>
