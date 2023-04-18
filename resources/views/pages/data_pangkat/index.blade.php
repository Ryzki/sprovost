@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endprepend

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Pangkat</h4>
                    <div class="float-right">
                        <a href="{{ route('pangkat.input') }}" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah Pangkat</a>
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card px-3">
                        <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script>
        $(document).ready(function() {
            getData()
        });

        function hapus(id){
            $.confirm({
                title: 'Perhatian!',
                content: 'Apa kamu yakin akan menghapus data ini?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    yes: {
                        keys: ['y'],
                        action: function () {
                            var url = "{{route('pangkat.hapus', ':id')}}";
                            url = url.replace(':id', id);
                            var table = $('#data-data').DataTable();
                            var $button = $(this);
                            $.ajax({
                                type: "GET",
                                url: url,
                                success: function (response) {
                                    table.row( $button.parents('tr') ).remove().draw();
                                    $.confirm({
                                        title: 'Perhatian!',
                                        content: 'Data anda berhasil di hapus!',
                                        type: 'green',
                                        typeAnimated: true,
                                        buttons: {
                                            tryAgain: {
                                                text: 'OK',
                                                action: function(){
                                                }
                                            },
                                        }
                                    });
                                },
                                error: function (e) {
                                }
                            });
                        }
                    },
                    no: {
                        keys: ['N'],
                        action: function () {
                            $(this).hide();
                        }
                    },
                }
            });
        }

        function getData() {
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('pangkat.data') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                    }
                },
                columns: [
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
            $('#kt_search').on('click', function(e) {
                e.preventDefault();
                table.table().draw();
            });
        }
    </script>
@endsection
