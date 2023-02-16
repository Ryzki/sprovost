<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="d-flex justify-content-between">
            <div>
                <button type="button" class="btn btn-warning" onclick="getViewProcess(1)">Sebelumnya</button>
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
                    <div class="f1-progress-line" data-now-value="50" data-number-of-steps="4" style="width: 50%;">
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
                    <p>Gelar Peneyelidikan</p>
                </div>
                <div class="f1-step">
                    <div class="f1-step-icon"><i class="fa fa-address-book"></i></div>
                    <p>Provost / Wabprof</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <form action="javascript:void(0)" id="form">
            @csrf
            <input type="text" class="form-control" value="{{ $kasus->id }}" hidden name="kasus_id">
            <input type="text" class="form-control" value="{{ $kasus->status_id }}" hidden name="process_id">
            <div class="row">
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
                        <div class="col-lg-12 mb-3">
                            <label for="exampleFormControlInput1" class="form-label" style="; width: 100%">Download Berkas</label>
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
            <div class="row">
                <div class="col-lg-12" style="float: right;">
                    <button class="btn btn-success submit" type="submit" value="update_data" name="type_submit">Update
                        Data</button>
                    <button class="btn btn-primary submit" type="submit" value="update_status" name="type_submit"
                        {{ $kasus->status_id > 1 ? 'disabled' : '' }}>Update
                        Status (Pulbaket)</button>
                </div>
            </div>
        </form>
    </div>
</div>
