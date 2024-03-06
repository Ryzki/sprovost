@extends('partials.master')

@section('content')
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0 flex-grow-1">Data No Nota Dinas {{ $kasus->no_nota_dinas }}
                        ({{ $kasus->status->name }})
                    </h4>
                    <p>
                        <b>Umur Kasus : {{\Carbon\Carbon::parse($kasus->created_at)->diff(\Carbon\Carbon::now())->format('%y tahun, %m bulan dan %d hari')}} </b>
                    </p>

                </div><!-- end card header -->

                @if(Session::has('msg'))
                    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </symbol>
                    </svg>
                    <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                        <div>
                            {{Session::get('msg')}}
                        </div>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card-body" style="min-height:300px">
                    <input type="text" class="form-control" id="data_pelanggar_id" name="data_pelanggar_id"
                        value="{{ $kasus->id }}" hidden>
                    <input type="text" class="form-control" id="process_id" name="data_pelanggar_id"
                        value="{{ $kasus->status_id }}" hidden>
                    <div class="loader-view" style="display:block;">

                    </div>
                    <div id="viewProses">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/decoupled-document/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/inline/ckeditor.js"></script> --}}
    {{-- <script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script> --}}



    {{-- <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            // ClassicEditor
            //     .create(document.querySelector('#editor'))
            //     .catch(error => {
            //         console.error(error);
            //     });

            let process_id = $('#process_id').val()
            getViewProcess(process_id)
        });
    </script>
    <script>
        function getViewProcess(id) {
            let kasus_id = $('#data_pelanggar_id').val()
            let process_id = $('#process_id').val()
            $("#viewProses").html("")
            $('.loader-view').css("display", "block");
            // if (id == 3 && process_id > 3) {
            //     id = 4
            // }

            $.ajax({
                url: `/data-kasus/view/${kasus_id}/${id}`,
                method: "get",
                error: (xhr) => {
                    $('.loader-view').css("display", "none");
                    console.log(xhr)
                    onAjaxError(xhr)
                }
            }).done(function(data) {
                $('.loader-view').css("display", "none");
                $("#viewProses").html(data)
            });
        }

        function getValue() {
            console.log($('#editor').text())
        }

        function getPolda() {
            let disposisi = $('#disposisi-tujuan').val()
            if (disposisi == '3') {
                $.ajax({
                    url: "/api/all-polda",
                    method: "get"
                }).done(function(data) {
                    $("#limpah-polda").html(data)
                });
            } else $("#limpah-polda").html("")



        }
    </script>
@endsection
