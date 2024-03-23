@extends('partials.master')

@prepend('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        select:hover, #datepicker:hover, #datepicker_tgl_kejadian:hover {
            cursor: pointer;
        }
    </style>
@endprepend

@section('content')
    <div class="row form-control mt-4">
        <div class="form-control text-center border-0">
            <h3>Form Input Dumas</h3>
        </div>
        <form action="/input-data-kasus/store" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="text" class="form-control border-dark" name="no_nota_dinas" id="no_nota_dinas" placeholder="No. Nota Dinas" value="{{ isset($kasus) ? $kasus->no_nota_dinas : '' }}" required>
                        <label for="no_nota_dinas">No. Nota Dinas</label>
                    </div>
                </div>
                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="text" class="form-control border-dark" name="perihal_nota_dinas" id="perihal_nota_dinas" placeholder="Perihal Nota Dinas" value="{{ isset($kasus) ? $kasus->perihal_nota_dinas : '' }}" required>
                        <label for="perihal_nota_dinas">Perihal Nota Dinas</label>
                    </div>
                </div>

                <div class="col-lg-6 mb-0" style="display:none !important">
                    <center>
                        <div class="form-label">
                            <label for="check-box">Tipe Pelanggaran</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input autocomplete="off" class="form-check-input border-dark" type="checkbox" id="disiplin" name="jenis_wp" value="1" checked onchange='disiplinChange(this);'>
                            <label class="form-check-label " for="disiplin">Disiplin</label>
                          </div>
                        <div class="form-check form-check-inline">
                            <input autocomplete="off" class="form-check-input border-dark" type="checkbox" id="kode_etik" name="jenis_wp" value="2" onchange='kodeEtikChange(this);'>
                            <label class="form-check-label" for="kode_etik">Kode Etik</label>
                        </div>
                    </center>
                </div>

                <div class="col-lg-6 mb-3">
                    <div class="form-floating">
                        <select class="form-select border-dark" aria-label="Default select example" name="wujud_perbuatan" id="wujud_perbuatan" required data-placeholder="Pilih Wujud Perbuatan">
                        </select>
                        <label for="wujud_perbuatan" class="form-label">Wujud Perbuatan</label>
                    </div>
                </div>

                <div class="col-lg-12 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="date" name="tanggal_nota_dinas" class="form-control border-dark" id="datepicker" placeholder="Tanggal Nota Dinas" value="{{ isset($kasus) ? $kasus->tanggal_nota_dinas : '' }}" required>
                        <label for="tanggal_nota_dinas">Tanggal Nota Dinas</label>
                    </div>
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="pelapor" id="pelapor" placeholder="Nama Pelapor" value="{{ isset($kasus) ? $kasus->pelapor : '' }}" required>
                                <label for="pelapor">Nama Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="number" class="form-control border-dark" name="umur" id="umur" placeholder="Umur Pelapor" value="{{ isset($kasus) ? $kasus->umur : '' }}">
                                <label for="umur">Umur</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_kelamin" id="jenis_kelamin" required data-placeholder="Pilih Jenis Kelamin">
                                    <option></option>
                                    @if (isset($jenis_kelamin))
                                        @foreach ($jenis_kelamin as $key => $jk)
                                            <option value="{{ $jk->id }}" {{ isset($kasus) ? ($kasus->jenis_kelamin == $jk->id ? 'selected' : '') : '' }}>{{ $jk->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" name="pekerjaan" class="form-control border-dark" placeholder="Pekerjaan Pelapor" value="{{ isset($kasus) ? $kasus->pekerjaan : '' }}">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="agama" id="agama" required data-placeholder="Pilih Agama">
                                    <option></option>
                                    @foreach ($agama as $key => $ag)
                                        <option value="{{ $ag->id }}">{{ $ag->name }}</option>
                                    @endforeach
                                </select>
                                <label for="agama" class="form-label">Agama</label>
                            </div>

                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" name="no_identitas" id="no_identitas" placeholder="1234-5678-9012-1234" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_identitas : '' }}">
                                <label for="no_identitas" class="form-label">No Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" aria-label="Default select example" name="jenis_identitas"id="jenis-identitas" required data-placeholder="Pilih Jenis Identitas">
                                    <option></option>
                                    @if (isset($jenis_identitas))
                                        @foreach ($jenis_identitas as $key => $ji)
                                            <option value="{{ $ji->id }}" {{ isset($kasus) ? ($kasus->jenis_identitas == $ji->id ? 'selected' : '') : ($ji->id == '1' ? 'selected' : '') }}>{{ $ji->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="jenis_identitas" class="form-label">Jenis Identitas</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" name="no_telp" id="no_telp" placeholder="No. Telp Pelapor" class="form-control border-dark" value="{{ isset($kasus) ? $kasus->no_telp : '' }}" required>
                                <label for="no_telp" class="form-label">No. Telepon Pelapor</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="alamat" placeholder="Alamat" id="floatingTextarea" value="{{ isset($kasus) ? $kasus->alamat : '' }}" style="height: 160px" required></textarea>
                                <label for="floatingTextarea" class="form-label">Alamat</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 p-3">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="nrp" id="nrp" placeholder="NRP Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->nrp : '' }}" required>
                                <label for="nrp">NRP Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="terlapor" id="terlapor" placeholder="Nama Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->terlapor : '' }}" required>
                                <label for="terlapor">Nama Terduga Pelanggar</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select class="form-select border-dark" data-live-search="true" aria-label="Default select example" name="pangkat" id="pangkat" required data-placeholder="Pilih Pangkat">
                                    <option></option>
                                    @if (isset($pangkat))
                                        @foreach ($pangkat as $key => $p)
                                            <option value="{{ $p->id }}">
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <label for="pangkat" class="form-label">Pangkat Terduga Pelangar</label>
                            </div>
                        </div>


                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="jabatan" id="jabatan" placeholder="Jabatan Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->jabatan : '' }}" required>
                                <label for="jabatan">Jabatan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="kesatuan" id="kesatuan" placeholder="Kesatuan Terduga Pelanggar" value="{{ isset($kasus) ? $kasus->kesatuan : '' }}" required>
                                <label for="kesatuan">Kesatuan Terduga Pelanggar</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <select name="wilayah_hukum" id="wilayah_hukum" class="form-control form-select" data-placeholder="Pilih Mabes/Polda">
                                    <option></option>
                                    @foreach ($polda as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                                {{-- <input autocomplete="off" type="text" class="form-control border-dark" name="wilayah_hukum" id="wilayah_hukum" placeholder="Mabes/Polda" value="{{ isset($kasus) ? $kasus->wilayah_hukum : '' }}" required> --}}
                                <label for="wilayah_hukum">Mabes/Polda</label>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="tempat_kejadian" id="tempat_kejadian" placeholder="Tempat Kejadian" value="{{ isset($kasus) ? $kasus->tempat_kejadian : '' }}" required>
                                <label for="tempat_kejadian">Tempat Kejadian</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="date" id="datepicker_tgl_kejadian" name="tanggal_kejadian" class="form-control border-dark" placeholder="BB/HH/TTTT" value="{{ isset($kasus) ? $kasus->tanggal_kejadian : '' }}" required>
                                <label for="tempat_kejadian">Tanggal Kejadian</label>
                            </div>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <input autocomplete="off" type="text" class="form-control border-dark" name="nama_korban" id="nama_korban" placeholder="Nama korban" value="{{ isset($kasus) ? $kasus->nama_korban : '' }}" required>
                                <label for="nama_korban">Nama Korban</label>
                            </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <div class="form-floating">
                                <textarea class="form-control border-dark" name="kronologis" placeholder="Kronologis" id="kronologis" value="{{ isset($kasus) ? $kasus->kronologis : '' }}" style="height: 160px" required></textarea>
                                <label for="kronologis" class="form-label">Kronologis</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <button class="btn btn-success form-control" type="submit" value="input_kasus" name="type_submit">
                        Submit Data
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('input[type="date"]').on('keydown', function(){
                return false
            })

            //no identitas
            no_identitas.addEventListener('keyup', function(e){
                no_identitas.value = format_no_identitas(this.value, '');
            });

            function format_no_identitas(angka, prefix){
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split   		= number_string.split(','),
                sisa     		= split[0].length % 4,
                rupiah     		= split[0].substr(0, sisa),
                ribuan     		= split[0].substr(sisa).match(/\d{4}/gi);

                if(ribuan){
                    separator = sisa ? '-' : '';
                    rupiah += separator + ribuan.join('-');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
            };

            // $( "#datepicker" ).datepicker({
            //     autoclose:true,
            //     todayHighlight:true,
            //     format:'yyyy-mm-dd',
            //     language: 'id'
            // });
            // $( "#datepicker_tgl_kejadian" ).datepicker({
            //     autoclose:true,
            //     todayHighlight:true,
            //     format:'yyyy-mm-dd',
            //     language: 'id'
            // });

            getValDisiplin()

            $('.form-select').select2({
                theme: 'bootstrap-5'
            })
        });

        function getValDisiplin() {
            console.log('test')
            let kasus_wp = `{{ isset($kasus) ? $kasus->wujudPerbuatan->keterangan_wp : '' }}`;
            let list_ketdis = new Array();
            list_ketdis = `{{ $disiplin }}`;
            list_ketdis = list_ketdis.split('|');

            let list_id_dis = new Array();
            list_id_dis = `{{ $id_disiplin }}`;
            list_id_dis = list_id_dis.split('|');

            let html_wp = `<option></option>`;
            $('#wujud_perbuatan').append(html_wp);
            let is_selected = '';
            for (let index = 0; index < list_ketdis.length; index++) {
                const el_ketdis = list_ketdis[index];
                const el_id_dis = list_id_dis[index];
                if (kasus_wp != '' && kasus_wp == el_id_dis) {
                    is_selected = 'selected';
                }
                html_wp += `<option value="`+el_id_dis+`" `+is_selected+`>`+el_ketdis+`</option>`;
            }
            $('#wujud_perbuatan').html(html_wp);
        }
    </script>
@endsection
