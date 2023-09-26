@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <style>
        #chartdiv, #chartDonat {
            width: 100%;
            height: 500px;
            color: #ffffff
        }

        #chartBubble {
            width: 100%;
            max-width: 100%;
            height: 550px;
            #ffffff
        }

        /* #chartdiv, #chartDonat, #chartBubble {

        } */
    </style>
@endprepend


@section('content')
    {{-- STAT --}}
    <div class="row">
        <div class="col col-md-4 col-xl-4">
            <div class="card bg-c-blue order-card">
                <div class="card-body">
                    <h6 class="m-b-20">Total Pelanggar</h6>
                    <h2 class="text-right"><i class="fa fa-gavel f-left mr-3"></i><span>  {{count($pelanggar)}}</span></h2>
                </div>
            </div>
        </div>

        <div class="col col-md-4 col-xl-4">
            <div class="card bg-c-green order-card">
                <div class="card-body">
                    <h6 class="m-b-20">Total Pengaduan Diproses</h6>
                    <h2 class="text-right"><i class="fa fa-chart-line f-left"></i><span>  {{count($pengaduan_diproses)}}</span></h2>
                </div>
            </div>
        </div>

        <div class="col col-md-4 col-xl-4">
            <div class="card bg-c-yellow order-card">
                <div class="card-body">
                    <h6 class="m-b-20">Total Polda</h6>
                    <h2 class="text-right"><i class="fa fa-building f-left"></i><span>  {{count($polda)}}</span></h2>
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
            <h5 class="text-center">Total Pelanggaran Berdasarkan Pangkat</h5>
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
            var labels = [];
            var users = [];

            @foreach($kasus_by_month as $key => $val)
                labels.push(`{{$key}}`)
                users.push(`{{$val}}`)
            @endforeach

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Statistik Jumlah Pelanggar tahun '+new Date().getFullYear(),
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
            var labels = [];
            var users = [];
            var background = [];
            var fillColor = ['#008FFB', '#00E396', '#775DD0', '#FEB019', '#FF4560'];
            @foreach($kasus_by_pangkat as $key => $val)
                labels.push(`{{$key}}`)
                users.push(`{{$val}}`)
                background.push(fillColor[Math.floor(Math.random()*fillColor.length)])
            @endforeach

            const data = {
                labels: labels,
                datasets: [{
                    label: 'Total Pelanggaran',
                    backgroundColor: background,
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
