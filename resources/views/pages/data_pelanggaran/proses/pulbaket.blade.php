<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(2)">Sebelumnya</button>
            </div>
            <div>
                @if ($kasus->status_id > 3)
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
                    <p>Disposisi Diterima</p>
                </div>
                <div class="f1-step active">
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
                        {{\Carbon\Carbon::parse($kasus->tanggal_kejadian)->translatedFormat('l, d F Y')}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Tgl. SPRIN Lidik
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$sprin != null ? \carbon\Carbon::parse($sprin->created_at)->translatedFormat('d, F Y') : ' - '}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Tgl. Undangan Klarifikasi
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$undanganKlarifikasi != null ? \carbon\Carbon::parse($undanganKlarifikasi->tgl_pertemuan)->translatedFormat('d, F Y') : ' - '}}, Pukul : {{$undanganKlarifikasi != null ? \carbon\Carbon::parse($undanganKlarifikasi->jam_pertemuan)->translatedFormat('G:i').' WIB' : ' - '}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Hasil Penyelidikan
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$gelarPerkara != null ? $gelarPerkara->hasil_gelar : ' - '}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Pasal Dilanggar
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$gelarPerkara != null ? $gelarPerkara->landasan_hukum : ' - '}}
                    </div>

                    <div class="col-md-3 col-sm-12">
                        Saran Penyidik
                    </div>
                    <div class="col-md-1">
                        :
                    </div>
                    <div class="col-md-8 col-sm-12">
                        {{$gelarPerkara != null ? ($gelarPerkara->saran_penyidik != null ? $gelarPerkara->saran_penyidik : ' - ') : ' - '}}
                    </div>
                </div>
            </div>
            <hr>

            <div class="row align-items-center justify-content-center">
                @if ($kasus->status_id != 8 && $kasus->status_id != 9)
                    @if($kasus->status_id == 5)
                        <h2 class="text-center text-warning mt-4">
                            <i class="mdi mdi-information"></i> Kasus telah dilimpahkan ke Polda / Jajaran
                        </h2>
                    @else
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
                                            <a href="#!" class="text-primary modal-toggle" style="text-decoration: none; width: 100%"  data-process_id="{{$kasus->status_id}}" data-kasus_id="{{$kasus->id}}" data-subprocess_name="{{$sb->name}}" data-subprocess="{{$sb->id}}">
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
                                    {{ $kasus->status_id != 3 ? 'disabled' : '' }}>Update
                                    Status (Gelar Lidik)</button>
                            </div>
                        </div>
                    @endif
                @else
                    @if ($kasus->status_id == 9)
                        <h2 class="text-center text-info mt-4">
                            <i class="mdi mdi-information"></i> Kasus ini telah Dihentikan
                        </h2>
                    @else
                        <h2 class="text-center text-info mt-4">
                            <i class="mdi mdi-information"></i> Kasus ini telah selesai
                        </h2>
                    @endif
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="sprin_lidik" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                        <div class="form-group">
                            <label for="no_sprin" class="form-label">No. SPRIN</label>
                            <input type="text" class="form-control" name="no_sprin" value="{{!empty($sprin) ? $sprin->no_sprin : ''}}" placeholder="{{!empty($sprin) ? '' : 'Masukan Nomor SPRIN'}}">
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
                                        <hr>
                                    </div>
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

<div class="modal fade" id="undangan_klarifikasi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Undangan Klarifikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-undangan">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="no_undangan" class="form-label">No. Undangan</label>
                                <input type="number" class="form-control" name="no_undangan" placeholder='Masukan Nomor Undangan'>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tgl_pertemuan" class="form-label">Tanggal Undangan</label>
                                <input type="date" class="form-control" name="tgl_pertemuan" placeholder='Pilih Tanggal'>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="ruang_pertemuan" class="form-label">Ruang Pelaksanaan</label>
                                <input type="text" class="form-control" name="ruang_pertemuan">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="jam_pertemuan" class="form-label">Jam Undangan</label>
                                <input type="time" class="form-control" name="jam_pertemuan">
                            </div>
                        </div>
                    </div>

                    <!-- Pilih Penyidik -->
                    <div class="card card-data-penyidik">
                        <div class="card-header">Pilih Penyidik</div>
                        <div class="card-body">
                            <div class="mb-3 form-group">
                                <select name="penyidik" id="select-penyidik" class="form-select select-penyidik" data-placeholder="Silahkan Pilih Penyidik">

                                </select>
                                <hr>
                            </div>
                            <div class="form-group">
                                <label for="no_telp_penyidik">No. Telepon Penyidik</label>
                                <input type="text" class="form-control" name="no_telp_penyidik" onfocus="mask(this, '99999999999999')">
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

