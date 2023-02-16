@extends('partials.master')

@push('css')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
@endpush


@section('content')
    {{-- STAT --}}
    <div class="row">
        <div class="col col-md-4 col-xl-4">
            <div class="card bg-c-blue order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Pelanggar</h6>
                    <h2 class="text-right"><i class="fa fa-gavel f-left"></i><span>486</span></h2>
                </div>
            </div>
        </div>

        <div class="col col-md-4 col-xl-4">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Pengaduan Diproses</h6>
                    <h2 class="text-right"><i class="fa fa-refresh f-left"></i><span>486</span></h2>
                </div>
            </div>
        </div>

        <div class="col col-md-4 col-xl-4">
            <div class="card bg-c-yellow order-card">
                <div class="card-block">
                    <h6 class="m-b-20">Total Polda</h6>
                    <h2 class="text-right"><i class="fa fa-institution f-left"></i><span>486</span></h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Line Chart --}}
    <div class="row mb-5">
        <div class="col-8">
            <canvas id="lineChartPelanggar"></canvas>
        </div>
        <div class="col-4">
            <canvas id="donatChartPelanggar"></canvas>
        </div>

    </div>

    {{-- DataTable list pelanggar --}}
    <div class="row mb-5">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">List Pelanggar</h4>

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
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            getData();
            lineChartPelanggar();
            donatChartPelanggar();
        });

        function lineChartPelanggar() {
            var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des', ''];
            var users = [100, 50, 11, 34, 86, 56, 2, 36, 50, 20, 10, 150];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Statistik Jumlah Pelanggar tahun 2022',
                    backgroundColor: 'rgb(255, 99, 132)',
                    borderColor: 'rgb(255, 99, 132)',
                    data: users,
                }]
            };

            const config = {
                type: 'line',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('lineChartPelanggar'),
                config
            );
        }

        function donatChartPelanggar() {
            var labels = ['Metro Jaya', 'Jabar', 'Jateng', 'Jatim'];
            var users = [50, 20, 75, 25];

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Pelanggar',
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(50, 205, 50)',
                        'rgb(255, 255, 0)'
                    ],
                    data: users,
                }]
            };

            const config = {
                type: 'pie',
                data: data,
                options: {}
            };

            const myChart = new Chart(
                document.getElementById('donatChartPelanggar'),
                config
            );
        }

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
