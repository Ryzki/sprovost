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
                    <p>Disposisi Diterima</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Pemeriksaan</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                    <p>Gelar Lidik</p>
                </div>
                <div class="f1-step active">
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
    <div class="col-lg-12 mt-4">
        {{-- <form action="/data-kasus/update" method="post"> --}}
        <form action="javascript:void(0)" id="form">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input type="text" class="form-control" value="{{ $kasus->status_id }}" hidden name="status">

            {{-- Nav Ringkasan Data --}}
            <nav>
                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-dt-pelanggar-tab" data-bs-toggle="tab" data-bs-target="#nav-dt-pelanggar" type="button" role="tab" aria-controls="nav-dt-pelanggar" aria-selected="true">Ringkasan Data Pelanggar</button>
                    <button class="nav-link" id="nav-dt-penyelidikan-tab" data-bs-toggle="tab" data-bs-target="#nav-dt-penyelidikan" type="button" role="tab" aria-controls="nav-dt-penyelidikan" aria-selected="false">Ringkasan Data Pemeriksaan</button>
                    <button class="nav-link" id="nav-dt-gelar-lidik-tab" data-bs-toggle="tab" data-bs-target="#nav-dt-gelar-lidik" type="button" role="tab" aria-controls="nav-dt-gelar-lidik" aria-selected="false">Ringkasan Data Gelar Lidik</button>
                </div>
            </nav>

            <div class="tab-content p-2" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-dt-pelanggar" role="tabpanel" aria-labelledby="nav-dt-pelanggar-tab">
                    @include('pages.data_pelanggaran.proses.ringkasanDataPelanggar')
                </div>
                <div class="tab-pane fade" id="nav-dt-penyelidikan" role="tabpanel" aria-labelledby="nav-dt-penyelidikan-tab">
                    @include('pages.data_pelanggaran.proses.ringkasanDataPemeriksaan')
                </div>
                <div class="tab-pane fade" id="nav-dt-gelar-lidik" role="tabpanel" aria-labelledby="nav-dt-gelar-lidik-tab">
                    @include('pages.data_pelanggaran.proses.ringkasanDataGelarLidik')
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
            @if ($lpa == null)
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        Harap Buat Dokumen LPA Terlebih Dahulu
                    </div>
                </div>
            @else
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
                                        value="{{ !empty($sprinRiksa) ? date('d-m-Y H:i', strtotime($sprinRiksa->created_at)) . ' WIB' : '-' }}"
                                        readonly style="border:none">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleInputEmail1" class="form-label">Dicetak Oleh</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1"
                                        aria-describedby="emailHelp"
                                        value="{{ !empty($sprinRiksa) ? $sprinRiksa->user[0]->name: '-' }}"
                                        readonly style="border:none">
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if ($sprinRiksa == null)
                            <div class="form-group">
                                <label for="no_sprin" class="form-label">No. SPRIN</label>
                                <input type="text" class="form-control" name="no_sprin" value="{{!empty($sprinRiksa) ? $sprinRiksa->no_sprin : ''}}" placeholder="{{!empty($sprinRiksa) ? '' : 'Masukan Nomor SPRIN'}}">
                            </div>

                            <!-- Input data penyidik -->
                            {{-- <div class="card card-data-penyidik">
                                <div class="card-header">Input Data Penyelidik</div>
                                <div class="card-body">
                                    <div class="mb-3" id="form_input_anggota">
                                        <div class="form_penyelidik">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-outline mb-3">
                                                        <select name="pangkat" class="form-control form-select select-pangkat" data-placeholder="Pangkat Penyelidik">
                                                            <option></option>
                                                            @foreach ($pangkats as $item)
                                                                <option value="{{$item->name}}">{{$item->name}}</option>
                                                            @endforeach
                                                        </select>
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
                                            </div>
                                        </div>
                                        <hr>
                                    </div>

                                    <div class="d-flex mb-3 justify-content-between">
                                        <span onclick="tambahAnggota(this)" class="text-primary" style="cursor: pointer"> <i class="far fa-plus-square"></i>
                                            Anggota </span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card card-data-penyidik">
                                <div class="card-header">Unit Pemeriksa</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="">Pilih Unit Pemeriksa</label>
                                        <select name="unit_pemeriksa" id="" class="form-control form-select" data-placeholder="Silahkan Pilih Unit Pemeriksa">
                                            <option></option>
                                            @foreach ($unit as $item)
                                                <option value="{{$item->unit}}">{{$item->unit}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="container mt-5" id="preview_anggota" style="display: none">
                                        <h6>Preview Anggota Unit</h6>
                                        <div class="table-responsive table-card px-3">
                                            <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
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
                        @if ($sprinRiksa == null)
                            <button type="submit" class="btn btn-primary">Buat Surat</button>
                        @else
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        @endif
                    </div>
                </form>
            @endif
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
            @if ($sprinRiksa == null)
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        Harap Buat Dokumen SPRIN Riksa Terlebih Dahulu
                    </div>
                </div>
            @else
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
                                            <select name="penyidik_1" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Penyidik Pertama"></select>
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
                                                        <option selected disabled>----- Harap Pilih Agama -----</option>
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
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="surat_panggilan_terduga" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Panggilan Terduga</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($sprinRiksa == null)
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        Harap Buat Dokumen SPRIN Riksa Terlebih Dahulu
                    </div>
                </div>
            @else
                <form action="javascript:void(0)" id="form-generate-sp-terduga">
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
                                            <select name="penyidik_1" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Penyidik Pertama"></select>
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Buat Dokumen</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="bap" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Berkas BAP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($sprinRiksa == null)
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        Harap Buat Dokumen SPRIN Riksa Terlebih Dahulu
                    </div>
                </div>
            @else
                <form action="javascript:void(0)" id="form-generate-bap">
                    @csrf
                    <input type="hidden" name="status" value="{{$status->id}}">
                    <input type="hidden" name="sub_process">
                    <input type="hidden" name="process_id">
                    <div class="modal-body">
                        @if ($bap == null)
                            <div class="card" id="data-penyidik">
                                <div class="card-header">
                                    Pilih Penyidik
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="">Penyidik 1</label>
                                            <select name="penyidik_1" id="select_penyidik_1" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Penyidik Pertama"></select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="">Penyidik 2</label>
                                            <select name="penyidik_2" id="select_penyidik_2" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Penyidik Kedua"></select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="card" id="data-penyidik">
                                <div class="card-header">
                                    Pilih Penyidik
                                </div>
                                <div class="card-body row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="">Penyidik 1</label>
                                            <input type="text" class="form-control" disabled value="{{$penyidik1->pangkat}} {{$penyidik1->name}} - {{$penyidik1->jabatan}}">
                                            <select name="penyidik_1" hidden>
                                                <option value="{{$bap->penyidik1}}" selected></option>
                                            </select>
                                            {{-- <input name="penyidik1" type="hidden" value="{{$bai->penyidik1}}"/> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="">Penyidik 2</label>
                                            <input type="text" class="form-control" disabled value="{{$penyidik2->pangkat}} {{$penyidik2->name}} - {{$penyidik2->jabatan}}">
                                            <select name="penyidik_2" hidden>
                                                <option value="{{$bap->penyidik2}}" selected></option>
                                            </select>
                                            {{-- <input name="penyidik2" type="hidden" value="{{$bai->penyidik2}}"/> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (count($saksiAhli) == 0)
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
                                                    <label for="pangkat">Pangkat</label>
                                                    <input type="text" name="pangkat" class="form-control" placeholder="Masukan Pangkat">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="jabatan">Jabatan</label>
                                                    <input type="text" name="jabatan" class="form-control" placeholder="Masukan Jabatan">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="nrp">NRP</label>
                                                    <input type="text" name="nrp" class="form-control" placeholder="Masukan NRP" onclick="mask(this, '99999999')" onchange="mask(this, '99999999')" onfocus="mask(this, '99999999')">
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="kesatuan">Kesatuan</label>
                                                    <input type="text" name="kesatuan" class="form-control" placeholder="Masukan Kesatuan">
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
                                                        <option selected disabled>----- Harap Pilih Agama -----</option>
                                                        @foreach ($agamas as $agama)
                                                            <option value="{{$agama->id}}">{{$agama->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="alamat">Alamat</label>
                                                    <textarea name="alamat" class="form-control" cols="8" rows="5"></textarea>
                                                    {{-- <input type="text" name="agama" class="form-control" placeholder="Masukan Warga Negara"> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="no_telp">No. Telp</label>
                                                    <input type="text" name="no_telp" class="form-control" placeholder="Masukan Nomor Telepon"onclick="mask(this, '999999999999999')" onchange="mask(this, '999999999999999')">
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
                                    @foreach ($saksiAhli as $s)
                                        <li class="list-group-item" style="background-color: #a0d7fffb">
                                            <p> {{$s->pangkat}} {{$s->nama}} {{$s->jabatan}} {{$s->kesatuan}} - {{$s->nrp}} </p>
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
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="dp3d" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Berkas DP3D</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if ($lpa == null)
                <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                    <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </symbol>
                </svg>
                <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                    <div>
                        Harap Buat Dokumen LPA Terlebih Dahulu
                    </div>
                </div>
            @else
                <form action="javascript:void(0)" id="form-generate-dp3d">
                    @csrf
                    <input type="hidden" name="status" value="{{$status->id}}">
                    <input type="hidden" name="sub_process">
                    <input type="hidden" name="process_id">
                    <div class="modal-body">
                        @if ($dp3d == null)
                            <div class="card" id="data-dihadap">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="no_dp3d">Nomor DP3D</label>
                                        <input type="text" name="no_dp3d" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="pasal">Pasal yang dilanggar</label>
                                        <textarea name="pasal" class="form-control" id="" cols="30" rows="5">{{$gelarPerkara->landasan_hukum}}</textarea>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="/print/dp3d/{{$kasus->id}}/generated" class="text-primary" style="text-decoration: none; width: 100%">
                                <i class="mdi mdi-file-document"></i>
                                Download Ulang DP3D
                                <span class="mdi mdi-download"></span>
                            </a>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($dp3d == null)
                            <button type="submit" class="btn btn-primary">Buat Dokumen</button>
                        @else
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                        @endif
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('select[name="unit_pemeriksa"]').select2({
            theme: 'bootstrap-5',
            dropdownParent : $('#sprin_riksa .modal-content')
        })

        $('#header-saksi').on('click', function(){
            if($('#body-saksi').css('display') == 'none'){
                $('#body-saksi').slideDown()
            } else {
                $('#body-saksi').slideUp()
            }
        })

        $('input[type="time"]').on('keydown', function(){
                return false
        })

        $('input[type="date"]').on('keydown', function(){
            return false
        })

        $('.generate_document').on('click', function(){
            $('input[name="sub_process"]').val($(this).data('subprocess'))
            $('input[name="process_id"]').val($(this).data('process_id'))

            var subProcess = $(this).data('subprocess_name').split(' ').join('_')
            subProcess = subProcess.toLowerCase()
            let kasus_id = $(this).data('kasus_id')

            if ($(`#${subProcess}`).length > 0){
                if (subProcess == 'surat_panggilan_saksi' || subProcess == 'bap' || subProcess == 'surat_panggilan_terduga'){
                    getPenyidik(kasus_id, subProcess)
                }
                if(subProcess == 'sprin_riksa'){
                    $('.select-pangkat').select2({
                        theme: 'bootstrap-5',
                        dropdownParent : $('#sprin_riksa .modal-content')
                    })
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
                    onAjaxError(xhr)
                }
            })
        })

        $('#form-generate-sprin').on('submit', function(){
            var data = new FormData()
            const elemPenyelidik = $('#form_input_anggota').find('.form_penyelidik')
            for (let i = 0; i < elemPenyelidik.length; i++) {
                var nrp = $(elemPenyelidik).find('input[name="nrp"]')[i].value
                nrp = nrp.split('_').join('');
                data.append(`pangkat[${i}]`, $(elemPenyelidik).find('select[name="pangkat"] option').filter(':selected')[i].value)
                data.append(`nama[${i}]`, $(elemPenyelidik).find('input[name="nama_penyelidik"]')[i].value)
                data.append(`nrp[${i}]`, nrp)
                data.append(`jabatan[${i}]`, $(elemPenyelidik).find('input[name="jabatan"]')[i].value)
                data.append(`kesatuan[${i}]`, $(elemPenyelidik).find('input[name="kesatuan"]')[i].value)
            }

            data.append('no_sprin', $('input[name="no_sprin"]').val())
            data.append('process_id', $('input[name="process_id"]').val())
            data.append('sub_process', $('input[name="sub_process"]').val())
            data.append('unit_pemeriksa', $('select[name="unit_pemeriksa"] option').filter(':selected').val())

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
                    onAjaxError(xhr)
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

            data.append('penyidik1', $('#form-generate-sp-saksi').find('select[name="penyidik_1"] option').filter(':selected').val())
            data.append('process_id', $('#form-generate-sp-saksi').find('input[name="process_id"]').val())
            data.append('sub_process', $('#form-generate-sp-saksi').find('input[name="sub_process"]').val())
            data.append('no_telp_penyidik', $('#form-generate-sp-saksi').find('input[name="no_telp_penyidik"]').val())
            data.append('tgl', $('#form-generate-sp-saksi').find('input[name="tgl"]').val())
            data.append('waktu', $('#form-generate-sp-saksi').find('input[name="waktu"]').val())
            data.append('lokasi', $('#form-generate-sp-saksi').find('textarea[name="lokasi"]').val())

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
                    onAjaxError(xhr)
                }
            })
        })

        $('#form-generate-sp-terduga').on('submit', function(){
            var data = $(this).serializeArray()

            $.ajax({
                url: `/print/surat_panggilan_terduga/{{$kasus->id}}`,
                method: 'POST',
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val()
                },
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success: (res) => {
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
                    }, 1000);

                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    onAjaxError(xhr)
                }
            })
        })

        $('#form-generate-bap').on('submit', function(){
            var data = new FormData()
            const elem = $('#container_saksi').find('.form_saksi')
            for (let i = 0; i < elem.length; i++) {
                var nrp = $(elem).find('input[name="nrp"]')[i].value
                nrp = nrp.split('_').join('')
                var telp = $(elem).find('input[name="no_telp"]')[i].value
                telp = telp.split('_').join('')

                data.append(`nama[${i}]`, $(elem).find('input[name="nama"]')[i].value)
                data.append(`pangkat[${i}]`, $(elem).find('select[name="pangkat"] option').filter(':selected')[i].value)
                // data.append(`pangkat[${i}]`, $(elem).find('input[name="pangkat"]')[i].value)
                data.append(`nrp[${i}]`, nrp)
                data.append(`jabatan[${i}]`, $(elem).find('input[name="jabatan"]')[i].value)
                data.append(`kesatuan[${i}]`, $(elem).find('input[name="kesatuan"]')[i].value)
                data.append(`warga_negara[${i}]`, $(elem).find('input[name="warga_negara"]')[i].value)
                data.append(`agama[${i}]`, $(elem).find('select[name="agama"] option').filter(':selected')[i].value)
                data.append(`agamaText[${i}]`, $(elem).find('select[name="agama"] option').filter(':selected')[i].innerHTML)
                data.append(`alamat[${i}]`, $(elem).find('textarea[name="alamat"]')[i].value)
                data.append(`ttl[${i}]`, $(elem).find('input[name="ttl"]')[i].value)
                data.append(`no_telp[${i}]`, telp)
            }

            data.append('penyidik1', $('#form-generate-bap').find('select[name="penyidik_1"] option').filter(':selected').val())
            data.append('penyidik2', $('#form-generate-bap').find('select[name="penyidik_2"] option').filter(':selected').val())
            data.append('process_id', $('#form-generate-bap').find('input[name="process_id"]').val())
            data.append('sub_process', $('#form-generate-bap').find('input[name="sub_process"]').val())

            $.ajax({
                url: `/print/bap/{{$kasus->id}}`,
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
                    onAjaxError(xhr)
                }
            })
        })

        $('#form-generate-dp3d').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/dp3d/{{ $kasus->id }}/not-generated`,
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
                    onAjaxError(xhr)
                    // Swal.fire({
                    //     title: `Terjadi Kesalahan`,
                    //     text: xhr.responseJSON.status.msg,
                    //     icon: 'error',
                    //     toast: true,
                    //     position: 'top-end',
                    //     showConfirmButton: false,
                    //     timer: 3000,
                    //     timerProgressBar: true,
                    // })
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
                    // console.log(xhr.responseJSON.status.msg)
                    Swal.fire({
                        title: `Terjadi Kesalahan`,
                        html: '<span>' + xhr.responseJSON.status.msg + '</span>',
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

        $('select[name="unit_pemeriksa"]').on('change', function(){
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
                        data.unit = $('select[name="unit_pemeriksa"] option').filter(':selected').val()
                    }
                },
                columns: [
                    {
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
    })

    function mask(el, maskVal){
        $(el).inputmask({"mask": maskVal, "placeholder": ''});
    }

    function getPenyidik(kasus_id, modal_id){
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

                $('.select-penyidik').select2({
                    theme: 'bootstrap-5',
                    dropdownParent : $(`#${modal_id} .modal-content`)
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
                        <option selected disabled>----- Harap Pilih Agama -----</option>
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
    function tambahAnggota(el) {
        var addAnggota = localStorage.getItem('addAnggota')
        let parentEl = $(el).parent().parent().find('#form_input_anggota')
        $('.select-pangkat').select2('destroy')
        let duplicateForm = $(el).parent().parent().find('#form_input_anggota').children()[0]
        $(duplicateForm).clone(false).appendTo(parentEl).find('input').val('')

        $('.select-pangkat').select2({
            theme: 'bootstrap-5',
            dropdownParent : $('#sprin_riksa .modal-content')
        })
    }

    function removeSaksi(el){
        $(el).parent().parent().next().remove()
        $(el).parent().parent().remove()
    }
</script>
