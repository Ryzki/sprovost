@extends('partials.master')

@section('content')
    <div class="row">
        <div class="col-xl-12 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Kasus</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value"
                                    data-target="{{ count($kasuss) }}">0</span></h4>
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="text-success fs-12 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i> +18.30 %
                                </h5>
                                <p class="text-muted mb-0">than last week</p>
                            </div>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-success rounded fs-3">
                                <i class="bx bx-dollar-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-success opacity-25 fs-18">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="animation-effect-4 text-success opacity-25 fs-18">
                    <i class="bi bi-currency-pound"></i>
                </div>
                <div class="animation-effect-3 text-success opacity-25 fs-18">
                    <i class="bi bi-currency-euro"></i>
                </div>
            </div><!-- end card -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Kasus</h4>

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
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            getData()
        });

        function getData() {
            var table = $('#data-data').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: "{{ route('kasus.data') }}",
                    method: "post",
                    data: function(data) {
                        data._token = '{{ csrf_token() }}'
                        // data.polda = $('#polda').val(),
                        // data.jenis_kelamin = $('#jenis_kelamin').val(),
                        // data.jenis_pelanggaran = $('#jenis_pelanggaran').val(),
                        // data.pangkat = $('#pangkat').val(),
                        // data.wujud_perbuatan = $('#wujud_perbuatan').val()
                    }
                },
                columns: [
                    // {
                    //     data: 'DT_RowIndex',
                    //     name: 'DT_RowIndex',
                    //     orderable: false,
                    //     searchable: false
                    // },
                    {
                        data: 'no_nota_dinas',
                        name: 'no_nota_dinas'
                    },
                    {
                        data: 'tanggal_kejadian',
                        name: 'tanggal_kejadian'
                    },
                    {
                        data: 'pelapor',
                        name: 'pelapor'
                    },
                    {
                        data: 'terlapor',
                        name: 'terlapor'
                    },
                    {
                        data: 'pangkat',
                        name: 'pangkat'
                    },
                    {
                        data: 'nama_korban',
                        name: 'nama_korban'
                    },
                    {
                        data: 'status.name',
                        name: 'status.name'
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
