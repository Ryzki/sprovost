<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(3)">Sebelumnya</button>
            </div>
            <div>
                @if ($kasus->status_id > 4 && $kasus->status_id != 5 && $kasus->status_id != 9 && $kasus->status_id != 10)
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
                    <p>Disposisi Diterima</p>
                </div>
                <div class="f1-step active">
                    <div class="f1-step-icon"><i class="fa fa-home"></i></div>
                    <p>Pemeriksaan</p>
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
            <input autocomplete="off" type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input autocomplete="off" type="text" class="form-control" value="{{ $kasus->status_id }}" hidden name="status">

            {{-- Nav Ringkasan Data --}}
            <nav>
                <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
                    <button class="nav-link" id="nav-dt-pelanggar-tab" data-bs-toggle="tab" data-bs-target="#nav-dt-pelanggar" type="button" role="tab" aria-controls="nav-dt-pelanggar" aria-selected="true">Ringkasan Data Pelanggar</button>
                    <button class="nav-link" id="nav-dt-penyelidikan-tab" data-bs-toggle="tab" data-bs-target="#nav-dt-penyelidikan" type="button" role="tab" aria-controls="nav-dt-penyelidikan" aria-selected="false">Ringkasan Data Pemeriksaan</button>
                    <button class="nav-link active" id="nav-dt-gelar-lidik-tab" data-bs-toggle="tab" data-bs-target="#nav-dt-gelar-lidik" type="button" role="tab" aria-controls="nav-dt-gelar-lidik" aria-selected="false">Ringkasan Data Gelar Lidik</button>
                </div>
            </nav>

            <div class="tab-content p-2" id="nav-tabContent">
                <div class="tab-pane fade" id="nav-dt-pelanggar" role="tabpanel" aria-labelledby="nav-dt-pelanggar-tab">
                    @include('pages.data_pelanggaran.proses.ringkasanDataPelanggar')
                </div>
                <div class="tab-pane fade" id="nav-dt-penyelidikan" role="tabpanel" aria-labelledby="nav-dt-penyelidikan-tab">
                    @include('pages.data_pelanggaran.proses.ringkasanDataPemeriksaan')
                </div>
                <div class="tab-pane fade active show" id="nav-dt-gelar-lidik" role="tabpanel" aria-labelledby="nav-dt-gelar-lidik-tab">
                    @include('pages.data_pelanggaran.proses.ringkasanDataGelarLidik')
                </div>
            </div>
            <hr>

            @if ($kasus->status_id != 8 && $kasus->status_id != 9 && $kasus->status_id != 10)
                @if($kasus->status_id == 5)
                    <div class="mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                            <div>
                                Kasus telah dilimpahkan ke Polda / Jajaran
                            </div>
                        </div>
                    </div>
                @else
                    @if ($sprinGelar != null && $sprinGelar->is_draft == 1)
                        <div class="mt-4">
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                </symbol>
                            </svg>
                            <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                <div>
                                    Nomor SPRIN Gelar masih Draft, klik <b>Download Berkas SPRIN Gelar</b> untuk update nomor SPRIN Gelar sesuai dengan berkas yang sudah disetujui
                                </div>
                            </div>
                        </div>
                    @endif
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
                                    @if ($sprinGelar != null && !$sprinGelar->is_draft)
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
                            <a class="btn btn-info text-white submit" href="javascript:void(0)" data-next="limpah" data-process_id="{{$kasus->status_id}}">Limpah Wabprof / Jajaran</a></li>
                            <a class="btn btn-success text-white submit" href="javascript:void(0)" data-next="sidik" data-process_id="{{$kasus->status_id}}">Update Status Pemberkasan</a></li>
                            {{-- <button class="btn btn-info text-white dropdown-toggle" id="actionButton" data-bs-toggle="dropdown" {{ $kasus->status_id > 4 ? 'disabled' : '' }}>Update Status</button>
                            <ul class="dropdown-menu" aria-labelledby="actionButton" id="ActionListBtn">
                                <li><a class="dropdown-item submit" href="javascript:void(0)" data-next="limpah" data-process_id="{{$kasus->status_id}}">Limpah Wabprof / Jajaran</a></li>
                                <li><a class="dropdown-item submit" href="javascript:void(0)" data-next="sidik" data-process_id="{{$kasus->status_id}}">Pemberkasan</a></li>
                            </ul> --}}
                            <button class="btn btn-warning text-dark" {{ $kasus->status_id > 4 ? 'disabled' : '' }} id="restorative-justice" data-next="restorative_justice" data-process_id="{{$kasus->status_id}}">Restorative Justice</button>
                        </div>
                    </div>
                @endif
            @else
                @if ($kasus->status_id == 9)
                    <div class="mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-info d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                            <div>
                                Kasus ini telah Dihentikan
                            </div>
                        </div>
                    </div>
                @elseif ($kasus->status_id == 10)
                    <div class="mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-info d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                            <div>
                                Kasus ini telah Dihentikan (RJ)
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-4">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-info d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                            <div>
                                Kasus ini telah Selesai
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </form>
    </div>
