@extends('partials.master')

@section('content')
    <div class="card mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Ambil Data Yanduan Berdasarkan Rentan Tanggal</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <form action="javascript:void(0)" id="import-dumas">
                            @csrf
                            <div class="row justify-content-between align-items-center">
                                <div class="col-md-2 col-12">&nbsp;</div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input  type="date" name="start_date" id="start_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2 col-12 text-center">
                                    <h5 class="mt-4"> - </h5>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="end_date">Tanggal Akhir</label>
                                        <input  type="date" name="end_date" id="end_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2 col-12">&nbsp;</div>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1 mt-4">
                                <button type="submit" class="btn btn-primary" @if (session()->has('errGetToken')) disabled @endif>Ambil Data</button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        @if (session()->has('errGetToken'))
                            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                </symbol>
                            </svg>
                            <div class="alert alert-warning d-flex align-items-center alert-dismissible fade show" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                <div>
                                    {{session()->get('errGetToken')}}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
{{--
    <div class="card card-animate">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Preview Data</h4>
                    </div><!-- end card header -->

                    <div class="card-body">
                        <div class="table-responsive table-card px-3">
                            <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th scope="col">No Nota Dinas</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Pelapor</th>
                                        <th scope="col">Terlapor</th>
                                        <th scope="col">Pangkat</th>
                                        <th scope="col">Nama Korban</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@section('scripts')
    {{-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script> --}}
    <script>
        // $(document).ready(function() {
        //     getData()
        // });

        // function getData() {
        //     var table = $('#data-data').DataTable({
        //         processing: true,
        //         serverSide: true,
        //         ordering: false,
        //         ajax: {
        //             url: "{{ route('kasus.data') }}",
        //             method: "post",
        //             data: function(data) {
        //                 data._token = '{{ csrf_token() }}'
        //             }
        //         },
        //         columns: [
        //             // {
        //             //     data: 'DT_RowIndex',
        //             //     name: 'DT_RowIndex',
        //             //     orderable: false,
        //             //     searchable: false
        //             // },
        //             {
        //                 data: 'no_nota_dinas',
        //                 name: 'no_nota_dinas'
        //             },
        //             {
        //                 data: 'tanggal_kejadian',
        //                 name: 'tanggal_kejadian'
        //             },
        //             {
        //                 data: 'pelapor',
        //                 name: 'pelapor'
        //             },
        //             {
        //                 data: 'terlapor',
        //                 name: 'terlapor'
        //             },
        //             {
        //                 data: 'pangkatName.name',
        //                 name: 'pangkatName.name'
        //             },
        //             {
        //                 data: 'nama_korban',
        //                 name: 'nama_korban'
        //             },
        //             {
        //                 data: 'status.name',
        //                 name: 'status.name'
        //             },
        //         ]
        //     });
        //     $('#kt_search').on('click', function(e) {
        //         e.preventDefault();
        //         table.table().draw();
        //     });
        // }

        $('input[type="date"]').on('keydown', function(){
            return false
        })

        $('#import-dumas').on('submit', function(){
            var data = $(this).serializeArray()
            $.ajax({
                url: `data-yanduan/import`,
                method: 'POST',
                data: data,
                beforeSend: () => {
                    $.LoadingOverlay("show");
                },
                success:(res) => {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Berhasil',
                        text: 'Berhasil Import data dumas dari yanduan',
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
                    onAjaxError(xhr)
                }
            })
        })
    </script>
@endsection
