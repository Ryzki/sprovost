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

        #lineChartPelanggar{
            max-width: 100%;
        }

        #chart {
            max-width: 650px;
            margin: 35px auto;
        }
        /* #chartdiv, #chartDonat, #chartBubble {

        } */
    </style>
@endprepend


@section('content')
    {{-- STAT --}}
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="row">
                            <div class="col-xl-12 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Kasus</p>
                                                <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value"
                                                        data-target="{{ count($pelanggar) }}">0</span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-success rounded fs-3">
                                                    <i class="fa fa-gavel text-success"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                    <div class="animation-effect-6 text-success opacity-25 fs-18">
                                        <i class="fa fa-gavel"></i>
                                    </div>
                                    <div class="animation-effect-4 text-success opacity-25 fs-18">
                                        <i class="mdi mdi-gavel"></i>
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-12 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-info rounded fs-3">
                                                    <i class="bx bx-pie-chart-alt-2 text-info"></i>
                                                </span>
                                            </div>
                                            <div class="text-end flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Pengaduan Diprores</p>
                                                <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" data-target="{{count($pengaduan_diproses)}}">0</span></h4>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                    <div class="animation-effect-6 text-info opacity-25 fs-18">
                                        <i class="bi bi-pie-chart-fill"></i>
                                    </div>
                                    <div class="animation-effect-4 text-info opacity-25 fs-18">
                                        <i class="mdi mdi-chart-box"></i>
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end col -->

                            <div class="col-xl-12 col-md-6">
                                <!-- card -->
                                <div class="card card-animate">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="flex-grow-1">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Polda</p>
                                                <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" data-target="{{count($polda)}}">0</span></h4>
                                            </div>
                                            <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-soft-warning rounded fs-3">
                                                    <i class="bx bx-user-circle text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                    <div class="animation-effect-6 text-warning opacity-25 fs-18">
                                        <i class="bi bi-person"></i>
                                    </div>
                                    <div class="animation-effect-4 text-warning opacity-25 fs-18">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="animation-effect-3 text-warning opacity-25 fs-18">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div> <!-- end row-->
                    </div>
                    <div class="col-xl-8">
                        <div class="card card-animate">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Statistik Jumlah Pelanggar Tahun {{\Carbon\Carbon::now()->translatedFormat('Y')}}</h4>
                            </div><!-- end card header -->

                            <div class="card-body p-0 pb-2">
                                <div id="lineChartPelanggar"></div>

                                <div id="chart">
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.2/js/dataTables.bootstrap5.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script>
        $(document).ready(function() {
            getData();
            lineChartPelanggar();
            // donatChartPelanggar();
        });

        function lineChartPelanggar() {
            var month = [];
            var data = [];

            @foreach($kasus_by_month as $key => $val)
                month.push(`{{$key}}`)
                data.push(`{{$val}}`)
            @endforeach

            var options = {
                series: [{
                    name: 'Data Pelanggaran',
                    data: data
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    toolbar:{
                        show:false
                    }
                },
                forecastDataPoints: {
                    count: 5
                },
                stroke: {
                    width: 5,
                    curve: 'smooth'
                },
                xaxis: {
                    type: 'category',
                    categories: month,
                    tickAmount: month.length,
                    // labels: month
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: [ '#FDD835'],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100]
                    },
                },
                yaxis: {
                    min: 0,
                    max: 40
                }
            };

            var chart = new ApexCharts(document.querySelector("#lineChartPelanggar"), options);
            chart.render();
        }

        function donatChartPelanggar() {
            var labels = [];
            var users = [];
            var background = [];
            var fillColor = ['#6fa8dc', '#18d3ef', '#3d85c6', '#72c7f1', '#9fc5e8'];
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
