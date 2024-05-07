{{-- @prepend('styles') --}}
<style>
    .select2-selection__rendered {
        line-height: 2.5rem !important;
        /* padding-left: 1rem !important */
    }

    .select2-container .select2-selection--single {
        height: 3.5rem !important;
    }

    .select2-selection__arrow {
        height: 100% !important;
    }
</style>
{{-- @endprepend --}}
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
                    <p>Disposisi Diterima</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Penyelidikan</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Gelar Lidik</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Pemberkasan</p>
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
            <input autocomplete="off" type="text" class="form-control" value="{{ $kasus->id }}" hidden
                name="kasus_id">
            <input autocomplete="off" type="text" class="form-control" value="{{ $kasus->status_id }}" hidden
                name="process_id">
            <input autocomplete="off" type="hidden" name="next" value="pulbaket">
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="text" class="form-control border-dark required"
                            name="no_nota_dinas" id="no_nota_dinas" placeholder="No. Nota Dinas"
                            value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" required>
                        <label for="no_nota_dinas">No. Nota Dinas</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="text" class="form-control border-dark required"
                            name="perihal_nota_dinas" id="perihal_nota_dinas" placeholder="Perihal Nota Dinas"
                            value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" required>
                        <label for="perihal_nota_dinas">Perihal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="date" name="tanggal_nota_dinas"
                            class="form-control border-dark required" id="datepicker" placeholder="Tanggal Nota Dinas"
                            value="{{ isset($kasus) ? \Carbon\Carbon::parse($kasus->tanggal_nota_dinas)->format('Y-m-d') : '' }}"
                            required>
                        <label for="tanggal_nota_dinas">Tanggal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-0" style="display: none;">
                    <center>
                        <div class="form-label">
                            <label for="check-box">Tipe Pelanggaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input autocomplete="off" class="form-check-input border-dark" type="checkbox"
                                id="disiplin" name="disiplin" value="1" checked>
                            <label class="form-check-label " for="disiplin">Disiplin</label>
                        </div>
                    </center>
                </div>

                <div class="col-lg-6 mb-3">
                    {{-- <div class="form-group">
                        <label for="wujud_perbuatan">Wujud Perbuatan</label>
                        <select name="wujud_perbuatan" id="wujud_perbuatan" class="form-select select2" data-placeholder="Silahkan Pilih Wujud Perbuatan">
                        </select>
                    </div> --}}
                    <div class="form-floating">
                        <select class="form-select border-dark select2 required" aria-label="Default select example"
                            name="wujud_perbuatan"id="wujud_perbuatan" required
                            data-placeholder="Silahkan Pilih Wujud Perbuatan">
                            <option></option>
                        </select>
                        <label for="wujud_perbuatan" class="form-label">Wujud Perbuatan</label>
                    </div>
                </div>

                @if ($kasus->data_from == 'yanduan')
                    <div class="col-lg-12 mb-3">
                        <div class="form-floating">
                            <input autocomplete="off" type="text" name="kategori_yanduan" id=""
                                class="form-control border-grey" disabled
                                value="{{ $kasus->kategoriYanduan != null ? $kasus->kategoriYanduan->name : '' }}">
                            <label for="wujud_perbuatan" class="form-label">Kategori Yanduan</label>
                        </div>
                    </div>
                @endif
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="pelapor" id="pelapor" placeholder="Nama Pelapor"
                                    value="{{ isset($kasus) ? $kasus->pelapor : '' }}" required>
                                <label for="pelapor">Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="number" class="form-control border-dark required"
                                    name="umur" id="umur" placeholder="Umur Pelapor"
                                    value="{{ isset($kasus) ? $kasus->umur : '' }}" required>
                                <label for="umur">Umur</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark required" aria-label="Default select example"
                                    name="jenis_kelamin" id="jenis_kelamin" required
                                    data-placeholder="Pilih Jenis Kelamin">
                                    <option></option>
                                    @if (isset($jenis_kelamin))
                                        @foreach ($jenis_kelamin as $key => $jk)
                                            <option value="{{ $jk->id }}"
                                                {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : '') : '' }}>
                                                {{ $jk->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_kelamin" class="form-label">-- Pilih Jenis Kelamin --</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" name="pekerjaan"
                                    class="form-control border-dark required" placeholder="Pekerjaan Pelapor"
                                    value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}" required>
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark required" aria-label="Default select example"
                                    name="agama" id="agama" required data-placeholder="Pilih Agama">
                                    <option></option>
                                    @if (isset($agama))
                                        @foreach ($agama as $key => $ag)
                                            <option value="{{ $ag->id }}"
                                                {{ $kasus->agama == $ag->id ? 'selected' : '' }}>{{ $ag->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="agama" class="form-label">-- Pilih Agama --</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" name="no_identitas" id="no_identitas"
                                    placeholder="1234-5678-9012-1234" class="form-control border-dark required"
                                    value="{{ isset($kasus) ? $kasus->no_identitas : '' }}" required>
                                <label for="no_identitas" class="form-label">No Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark required" aria-label="Default select example"
                                    name="jenis_identitas"id="jenis-identitas" required
                                    data-placeholder="Silahkan Pilih Identitas">
                                    <option></option>
                                    @if (isset($jenis_identitas))
                                        @foreach ($jenis_identitas as $key => $ji)
                                            <option value="{{ $ji->id }}"
                                                {{ $kasus->jenis_identitas == $ji->id ? 'selected' : '' }}>
                                                {{ $ji->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_identitas" class="form-label">-- Pilih Jenis Identitas --</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            @if ($kasus->data_from == 'yanduan' && $kasus->identityReference != null)
                                <div class="col-lg-12 mb-3">
                                    <div>
                                        <span>Identity Detail</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a href="{{ $kasus->identityReference->id_card }}" target="_blank">ID
                                                Card</a>
                                        </div>
                                        <div class="col-md-3">
                                            <a href="{{ $kasus->identityReference->selfie }}"
                                                target="_blank">Selfie</a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" name="no_telp" id="no_telp"
                                    placeholder="No. Telp Pelapor" class="form-control border-dark required"
                                    value="{{ isset($kasus) ? $kasus->no_telp : '' }}" required>
                                <label for="no_telp" class="form-label">No. Telepon Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark required" name="alamat" placeholder="Alamat" id="floatingTextarea"
                                    value="{{ isset($kasus) ? $kasus->alamat : '' }}" style="height: 235px" required>{{ isset($kasus) ? $kasus->alamat : '' }}</textarea>
                                <label for="floatingTextarea" class="form-label">Alamat</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="nrp" id="nrp" placeholder="NRP Terduga Pelanggar"
                                    value="{{ isset($kasus) ? $kasus->nrp : '' }}" required>
                                <label for="nrp">NRP</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="terlapor" id="terlapor" placeholder="Nama Terlapor"
                                    value="{{ isset($kasus) ? $kasus->terlapor : '' }}" required>
                                <label for="terlapor">Nama Terlapor</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark required select2" name="pangkat"
                                    id="pangkat" data-placeholder="Silahkan Pilih Pangkat">
                                    <option></option>
                                    @foreach ($pangkats as $pangkat)
                                        <option value="{{ $pangkat->id }}"
                                            {{ $pangkat->id == $kasus->pangkat ? 'selected' : '' }}>
                                            {{ $pangkat->name }}</option>
                                    @endforeach
                                </select>
                                <label for="pangkat">Pangkat Terlapor</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="jabatan" id="jabatan" placeholder="Jabatan Terduga Pelanggar"
                                    value="{{ isset($kasus) ? $kasus->jabatan : '' }}" required>
                                <label for="jabatan">Jabatan Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="kesatuan" id="kesatuan" placeholder="Kesatuan Terlapor"
                                    value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" required>
                                <label for="kesatuan">Kesatuan Terlapor</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select name="wilayah_hukum" id="wilayah_hukum"
                                    class="form-control form-select required" data-placeholder="Pilih Mabes/Polda">
                                    <option></option>
                                    @foreach ($polda as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $item->id == $kasus->wilayah_hukum ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                {{-- <input autocomplete="off" type="text" class="form-control border-dark required" name="wilayah_hukum" id="wilayah_hukum" placeholder="Mabes/Polda" value="{{ isset($kasus) ? $kasus->wilayah_hukum : '' }}" required> --}}
                                <label for="wilayah_hukum">Mabes/Polda</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="tempat_kejadian" id="tempat_kejadian" placeholder="Tempat Kejadian"
                                    value="{{ isset($kasus) ? $kasus->tempat_kejadian : '' }}" required>
                                <label for="tempat_kejadian">Tempat Kejadian</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="date" name="tanggal_kejadian"
                                    class="form-control border-dark required"
                                    value="{{ isset($kasus) ? \Carbon\Carbon::parse($kasus->tanggal_kejadian)->format('Y-m-d') : '' }}"
                                    required>
                                <label for="tempat_kejadian">Tanggal Kejadian</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark required"
                                    name="nama_korban" id="nama_korban" placeholder="Nama korban"
                                    value="{{ isset($kasus) ? $kasus->nama_korban : '' }}" required>
                                <label for="nama_korban">Nama Korban</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark required" name="kronologis" placeholder="Kronologis" id="kronologis"
                                    value="{{ isset($kasus) ? $kasus->kronologi : '' }}" style="height: 161px" required>{{ isset($kasus) ? $kasus->kronologi : '' }}</textarea>
                                <label for="kronologis" class="form-label">Kronologis</label>
                            </div>
                        </div>

                        @if ($kasus->data_from == 'yanduan' && count($kasus->evidenceReference) > 0)
                            <div class="col-lg-12 mb-3">
                                <div>
                                    <span>Evidences Detail</span>
                                </div>
                                <div class="row">
                                    @foreach ($kasus->evidenceReference as $key => $evidence)
                                        <div class="col-md-3">
                                            <a href="{{ $evidence->evidence_path }}" target="_blank">Evidence
                                                {{ $key + 1 }}</a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Document Download --}}
                <div class="col-lg-12" id="container-download" style="display: none !important;">
                    @if ($kasus->status_id != 8 && $kasus->status_id != 9 && $kasus->status_id != 10)
                        {{-- <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Download Berkas Disposisi</label>
                            <button class="btn btn-primary" style="width: 100%" data-bs-toggle="modal"
                                data-bs-target="#modal_disposisi" type="button">Download</button>
                        </div> --}}
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label" style="; width: 100%">Download
                                Berkas</label>
                            @foreach ($sub_process as $sb)
                                <p>
                                    <a href="#" class="text-primary generate_document"
                                        style="text-decoration: none; width: 100%"
                                        data-process_id="{{ $kasus->status_id }}"
                                        data-kasus_id="{{ $kasus->id }}"
                                        data-subprocess_name="{{ $sb->name }}"
                                        data-subprocess="{{ $sb->id }}">
                                        <i class="mdi mdi-file-document"></i>
                                        {{ $sb->name }} {{ getNoAgenda(explode(' ', $sb->name)[1], $kasus->id) }}
                                        <span class="mdi mdi-download"></span>
                                    </a>
                                </p>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            @if ($kasus->status_id != 8 && $kasus->status_id != 9 && $kasus->status_id != 10)
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            @if($user != 'urtu')
                                <div class="col-6" id="container-btn-status" style="display: none !important">
                                    {{-- <button class="btn btn-success submit" type="submit" value="update_data" name="type_submit">Update
                                        Data</button> --}}
                                    <button class="btn btn-primary submit" type="submit"
                                        value="{{ $kasus->status_id }}"  name="status"
                                        {{ $kasus->status_id > 2 || $kasus->status_id == 1 ? 'disabled' : '' }}>Update
                                        Status (Penyelidikan)</button>
                                </div>
                            @endif
                            <div class="col-6">
                                <button class="btn btn-update-diterima btn-success submit" type="submit"
                                    value="update_data" name="status">
                                    <i class="far fa-upload"></i> Update Data
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-6">
                        <button class="btn btn-update-diterima btn-success" type="submit" value="update_data"
                            disabled name="type_submit">
                            <i class="far fa-upload"></i> Update Data
                        </button>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>

<div class="modal fade" id="lembar_disposisi" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Template Disposisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/lembar-disposisi" method="post"> --}}
            <form action="javascript:void(0)" id="form-disposisi">
                @csrf
                <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                <input autocomplete="off" type="hidden" name="sub_process">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nomor Agenda :</label>
                        <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                            aria-describedby="emailHelp" name="nomor_agenda">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Surat dari :</label>
                        <input autocomplete="off" type="text" class="form-control" id="surat_dari"
                            aria-describedby="emailHelp" name="surat_dari">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                        <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                            name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Tanggal</label>
                        <input autocomplete="off" type="date" class="form-control" id="tanggal" name="tanggal"
                            value="{{ $kasus->tanggal_nota_dinas }}" readonly>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Perihal</label>
                        <input autocomplete="off" type="text" class="form-control" id="perihal" name="perihal">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="disposisi_karo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Disposisi Karo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/lembar-disposisi" method="post"> --}}
            @if (!empty($disposisiKaro))
                <form action="javascript:void(0)" id="form-disposisi-karo" enctype="multipart/form-data">
                    @csrf
                    <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                    <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                                        name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Agenda</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                                        name="nomor_agenda"
                                        value="{{ $disposisiKaro != null ? $disposisiKaro->no_agenda : '' }}"
                                        @if ($disposisiKaro != null) readonly @endif>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Klasifikasi</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi1" value="Biasa"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Biasa')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi2" value="Rahasia"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Rahasia')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi2">
                                                Rahasia
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Derajat</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat1" value="Biasa"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Biasa')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat2" value="Kilat"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Kilat')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat2">
                                                Kilat
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ asset('document/disposisi/karo/' . $disposisiKaro->document_path) }}"
                                target="_blank" class="text-primary" style="text-decoration: none; width: 100%">
                                <i class="mdi mdi-eye"></i>
                                Lihat Berkas Disposisi yang Diupload
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            @else
                <form action="javascript:void(0)" id="form-disposisi-karo" enctype="multipart/form-data">
                    @csrf
                    <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                    <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                            <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                                name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Nomor Agenda</label>
                            <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                                name="nomor_agenda"
                                value="{{ $disposisiKaro != null ? $disposisiKaro->no_agenda : '' }}"
                                @if ($disposisiKaro != null) readonly @endif>
                        </div>
                        <fieldset class="form-group row mb-4">
                            <legend class="col-form-label">Klasifikasi</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input autocomplete="off" class="form-check-input" type="radio"
                                        name="klasifikasi" id="klasifikasi1" value="Biasa"
                                        @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Biasa')
                                        @checked(true)
                                    @else
                                        @disabled(true) @endif
                                        @endif>
                                    <label class="form-check-label" for="klasifikasi1">
                                        Biasa
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input autocomplete="off" class="form-check-input" type="radio"
                                        name="klasifikasi" id="klasifikasi2" value="Rahasia"
                                        @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Rahasia')
                                        @checked(true)
                                    @else
                                        @disabled(true) @endif
                                        @endif>
                                    <label class="form-check-label" for="klasifikasi2">
                                        Rahasia
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="form-group row mb-4">
                            <legend class="col-form-label">Derajat</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input autocomplete="off" class="form-check-input" type="radio" name="derajat"
                                        id="derajat1" value="Biasa"
                                        @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Biasa')
                                        @checked(true)
                                    @else
                                        @disabled(true) @endif
                                        @endif>
                                    <label class="form-check-label" for="derajat1">
                                        Biasa
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input autocomplete="off" class="form-check-input" type="radio" name="derajat"
                                        id="derajat2" value="Kilat"
                                        @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Kilat')
                                        @checked(true)
                                    @else
                                        @disabled(true) @endif
                                        @endif>
                                    <label class="form-check-label" for="derajat2">
                                        Kilat
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="exampleInputPassword1" class="form-label">Tanggal Diterima</label>
                                    <input autocomplete="off" type="date" class="form-control" id="tanggal"
                                        name="tanggal">
                                </div>
                                <div class="col-6">
                                    <label for="exampleInputPassword1" class="form-label">Jam Diterima</label>
                                    <input autocomplete="off" type="time" class="form-control" id="jam"
                                        name="jam">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document">Upload Berkas Disposisi (max 300KB)</label>
                            <input autocomplete="off" class="form-input form-control" type="file" id="document"
                                name="dokumen_disposisi" multiple accept=".pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="disposisi_sesro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Disposisi Sesro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/lembar-disposisi" method="post"> --}}
            @if (!empty($disposisiSesro))
                <form action="javascript:void(0)" id="form-disposisi-sesro" enctype="multipart/form-data">
                    @csrf
                    <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                    <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                                        name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Agenda</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                                        name="nomor_agenda"
                                        value="{{ $disposisiSesro != null ? $disposisiSesro->no_agenda : '' }}"
                                        @if ($disposisiSesro != null) readonly @endif>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Klasifikasi</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi1" value="Biasa"
                                                @if ($disposisiSesro != null) @if ($disposisiSesro->klasifikasi == 'Biasa')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi2" value="Rahasia"
                                                @if ($disposisiSesro != null) @if ($disposisiSesro->klasifikasi == 'Rahasia')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi2">
                                                Rahasia
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Derajat</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat1" value="Biasa"
                                                @if ($disposisiSesro != null) @if ($disposisiSesro->derajat == 'Biasa')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat2" value="Kilat"
                                                @if ($disposisiSesro != null) @if ($disposisiSesro->derajat == 'Kilat')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat2">
                                                Kilat
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ asset('document/disposisi/sesro/' . $disposisiSesro->document_path) }}"
                                target="_blank" class="text-primary" style="text-decoration: none; width: 100%">
                                <i class="mdi mdi-eye"></i>
                                Lihat Berkas Disposisi yang Diupload
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            @else
                <form action="javascript:void(0)" id="form-disposisi-sesro" enctype="multipart/form-data">
                    @csrf
                    <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                    <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                                        name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Agenda</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                                        name="nomor_agenda"
                                        value="{{ $disposisiSesro != null ? $disposisiSesro->no_agenda : '' }}"
                                        @if ($disposisiSesro != null) readonly @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Klasifikasi</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi1" value="Biasa"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Biasa')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi2" value="Rahasia"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Rahasia')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi2">
                                                Rahasia
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Derajat</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat1" value="Biasa"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Biasa')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat2" value="Kilat"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Kilat')
                                                @checked(true)
                                            @else
                                                @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat2">
                                                Kilat
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-6">
                                    <label for="exampleInputPassword1" class="form-label">Tanggal Diterima</label>
                                    <input autocomplete="off" type="date" class="form-control" id="tanggal"
                                        name="tanggal">
                                </div>
                                <div class="col-6">
                                    <label for="exampleInputPassword1" class="form-label">Jam Diterima</label>
                                    <input autocomplete="off" type="time" class="form-control" id="jam"
                                        name="jam">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="document">Upload Berkas Disposisi (max 300KB)</label>
                            <input autocomplete="off" class="form-input form-control" type="file" id="document"
                                name="dokumen_disposisi" multiple accept=".pdf">
                        </div>
                        {{-- <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Perihal</label>
                            <input autocomplete="off" type="text" class="form-control" id="perihal" name="perihal">
                        </div> --}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
<div class="modal fade" id="disposisi_kabag_gakkum" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Disposisi Kabaggakkum</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- <form action="/lembar-disposisi" method="post"> --}}
            @if (!empty($disposisiKabag))
                <form action="javascript:void(0)" id="form-disposisi-sesro" enctype="multipart/form-data">
                    @csrf
                    <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                    <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                                        name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Agenda</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                                        name="nomor_agenda"
                                        value="{{ $disposisiKabag != null ? $disposisiKabag->no_agenda : '' }}"
                                        @if ($disposisiKabag != null) readonly @endif>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Klasifikasi</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi1" value="Biasa"
                                                @if ($disposisiKabag != null) @if ($disposisiKabag->klasifikasi == 'Biasa')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi2" value="Rahasia"
                                                @if ($disposisiKabag != null) @if ($disposisiKabag->klasifikasi == 'Rahasia')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi2">
                                                Rahasia
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Derajat</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat1" value="Biasa"
                                                @if ($disposisiKabag != null) @if ($disposisiKabag->derajat == 'Biasa')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat2" value="Kilat"
                                                @if ($disposisiKabag != null) @if ($disposisiKabag->derajat == 'Kilat')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat2">
                                                Kilat
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ asset('document/disposisi/kabag/' . $disposisiKabag->document_path) }}"
                                target="_blank" class="text-primary" style="text-decoration: none; width: 100%">
                                <i class="mdi mdi-eye"></i>
                                Lihat Berkas Disposisi yang Diupload
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            @else
                <form action="javascript:void(0)" id="form-disposisi-kabag" enctype="multipart/form-data">
                    @csrf
                    <input autocomplete="off" type="hidden" name="kasus_id" value="{{ $kasus->id }}">
                    <input autocomplete="off" type="hidden" name="status_id" value="{{ $kasus->status_id }}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Surat</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_surat"
                                        name="nomor_surat" value="{{ $kasus->no_nota_dinas }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="form-group">
                                    <label for="exampleInputPassword1" class="form-label">Nomor Agenda</label>
                                    <input autocomplete="off" type="text" class="form-control" id="nomor_agenda"
                                        name="nomor_agenda"
                                        value="{{ $disposisiKabag != null ? $disposisiKabag->no_agenda : '' }}"
                                        @if ($disposisiKabag != null) readonly @endif>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Klasifikasi</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi1" value="Biasa"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Biasa')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="klasifikasi" id="klasifikasi2" value="Rahasia"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->klasifikasi == 'Rahasia')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="klasifikasi2">
                                                Rahasia
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <fieldset class="form-group row mb-4">
                                    <legend class="col-form-label">Derajat</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat1" value="Biasa"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Biasa')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat1">
                                                Biasa
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input autocomplete="off" class="form-check-input" type="radio"
                                                name="derajat" id="derajat2" value="Kilat"
                                                @if ($disposisiKaro != null) @if ($disposisiKaro->derajat == 'Kilat')
                                                    @checked(true)
                                                @else
                                                    @disabled(true) @endif
                                                @endif>
                                            <label class="form-check-label" for="derajat2">
                                                Kilat
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Tanggal Diterima</label>
                            <input autocomplete="off" type="date" class="form-control" id="tanggal"
                                name="tanggal">
                        </div>
                        {{-- <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Perihal</label>
                                <input autocomplete="off" type="text" class="form-control" id="perihal" name="perihal">
                            </div> --}}

                        {{-- Form Pemeriksa --}}
                        <div class="card card-data-penyidik">
                            <div class="card-header">Unit Pemeriksa</div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="">Pilih Unit Pemeriksa</label>
                                    <select name="unit_pemeriksa" id="" class="form-control"
                                        data-placeholder="Silahkan Pilih Unit Pemeriksa">
                                        <option></option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->unit }}">{{ $item->unit }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="container mt-5" id="preview_anggota" style="display: none">
                                    <h6>Preview Anggota Unit</h6>
                                    <div class="table-responsive table-card px-3">
                                        <table class="table table-centered align-middle table-nowrap mb-0"
                                            id="data-data">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Nama</th>
                                                    <th scope="col">NRP</th>
                                                    <th scope="col">Pangkat</th>
                                                    <th scope="col">Jabatan</th>
                                                    <th scope="col">Tim</th>
                                                    <th scope="col">Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="document">Upload Berkas Disposisi (max 300KB)</label>
                            <input autocomplete="off" class="form-input form-control" type="file"
                                id="document" name="dokumen_disposisi" multiple accept=".pdf">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Generate</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    let user = `{{ $user }}`
    $(document).ready(function() {
        // $('.select2').map((k, v) => {
        $('.select2').select2({
            theme: 'default'
        })
        // })

        $('input[type="time"]').on('keydown', function() {
            return false
        })

        $('input[type="date"]').on('keydown', function() {
            return false
        })

        $('.submit').on('click', function() {
            var data = $('#form').serializeArray()
            data.push({
                name: $(this).attr('name'),
                value: $(this).val()
            })

            // validasi
            validation((canInput) => {
                $.ajax({
                    url: '/data-kasus/update',
                    method: 'POST',
                    data: data,
                    beforeSend: () => {
                        $.LoadingOverlay("show");
                    },
                    success: (res) => {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Berhasil',
                            text: $(this).val() == 'update_data' ?
                                'Berhasil Update Data' :
                                'Berhasil rubah status',
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        })

                        if ($(this).val() != 'update_status') window.location
                            .reload();
                    },
                    error: (xhr) => {
                        $.LoadingOverlay("hide");
                        // console.log(xhr.responseJSON.status.msg)
                        Swal.fire({
                            title: `Terjadi Kesalahan`,
                            html: '<span>' + xhr.responseJSON.status.msg +
                                '</span>',
                            // text: `${xhr.responseJSON.status.msg}`,
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

        $('#form-disposisi').on('submit', function() {
            var data = $(this).serializeArray()
            validation(() => {
                $.ajax({
                    url: `/lembar-disposisi`,
                    method: 'POST',
                    data: data,
                    beforeSend: () => {
                        $.LoadingOverlay("show");
                    },
                    success: (res) => {
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

        $('#form-disposisi-karo').on('submit', function() {
            const form = $(this)
            var formData = new FormData(form[0]);
            validation(() => {
                $.ajax({
                    url: `/lembar-disposisi-karo`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $.LoadingOverlay("show");
                    },
                    success: (res) => {
                        // window.location.href = `/download-file/${res.file}`

                        setTimeout(() => {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil buat disposisi karo',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            })

                            window.location.reload()
                            $(this).parentsUntil('.modal').parent().modal(
                                'hide')
                        }, 2500);

                    },
                    error: (xhr) => {
                        $.LoadingOverlay("hide");
                        onAjaxError(xhr)
                    }
                })
            })
        })

        $('#form-disposisi-sesro').on('submit', function() {
            const form = $(this)
            var formData = new FormData(form[0]);
            validation(() => {
                $.ajax({
                    url: `/lembar-disposisi-sesro`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $.LoadingOverlay("show");
                    },
                    success: (res) => {
                        // window.location.href = `/download-file/${res.file}`

                        setTimeout(() => {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil buat disposisi sesro',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            })

                            window.location.reload()
                            // $(this).parentsUntil('.modal').parent().modal('hide')
                        }, 2500);

                    },
                    error: (xhr) => {
                        $.LoadingOverlay("hide");
                        onAjaxError(xhr)
                    }
                })
            })
        })

        $('#form-disposisi-kabag').on('submit', function() {
            const form = $(this)
            var formData = new FormData(form[0]);
            validation(() => {
                $.ajax({
                    url: `/lembar-disposisi-kabag`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $.LoadingOverlay("show");
                    },
                    success: (res) => {
                        // window.location.href = `/download-file/${res.file}`

                        setTimeout(() => {
                            $.LoadingOverlay("hide");
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil buat disposisi kabag',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            })

                            window.location.reload()
                            // $(this).parentsUntil('.modal').parent().modal('hide')
                        }, 2500);

                    },
                    error: (xhr) => {
                        $.LoadingOverlay("hide");
                        onAjaxError(xhr)
                    }
                })
            })
        })


        $('.generate_document').on('click', function() {
            $('input[name="sub_process"]').val($(this).data('subprocess'))
            $('input[name="process_id"]').val($(this).data('process_id'))

            var subProcess = $(this).data('subprocess_name').split(' ').join('_').split('/').join('')
            subProcess = subProcess.toLowerCase()
            let kasus_id = $(this).data('kasus_id')

            if ($(`#${subProcess}`).length > 0) {
                $(`#${subProcess}`).modal('show')
            } else {
                let url =
                    `/print/${subProcess}/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`
                window.location.href = url
            }

        })

        $('.form-select').select2({
            theme: 'bootstrap-5'
        })
        $('select[name="unit_pemeriksa"]').select2({
            theme: 'bootstrap-5',
            dropdownParent: $('#disposisi_kabag_gakkum .modal-content')
        })

        $('select[name="unit_pemeriksa"]').on('change', function() {
            $('#data-data').DataTable().destroy()

            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('penyidik.data') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                        data.unit = $('select[name="unit_pemeriksa"] option').filter(
                            ':selected').val()
                    }
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'nrp',
                        name: 'nrp'
                    },
                    {
                        data: 'pangkats.name',
                        name: 'pangkats.name'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                    {
                        data: 'tim',
                        name: 'tim'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                ]
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });

            $('#preview_anggota').fadeIn()
        })

        getValDisiplin()

        validation((canInput) => {
            if (canInput == true) {
                $('#container-download').fadeIn()
                $('#container-btn-status').fadeIn()
            }
        })
    })

    function validation(callback) {
        const formId = $('#form')
        var canInput = true

        if(user == 'urtu' || user == 'kabaggakkum'){
            canInput = true
            callback(canInput)
        } else {
            $(formId).find('.required').removeClass('is-invalid')
            $(formId).find('.required').each((k, v) => {
                if ($(v).val() == '') {
                    canInput = false
                    $(v).addClass('is-invalid')
                }
            })

            if (canInput == false) {
                Swal.fire({
                    title: `Masih ada data dumas yang kosong!`,
                    text: `Harap lengkapi data dumas terlebih dahulu`,
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                })
            } else {
                callback(canInput)
            }
        }
    }

    function getValDisiplin() {
        let kasus_wp = `{{ isset($kasus) ? $kasus->wujud_perbuatan : '' }}`;
        let list_ketdis = new Array();
        list_ketdis = `{{ $disiplin }}`;
        list_ketdis = list_ketdis.split('|');

        let list_id_dis = new Array();
        list_id_dis = `{{ $id_disiplin }}`;
        list_id_dis = list_id_dis.split('|');

        let html_wp = `<option value="">-- Pilih Wujud Perbuatan --</option>`;
        for (let index = 0; index < list_ketdis.length; index++) {
            const el_ketdis = list_ketdis[index];
            const el_id_dis = list_id_dis[index];
            if (kasus_wp != '' && kasus_wp == el_id_dis) {
                html_wp += `<option value="` + el_id_dis + `" selected>` + el_ketdis + `</option>`;
            } else {
                html_wp += `<option value="` + el_id_dis + `">` + el_ketdis + `</option>`;
            }
        }
        $('#wujud_perbuatan').html(html_wp);
    }
</script>
