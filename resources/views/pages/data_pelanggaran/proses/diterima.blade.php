<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                {{-- <button type="button" class="btn btn-info">Sebelumnya</button> --}}
            </div>
            <div>

                @if ($kasus->status_id > 2)
                    <button type="button" class="btn btn-primary" onclick="getViewProcess(3)">Selanjutnya</button>
                @endif

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" style="text-align: center;">
            <div class="f1-steps">
                <div class="f1-progress">
                    <div class="f1-progress-line" data-now-value="20" data-number-of-steps="5" style="width: 20%;">
                    </div>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                    <p>Diterima</p>
                </div>
                <div class="f1-step">
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
            <div class="row">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pelapor</label>
                            <input type="text" class="form-control" value="{{ $kasus->pelapor }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Umur</label>
                            <input type="text" class="form-control" value="{{ $kasus->umur }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" value="{{ $kasus->jenis_kelamin }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control" value="{{ $kasus->pekerjaan }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Agama</label>
                            <input type="text" class="form-control" value="{{ $kasus->agama }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Alamat</label>
                            <input type="text" class="form-control" value="{{ $kasus->alamat }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">No Identitas</label>
                            <input type="text" class="form-control" value="{{ $kasus->no_identitas }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Jenis Identitas</label>
                            <input type="text" class="form-control" value="{{ $kasus->jenis_identitas }}" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Terlapor</label>
                            <input type="text" class="form-control" value="{{ $kasus->terlapor }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Pangkat</label>
                            <input type="text" class="form-control" value="{{ $kasus->pangkat }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kesatuan</label>
                            <input type="text" class="form-control" value="{{ $kasus->kesatuan }}" readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tempat Kejadian</label>
                            <input type="text" class="form-control" value="{{ $kasus->tempat_kejadian }}"
                                readonly>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Tanggal Kejadian</label>
                            <input type="text" class="form-control" value="{{ $kasus->tanggal_kejadian }}"
                                readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Korban</label>
                            <input type="text" class="form-control" value="{{ $kasus->nama_korban }}" readonly>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Kronologis</label>
                            <input type="text" class="form-control" value="{{ $kasus->kronologi }}" readonly>
                        </div>
                        @if($kasus->status_id != 8)
                            <div class="col-lg-12 mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Download Berkas Disposisi</label>
                                <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                    data-bs-target="#modal_disposisi" type="button">Download</button>
                                {{-- <input type="text" class="form-control" value="{{ $kasus->terlapor }}" readonly> --}}
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label for="exampleFormControlInput1" class="form-label" style="; width: 100%">Download Berkas Lainnya</label>
                                @foreach ($sub_process as $sb)
                                <p>
                                    <a href="#" class="text-primary" style="text-decoration: none; width: 100%">
                                        <i class="mdi mdi-file-document"></i>
                                        {{$sb->name}}
                                        <span class="mdi mdi-download"></span>
                                    </a>
                                </p>
                                @endforeach
                            </div>
                        @endif
                        {{-- <div class="col-lg-12 mb-3">
                            <label for="exampleInputEmail1" class="form-label">Update Status</label>
                            <select class="form-select" aria-label="Default select example" name="disposisi_tujuan" onchange="getPolda()" id="disposisi-tujuan">
                                <option value="">--Update Status--</option>
                                <option value="4">Pulbaket</option>
                                <option value="3" {{ $kasus->status_id == 3 ? 'selected' : '' }}>Limpah
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3" id="limpah-polda">

                        </div> --}}
                    </div>
                </div>
            </div>
            @if ($kasus->status_id != 8)
                <div class="row">
                    <div class="col-lg-12" style="float: right;">
                        {{-- <button class="btn btn-success submit" type="submit" value="update_data" name="type_submit">Update
                            Data</button> --}}
                        <button class="btn btn-primary submit" type="submit" value="{{$kasus->status_id}}" name="type_submit"
                            {{ $kasus->status_id > 2 || $kasus->status_id == 1 ? 'disabled' : '' }}>Update
                            Status (Pulbaket)</button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="modal fade" id="modal_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template Disposisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/lembar-disposisi" method="post"> --}}
            <form action="javascript:void(0)" id="form-disposisi">
                @csrf
                <input type="hidden" name="kasus_id" value="{{$kasus->id}}">
                <input type="hidden" name="status_id" value="{{$kasus->status_id}}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor Agenda :</label>
                        <input type="text" class="form-control" id="nomor_agenda" aria-describedby="emailHelp"
                            name="nomor_agenda">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Surat dari :</label>
                        <input type="text" class="form-control" id="surat_dari" aria-describedby="emailHelp"
                            name="surat_dari">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
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

        $('#form-disposisi').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/lembar-disposisi`,
                method: 'POST',
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
                        text: "Terjadi kesalahan ketika generate file",
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