</div>

<div class="modal fade" id="sprin_gelar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    @if ($sprinGelar == null)
                        Pembuatan Dokumen SPRIN Gelar
                    @elseif($sprinGelar != null && $sprinGelar->is_draft)
                        Update Nomor SPRIN Gelar
                    @else
                        Download Ulang Dokumen SPRIN Gelar
                    @endif
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="form-sprin-gelar">
                    @csrf
                    <input autocomplete="off" type="hidden" name="status" value="{{$status->id}}">
                    <input autocomplete="off" type="hidden" name="sub_process">
                    <input autocomplete="off" type="hidden" name="process_id">
                    @if ($sprinGelar == null)
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="no_sprin" class="form-label">No. SPRIN</label>
                                    <input autocomplete="off" type="text" class="form-control" name="no_sprin" placeholder='Masukan Nomor SPRIN'>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tgl" class="form-label">Tanggal Pelaksanaan Gelar Perkara</label>
                                    <input autocomplete="off" type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal'>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tempat" class="form-label">Lokasi Pelaksanaan Gelar Perkara</label>
                                    <input autocomplete="off" type="text" class="form-control" name="tempat" placeholder='Masukan Lokasi Pelaksanaan'>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="waktu" class="form-label">Waktu Pelaksanaan Gelar Perkara</label>
                                    <input autocomplete="off" type="time" class="form-control" name="waktu" placeholder='Masukan Waktu Pelaksanaan'>
                                </div>
                            </div>
                        </div>
                    @else
                        @if (!$sprinGelar->is_draft)
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
                    @endif
                </form>

                <form action="javascript:void(0)" id="update-no-sprin" @if($sprinGelar == null || !$sprinGelar->is_draft) style="display: none" @endif>
                    @csrf
                    <input autocomplete="off" type="hidden" name="type" value="gelar">
                    <div class="form-group">
                        <label for="no_sprin">Update Nomor SPRIN Gelar</label>
                        <input autocomplete="off" type="text" name="no_sprin" class="form-control" value="{{$sprinGelar != null ? $sprinGelar->no_sprin : ''}}">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                @if ($sprinGelar == null)
                    <button type="button" class="btn btn-primary" onclick="$('#form-sprin-gelar').trigger('submit')">Buat Dokumen</button>
                @elseif($sprinGelar != null && $sprinGelar->is_draft)
                    <button type="submit" class="btn btn-primary" onclick="$('#update-no-sprin').trigger('submit')">Update Data</button>
                @else
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                @endif
            </div>
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
                <input autocomplete="off" type="hidden" name="status" value="{{$status->id}}">
                <input autocomplete="off" type="hidden" name="sub_process">
                <input autocomplete="off" type="hidden" name="process_id">
                <div class="modal-body">
                    @if (!isset($gelarPerkara->tgl_pelaksanaan))
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                            <div>
                                Harap Buat SPRIN Gelar Perkara Terlebih Dahulu
                            </div>
                        </div>
                    @else
                        <div class="form-group">
                            <label for="no_undangan" class="form-label">No. Undangan Gelar Perkara</label>
                            <input autocomplete="off" type="text" class="form-control" name="no_undangan">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tgl" class="form-label">Tanggal Pelaksanaan Gelar Perkara</label>
                                    <input autocomplete="off" type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal' value="{{ isset($gelarPerkara) ? \Carbon\Carbon::parse($gelarPerkara->tgl_pelaksanaan)->format('Y-m-d') : '' }}"
                                    @if (isset($gelarPerkara))
                                        readonly
                                    @endif>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="jam" class="form-label">Waktu Pelaksanaan Gelar Perkara</label>
                                    <input autocomplete="off" type="time" class="form-control" name="jam" placeholder='Pilih Jam' value="{{ isset($gelarPerkara) ? $gelarPerkara->waktu_pelaksanaan : '' }}"
                                    @if (isset($gelarPerkara))
                                        readonly
                                    @endif>
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="tempat" class="form-label">Tempat Pelaksanaan</label>
                                    <input autocomplete="off" type="text" class="form-control" name="tempat" placeholder='Masukan Tempat Pelaksanaan' value="{{ isset($gelarPerkara) ? $gelarPerkara->tempat_pelaksanaan : '' }}"
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
                                    {{-- <input autocomplete="off" type="text" class="form-control" name="pimpinan" placeholder='Masukan Pimpinan Pelaksanaan'> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" {{!isset($gelarPerkara->tgl_pelaksanaan) ? 'disabled' : ''}} class="btn btn-primary">Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="laporan_hasil_gelar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Dokumen Laporan Hasil Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-laporan-gelar">
                @csrf
                <input autocomplete="off" type="hidden" name="status" value="{{$status->id}}">
                <input autocomplete="off" type="hidden" name="sub_process">
                <input autocomplete="off" type="hidden" name="process_id">
                <div class="modal-body">
                    @if (!isset($gelarPerkara->pimpinan))
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </symbol>
                        </svg>
                        <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                            <div>
                                Harap Buat Undangan Undangan Gelar Perkara Terlebih Dahulu
                            </div>
                        </div>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-6 col-12">
                                <div class="card">
                                    <div class="card-header">Form Peserta Gelar Perkara</div>
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-4">
                                                    <label for="pimpinan">Pimpinan</label>
                                                    <input autocomplete="off" type="hidden" name="pimpinan" value="{{ $gelarPerkara != null ? ($gelarPerkara->pimpinan != null ? $gelarPerkara->pimpinan : '') : '' }}" class="form-control" readonly>
                                                    <input autocomplete="off" type="text" name="pimpinan_text" value="{{ $gelarPerkara != null ? ($gelarPerkara->pimpinan != null ? $gelarPerkara->penyidik->pangkats->name.' '.$gelarPerkara->penyidik->name : '') : '' }}" class="form-control" readonly>
                                                    {{-- <select name="pimpinan" id="select-pimpinan" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Pimpinan">
                                                    </select> --}}
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-4">
                                                    <label for="pemapar">Pemapar</label>
                                                    @if ($gelarPerkara->pemapar == null)
                                                        <select name="pemapar" id="select-pemapar" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Pemapar">
                                                        </select>
                                                    @else
                                                        <input autocomplete="off" type="hidden" name="pemapar" value="{{ $gelarPerkara != null ? ($gelarPerkara->pemapar != null ? $gelarPerkara->pemapar : '') : '' }}" class="form-control" readonly>
                                                        <input autocomplete="off" type="text" name="pemapar_text" value="{{ $gelarPerkara != null ? ($gelarPerkara->pemapar != null ? $gelarPerkara->pemaparDetail->pangkat.' '.$gelarPerkara->pemaparDetail->name : '') : '' }}" class="form-control" readonly>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-4">
                                                    <label for="notulen">Notulen</label>
                                                    @if ($gelarPerkara->notulen == null)
                                                        <select name="notulen" id="select-notulen" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Notulen">
                                                        </select>
                                                    @else
                                                        <input autocomplete="off" type="hidden" name="notulen" value="{{ $gelarPerkara != null ? ($gelarPerkara->notulen != null ? $gelarPerkara->notulen : '') : '' }}" class="form-control" readonly>
                                                        <input autocomplete="off" type="text" name="notulen_text" value="{{ $gelarPerkara != null ? ($gelarPerkara->notulen != null ? $gelarPerkara->notulenDetail->pangkat.' '.$gelarPerkara->notulenDetail->name : '') : '' }}" class="form-control" readonly>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group mb-4">
                                                    <label for="operator">Operator</label>
                                                    @if ($gelarPerkara->operator == null)
                                                        <select name="operator" id="select-operator" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Operator">
                                                        </select>
                                                    @else
                                                        <input autocomplete="off" type="hidden" name="operator" value="{{ $gelarPerkara != null ? ($gelarPerkara->operator != null ? $gelarPerkara->operator : '') : '' }}" class="form-control" readonly>
                                                        <input autocomplete="off" type="text" name="operator_text" value="{{ $gelarPerkara != null ? ($gelarPerkara->operator != null ? $gelarPerkara->operatorDetail->pangkat.' '.$gelarPerkara->operatorDetail->name : '') : '' }}" class="form-control" readonly>
                                                    @endif
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
                                                    <input autocomplete="off" type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal' value="{{ isset($gelarPerkara) ? \Carbon\Carbon::parse($gelarPerkara->tgl_pelaksanaan)->format('Y-m-d') : '' }}"
                                                    @if (isset($gelarPerkara))
                                                        readonly
                                                    @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="jam" class="form-label">Waktu Pelaksanaan</label>
                                                    <input autocomplete="off" type="time" class="form-control" name="jam" placeholder='Pilih Jam' value="{{ isset($gelarPerkara) ? $gelarPerkara->waktu_pelaksanaan : '' }}"
                                                    @if (isset($gelarPerkara))
                                                        readonly
                                                    @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="tempat" class="form-label">Tempat Pelaksanaan</label>
                                                    <input autocomplete="off" type="text" class="form-control" name="tempat" placeholder='Masukan Tempat Pelaksanaan' value="{{ isset($gelarPerkara) ? $gelarPerkara->tempat_pelaksanaan : '' }}"
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
                                                <input autocomplete="off" class="form-check-input" type="radio" name="hasil_gp" id="hasil_gp1" value="Cukup Bukti" {{$gelarPerkara != null ? ($gelarPerkara->hasil_gelar == 'Cukup Bukti' ? 'checked' : '') : ''}}>
                                                <label class="form-check-label" for="hasil_gp1">
                                                Cukup Bukti
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input autocomplete="off" class="form-check-input" type="radio" name="hasil_gp" id="hasil_gp2" value="Tidak Cukup Bukti" {{$gelarPerkara != null ? ($gelarPerkara->hasil_gelar != 'Cukup Bukti' ? 'checked' : '') : ''}}>
                                                <label class="form-check-label" for="hasil_gp2">
                                                Tidak Cukup Bukti
                                                </label>
                                            </div>
                                            </div>
                                        </fieldset>

                                        {{-- <fieldset class="form-group mb-4">
                                            <legend class="col-form-label">Keterangan Hasil</legend>
                                            <div class="form-group">
                                                <label for="keterangan"></label>
                                                <textarea name="keterangan" id="keterangan" cols="60" rows="3" class="form-control"></textarea>
                                            </div>
                                        </fieldset> --}}

                                        <fieldset class="form-group mb-4">
                                            <legend class="col-form-label">Landasan Hukum</legend>
                                            <div class="form-group">
                                                <label for="landasan_hukum"></label>
                                                <textarea name="landasan_hukum" id="landasan_hukum" cols="60" rows="3" class="form-control">{{$gelarPerkara != null ? $gelarPerkara->landasan_hukum : ''}}</textarea>
                                            </div>
                                        </fieldset>

                                        <fieldset class="form-group">
                                            <legend class="col-form-label">Tindak Lanjut</legend>
                                            <div class="form-group">
                                                <label for="tindak_lanjut"></label>
                                                <input autocomplete="off" type="text" name="tindak_lanjut" id="tindak_lanjut" class="form-control" value="{{$gelarPerkara != null ? $gelarPerkara->saran_penyidik : ''}}"/>
                                            </div>
                                        </fieldset>
                                    {{-- </div> --}}
                                    {{-- <div class="col-md-6 col-12"> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="submit" {{!isset($gelarPerkara->pimpinan) ? 'disabled' : ''}} class="btn btn-primary">Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="limpah_polda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Limpah Wabprof / Jajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-limpah-polda">
                @csrf
                <input autocomplete="off" type="hidden" name="status" value="{{$status->id}}">
                <input autocomplete="off" type="hidden" name="sub_process">
                <input autocomplete="off" type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="polda_id">Pilih Polda</label>
                        <select name="polda_id" id="polda_id" class="form-select select-polda" data-placeholder="Silahkan Pilih Polda Tujuan / Wabprof" required>
                            <option></option>
                            @foreach ($poldas as $polda)
                                <option value="{{$polda->id}}">{{$polda->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary submit" data-next="limpah_modal" data-process_id="{{$kasus->status_id}}">Buat Dokumen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.select-polda').map((k, v) => {
            $(v).select2({
                theme: 'bootstrap-5'
            })
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
                if (subProcess == 'laporan_hasil_gelar' || subProcess == 'undangan_gelar') getPenyidik(kasus_id, subProcess);
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
                    onAjaxError(xhr)
                }
            })
        })

        $('#update-no-sprin').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/update-no-sprin/{{ $kasus->id }}`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    setTimeout(() => {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Berhasil',
                            text: 'Berhasil Update Nomor SPRIN Lidik',
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
                    onAjaxError(xhr)
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
                    setTimeout(() => {
                        window.location.reload()
                    }, 1500);
                },
                error: (xhr) => {
                    $.LoadingOverlay("hide");
                    onAjaxError(xhr)
                }
            })
        })

        $('.submit').on('click', function(){
            var data = $('#form').serializeArray()
            if($(this).data('next') == 'limpah'){
                $('#limpah_polda').modal('toggle')
            } else if($(this).data('next') == 'limpah_modal') {
                data.push({
                    name: 'polda_id',
                    value: $('#limpah_polda').find('.select-polda').val()
                })

                data.push({
                    name: 'next',
                    value: $(this).data('next')
                })

                data.push({
                    name: 'process_id',
                    value: $(this).data('process_id')
                })

                $.ajax({
                    url: `/data-kasus/update`,
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
                        // console.log(xhr.responseJSON.status.msg)
                        onAjaxError(xhr)
                    }
                })
            } else {
                data.push({
                    name: 'next',
                    value: $(this).data('next')
                })
                data.push({
                    name: 'process_id',
                    value: $(this).data('process_id')
                })

                $.ajax({
                    url: `/data-kasus/update`,
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
            }

        })

        $('#restorative-justice').on('click', function(){
            Swal.fire({
                title: 'Apakah anda yakin ingin melakukan Restorative Justice pada kasus ini?',
                text: "",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Lakukan Restorative Justice'
                }).then((result) => {
                if (result.isConfirmed) {
                    var data = $('#form').serializeArray()
                    data.push({
                        name: 'next',
                        value: $(this).data('next')
                    })
                    data.push({
                        name: 'process_id',
                        value: $(this).data('process_id')
                    })

                    $.ajax({
                        url: `/data-kasus/update`,
                        method: 'POST',
                        data: data,
                        beforeSend: () => {
                            $.LoadingOverlay("show");
                        },
                        success:(res) => {
                            $.LoadingOverlay("hide");
                            window.location.href = `/download-file/${res.file}`
                            Swal.fire({
                                title: 'Berhasil',
                                text: 'Berhasil melakukan restorative justice',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            })
                            setTimeout(() => {
                                window.location.reload()
                            }, 2500);
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
                }
            })
        })
    })

    function getPenyidik(kasus_id, modal_id){
        let url = ''
        if(modal_id == 'undangan_gelar'){
            url = `{{url('master-penyidik')}}`
        } else {
            url = `{{url('data-penyidik/${kasus_id}')}}`
        }

        $.ajax({
            url: url,
            method: 'GET',
            beforeSend: () => {
                $.LoadingOverlay("show");
            },
            success: (res) => {
                $.LoadingOverlay("hide");
                var option = '<option><option>'

                if(modal_id != 'undangan_gelar'){
                    res.map((v, k) => {
                        option += `<option value="${v.id}"> ${v.pangkat} ${v.name} (${v.jabatan}) </option>`
                    })
                } else {
                    res.map((v, k) => {
                        option += `<option value="${v.id}"> ${v.pangkats.name} ${v.name} (${v.jabatan}) </option>`
                    })
                }

                $('.select-penyidik').map((k, v) => {
                    $(v).html(option)
                })

                $('.select-penyidik').map((k, v) => {
                    $(v).select2({
                        theme: 'bootstrap-5',
                        dropdownParent : $(`#${modal_id} .modal-content`)
                    })
                })
            },
            error: (xhr) => {
                $.LoadingOverlay("hide");
                onAjaxError(xhr)
            }
        })
    }

    function mask(el, maskVal){
        $(el).inputmask({"mask": maskVal});
    }
</script>