<div class="modal fade" id="bai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat BAI</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-generate-bai">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    @if ($bai == null)
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
                                Penyidik BAI
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Penyidik 1</label>
                                        <input type="text" class="form-control" disabled value="{{$penyidik1->pangkat}} {{$penyidik1->name}} - {{$penyidik1->jabatan}}">
                                        <select name="penyidik_1" hidden>
                                            <option value="{{$bai->penyidik1}}" selected></option>
                                        </select>
                                        {{-- <input name="penyidik1" type="hidden" value="{{$bai->penyidik1}}"/> --}}
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="">Penyidik 2</label>
                                        <input type="text" class="form-control" disabled value="{{$penyidik2->pangkat}} {{$penyidik2->name}} - {{$penyidik2->jabatan}}">
                                        <select name="penyidik_2" hidden>
                                            <option value="{{$bai->penyidik2}}" selected></option>
                                        </select>
                                        {{-- <input name="penyidik2" type="hidden" value="{{$bai->penyidik2}}"/> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                                <label for="pangkat">Pangkat</label>
                                                <select name="pangkat" class="pangkat-saksi form-control form-select" data-placeholder="Pilih Pangkat Saksi">
                                                    <option></option>
                                                    @foreach ($pangkats as $item)
                                                        <option value="{{$item->name}}">{{$item->name}}</option>
                                                    @endforeach
                                                </select>
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
                                                    <option value="0" selected disabled>----- Harap Pilih Agama -----</option>
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
                                                <input type="text" name="no_telp" class="form-control" placeholder="Masukan Nomor Telepon" onfocus="mask(this, '999999999999999')" onclick="mask(this, '999999999999999')" onchange="mask(this, '999999999999999')">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>

                                <div class="d-flex mb-3 mt-5 justify-content-between">
                                    <span onclick="tambahSaksi(this)" class="text-primary" style="cursor: pointer"> <i class="far fa-plus-square"></i>
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
        </div>
    </div>
</div>

<div class="modal fade" id="laporan_hasil_penyelidikan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Laporan Hasil Penyelidikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-input-lhp">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <fieldset class="form-group row mb-4">
                                <legend class="col-form-label">Hasil Penyelidikan</legend>
                                <div class="col-sm-10">
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hasil_gp" id="hasil_gp1" value="Cukup Bukti" {{$gelarPerkara != null ? ($gelarPerkara->hasil_gelar == 'Cukup Bukti' ? 'checked disabled' : 'disabled') : ''}}>
                                    <label class="form-check-label" for="hasil_gp1">
                                      Cukup Bukti
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hasil_gp" id="hasil_gp2" value="Tidak Cukup Bukti" {{$gelarPerkara != null ? ($gelarPerkara->hasil_gelar != 'Cukup Bukti' ? 'checked disabled' : 'disabled') : ''}}>
                                    <label class="form-check-label" for="hasil_gp2">
                                      Tidak Cukup Bukti
                                    </label>
                                  </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6 col-12">
                            <fieldset class="form-group mb-4">
                                <legend class="col-form-label">Pasal yang Dilanggar</legend>
                                <div class="form-group">
                                    <label for="landasan_hukum"></label>
                                    <textarea name="landasan_hukum" id="landasan_hukum" cols="60" rows="2" class="form-control" {{$gelarPerkara != null ? 'disabled' : ''}}>{{$gelarPerkara != null ? $gelarPerkara->landasan_hukum : ''}}</textarea>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-12 col-12">
                            <fieldset class="form-group">
                                <legend class="col-form-label">Saran Penyidik (Opsional)</legend>
                                <div class="form-group">
                                    <label for="tindak_lanjut"></label>
                                    <input type="text" name="tindak_lanjut" id="tindak_lanjut" class="form-control" value="{{$gelarPerkara != null ? $gelarPerkara->saran_penyidik : ''}}" {{$gelarPerkara != null ? 'disabled' : ''}}/>
                                </div>
                            </fieldset>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" {{$gelarPerkara != null ? 'disabled' : ''}} class="btn btn-primary">Submit Laporan Hasil Penyelidikan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="nd_permohonan_gelar_perkara" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pembuatan Dokumen Nota Dinas Permohonan Gelar Perkara</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)" id="form-nd-gelar-perkara">
                @csrf
                <input type="hidden" name="status" value="{{$status->id}}">
                <input type="hidden" name="sub_process">
                <input type="hidden" name="process_id">
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tgl" class="form-label">Tanggal Pelaksanaan Gelar Perkara</label>
                                <input type="date" class="form-control" name="tgl" placeholder='Pilih Tanggal'>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="jam" class="form-label">Waktu Pelaksanaan Gelar Perkara</label>
                                <input type="time" class="form-control" name="jam" placeholder='Pilih Jam'>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="tempat" class="form-label">Tempat Pelaksanaan</label>
                                <input type="text" class="form-control" name="tempat" placeholder='Masukan Tempat Pelaksanaan'>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="pimpinan" class="form-label">Pimpinan Pelaksanaan</label>
                                <input type="text" class="form-control" name="pimpinan" placeholder='Masukan Pimpinan Pelaksanaan'>
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
        localStorage.setItem('addAnggota', 0)

        // $('.select-penyidik').map((k, v) => {
        //     $(v).select2({
        //         theme: 'bootstrap-5'
        //     })
        // })

        // $('.select-penyidik').select2({
        //     theme: 'bootstrap-5'
        // })

        $('select[name="unit_pemeriksa"]').select2({
            theme: 'bootstrap-5',
            dropdownParent : $('#sprin_lidik .modal-content')
        })

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

                // Get Penyidik kalau klick undangan klarifikasi
                if (subProcess == 'undangan_klarifikasi' || subProcess == 'bai'){
                    getPenyidik(kasus_id, subProcess)
                    $('.pangkat-saksi').select2({
                        theme: 'bootstrap-5',
                        dropdownParent : $('#bai .modal-content')
                    })
                }
                if(subProcess == 'sprin_lidik'){
                    $('.select-pangkat').select2({
                        theme: 'bootstrap-5',
                        dropdownParent : $('#sprin_lidik .modal-content')
                    })
                }
            } else {
                let url = `/print/${subProcess}/${kasus_id}/${$(this).data('process_id')}/${$(this).data('subprocess')}`
                window.location.href = url
            }

        })

        $('#form-generate-sprin').on('submit', function(){
            var data = new FormData()
            let valid = true
            const elemPenyelidik = $('#form_input_anggota').find('.form_penyelidik')

            for (let i = 0; i < elemPenyelidik.length; i++) {
                var nrp = $(elemPenyelidik).find('input[name="nrp"]')[i].value
                if(nrp.length != 8){
                    Swal.fire({
                        title: `Panjang NRP harus 8 digit`,
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                    })
                    valid = false;
                }
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

            if(valid == true){
                $.ajax({
                    url: `/surat-perintah/{{ $kasus->id }}/not_generated`,
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
            }
        })

        $('#form-generate-undangan').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/undangan_klarifikasi/{{ $kasus->id }}`,
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
                    onAjaxError(xhr)
                }
            })
        })

        $('#header-saksi').on('click', function(){
            if($('#body-saksi').css('display') == 'none'){
                $('#body-saksi').slideDown()
            } else {
                $('#body-saksi').slideUp()
            }
        })

        $('#form-generate-bai').on('submit', function(){
            var data = new FormData()
            const elem = $('#container_saksi').find('.form_saksi')
            for (let i = 0; i < elem.length; i++) {
                var nrp = $(elem).find('input[name="nrp"]')[i].value
                nrp = nrp.split('_').join('')
                var telp = $(elem).find('input[name="no_telp"]')[i].value
                telp = telp.split('_').join('')

                data.append(`nama[${i}]`, $(elem).find('input[name="nama"]')[i].value)
                data.append(`pangkat[${i}]`, $(elem).find('select[name="pangkat"] option').filter(':selected')[i].value)
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

            data.append('penyidik1', $('select[name="penyidik_1"] option').filter(':selected').val())
            data.append('penyidik2', $('select[name="penyidik_2"] option').filter(':selected').val())
            data.append('process_id', $('input[name="process_id"]').val())
            data.append('sub_process', $('input[name="sub_process"]').val())

            $.ajax({
                url: `/print/bai/{{$kasus->id}}`,
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

        $('#form-nd-gelar-perkara').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `/print/nd_permohonan_gelar_perkara/{{ $kasus->id }}`,
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

        $('#form-input-lhp').on('submit', function(){
            var data = $(this).serializeArray();
            $.ajax({
                url: `/print/laporan_hasil_penyelidikan/{{ $kasus->id }}`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil buat laporan hasil penyelidikan',
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

        // BUAT JAGA JAGA
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
        $(el).inputmask({"mask": maskVal, placeholder: ''});
    }

    function tambahAnggota(el) {
        var addAnggota = localStorage.getItem('addAnggota')
        let parentEl = $(el).parent().parent().find('#form_input_anggota')
        $('.select-pangkat').select2('destroy')
        let duplicateForm = $(el).parent().parent().find('#form_input_anggota').children()[0]
        $(duplicateForm).clone(false).appendTo(parentEl).find('input').val('')

        $('.select-pangkat').select2({
            theme: 'bootstrap-5',
            dropdownParent : $('#sprin_lidik .modal-content')
        })
    }

    function removeAnggota(el){
        $(el).parent().parent().next().remove()
        $(el).parent().parent().remove()
        var addAnggota = localStorage.getItem('addAnggota')
        addAnggota = parseInt(addAnggota) - 1
        localStorage.setItem('addAnggota', addAnggota)
    }

    function getPenyidik(kasus_id, modal_id){
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

                $('.select-penyidik').select2({
                    theme: 'bootstrap-5',
                    dropdownParent : $(`#${modal_id} .modal-content`)
                })
            }
        })
    }

    function tambahSaksi(el){
        let parentEl = $(el).parent().parent().find('#container_saksi')
        $('.pangkat-saksi').select2('destroy')
        let duplicateForm = $(el).parent().parent().find('#container_saksi').children()[0]
        $(duplicateForm).clone(false).appendTo(parentEl).find('input').val('')

        $('.pangkat-saksi').select2({
            theme: 'bootstrap-5',
            dropdownParent : $('#bai .modal-content')
        })
        // let html = `
        // <div class="row mb-3 form_saksi">
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="nama">Nama</label>
        //             <input type="text" name="nama" class="form-control" placeholder="Masukan Nama">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="pangkat">Pangkat</label>
        //             <input type="text" name="pangkat" class="form-control" placeholder="Masukan Pangkat">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="jabatan">Jabatan</label>
        //             <input type="text" name="jabatan" class="form-control" placeholder="Masukan Jabatan">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="nrp">NRP</label>
        //             <input type="text" name="nrp" class="form-control" placeholder="Masukan NRP" onclick="mask(this, '99999999')" onfocus="mask(this, '99999999')" onchange="mask(this, '99999999')">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="kesatuan">Kesatuan</label>
        //             <input type="text" name="kesatuan" class="form-control" placeholder="Masukan Kesatuan">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="ttl">Tempat Tanggal Lahir</label>
        //             <input type="text" name="ttl" class="form-control" placeholder="Masukan Tempat Tanggal Lahir">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="warga_negara">Warga Negara</label>
        //             <input type="text" name="warga_negara" class="form-control" placeholder="Masukan Warga Negara">
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="agama">Agama</label>
        //             <select name="agama" class="form-select">
        //                 <option value="0" selected disabled>----- Harap Pilih Agama -----</option>
        //                 @foreach ($agamas as $agama)
        //                     <option value="{{$agama->id}}">{{$agama->name}}</option>
        //                 @endforeach
        //             </select>
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="alamat">Alamat</label>
        //             <textarea name="alamat" class="form-control" cols="8" rows="5"></textarea>
        //             {{-- <input type="text" name="agama" class="form-control" placeholder="Masukan Warga Negara"> --}}
        //         </div>
        //     </div>
        //     <div class="col-md-6 col-12">
        //         <div class="form-group">
        //             <label for="no_telp">No. Telp</label>
        //             <input type="text" name="no_telp" class="form-control" placeholder="Masukan Nomor Telepon" onfocus="mask(this, '999999999999999')" onclick="mask(this, '999999999999999')" onchange="mask(this, '999999999999999')">
        //         </div>
        //     </div>

        //     <div class="d-flex mb-3 mt-4 justify-content-end">
        //             <span onclick="removeSaksi($(this))" class="text-danger" style="cursor: pointer"> <i class="far fa-minus-square"></i>
        //                 Saksi </span>
        //         </div>
        // </div><hr>
        // `

        // $('#container_saksi').append(html);
    }

    function removeSaksi(el){
        $(el).parent().parent().next().remove()
        $(el).parent().parent().remove()
    }
</script>
