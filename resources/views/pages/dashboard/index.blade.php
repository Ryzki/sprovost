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

    <div class="row mt-4">
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
                                                    <i class="bx bxs-buildings text-warning"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                    <div class="animation-effect-6 text-warning opacity-25 fs-18">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <div class="animation-effect-4 text-warning opacity-25 fs-18">
                                        <i class="mdi mdi-office-building"></i>
                                    </div>
                                </div><!-- end card -->
                            </div><!-- end col -->
                        </div> <!-- end row-->
                    </div>
                    <div class="col-xl-8">
                        <div class="card card-animate">
                            <div class="card-header border-0 align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Statistik Jumlah Dumas Tahun {{\Carbon\Carbon::now()->translatedFormat('Y')}}</h4>
                            </div><!-- end card header -->

                            <div class="card-body p-0 pb-2">
                                <div id="lineChartPelanggar">
                                    <div class="loader-view" style="display:block;">
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div>
            </div>
        </div>
    </div>

    {{-- Dumas per status, limpah, unit --}}
    <div class="row">
        <div class="col-xl-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Data Dumas Berdasarkan Status</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" id="dumas_by_status" data-target="0">0</span></h4>
                            <select name="filter_by_status" class="form-control form-select" id="" style="border: 0 !important">
                                @foreach ($list_status as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-success rounded fs-3">
                                <i class="mdi mdi-progress-check text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-success opacity-25 fs-18">
                    <i class="mdi mdi-progress-check"></i>
                </div>
                <div class="animation-effect-4 text-success opacity-25 fs-18">
                    <i class="mdi mdi-progress-check"></i>
                </div>
            </div><!-- end card -->
        </div>
        <div class="col-xl-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Limpah Wabprof / Jajaran</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" id="dumas_by_limpah" data-target="">0</span></h4>
                            <select name="filter_by_limpah" class="form-control form-select" id="" style="border: 0 !important">
                                @foreach ($list_polda as $polda)
                                    <option value="{{$polda->id}}">{{$polda->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-info rounded fs-3">
                                <i class="mdi mdi-file-document-multiple text-info"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
                <div class="animation-effect-6 text-info opacity-25 fs-18">
                    <i class="mdi mdi-file-document-multiple"></i>
                </div>
                <div class="animation-effect-4 text-info opacity-25 fs-18">
                    <i class="mdi mdi-file-document-multiple"></i>
                </div>
            </div><!-- end card -->
        </div>
        <div class="col-xl-4">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted text-truncate fs-13">Total Dumas Berdasarkan Unit</p>
                            <h4 class="fs-22 fw-semibold mb-3"><span class="counter-value" id="dumas_by_unit" data-target="0">0</span></h4>
                            <select name="filter_by_unit" class="form-control form-select" id="" style="border: 0 !important">
                                @foreach ($list_unit as $unit)
                                    <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                <i class="bx bxs-group text-warning"></i>
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
        </div>
    </div>

    {{-- Dumas Triwulan --}}
    <div class="card card-animate">
        <div class="card-body">
            <h4 class="text-muted text-semibold">
                Rekap Data Dumas Per-Triwulan
            </h4>
            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                    <div class="flex-grow-1">
                        <div id="chartDonutT1">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                    <div class="flex-grow-1">
                        <div id="chartDonutT2">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                    <div class="flex-grow-1">
                        <div id="chartDonutT3">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-12 col-sm-12">
                    <div class="flex-grow-1">
                        <div id="chartDonutT4">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dumas Semester --}}
    <div class="card card-animate">
        <div class="card-body">
            <h4 class="text-muted text-semibold">
                Rekap Data Dumas Per-Triwulan
            </h4>
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="flex-grow-1">
                        <div id="chartRekapSemester1">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="flex-grow-1">
                        <div id="chartRekapSemester2">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistik Penyelesaian Dumas per Unit --}}
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="flex-grow-1">
                        <div class="row justify-content-between align-items-center mb-3">
                            <div class="col-xl-7 col-lg-7 col-md-7 col-12">
                                <h4 class="text-muted text-semibold">
                                    Data Progress Dumas Per-Unit
                                </h4>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-12">
                                <div class="form-group">
                                    <select name="persentase_filter_by_unit" class="form-control form-select" id="" style="border: 0 !important">
                                        @foreach ($list_unit as $unit)
                                            <option value="{{$unit->unit}}">{{$unit->unit}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="persentaseDumasByUnit">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="flex-grow-1">
                        <div class="row justify-content-between align-items-center mb-3">
                            <div class="col-xl-7 col-lg-7 col-md-7 col-12">
                                <h4 class="text-muted text-semibold">
                                    Data Total Dumas Per-Status
                                </h4>
                            </div>
                        </div>

                        <div class="row" id="totalDumasByStatus">
                            <div class="loader-view" style="display:block;">
                            </div>
                        </div>
                    </div>
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
            // getData();
            getDataByStatus();
            getDataByLimpah();
            getDataByUnit();

            getChartData('rekap_tahunan', 'line', '#lineChartPelanggar');
            getChartData('rekap_triwulan1', 'donut', '#chartDonutT1')
            getChartData('rekap_triwulan2', 'donut', '#chartDonutT2')
            getChartData('rekap_triwulan3', 'donut', '#chartDonutT3')
            getChartData('rekap_triwulan4', 'donut', '#chartDonutT4')
            getChartData('rekap_semester1', 'donut', '#chartRekapSemester1')
            getChartData('rekap_semester2', 'donut', '#chartRekapSemester2')
            getChartData('persentase_by_unit', 'bar', '#persentaseDumasByUnit')
            getChartData('total_by_status', 'bar', '#totalDumasByStatus')
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

        function getDataByStatus(status_id = ''){
            let url = `{{url('/get-data-by-status/${status_id}')}}`
            $.ajax({
                url: url,
                method: "get"
            }).done(function(data) {
                $('#dumas_by_status').data('target', data)
                $('#dumas_by_status').html(data)
            });
        }

        function getDataByLimpah(limpah_id = ''){
            let url = `{{url('/get-data-limpah/${limpah_id}')}}`
            $.ajax({
                url: url,
                method: "get"
            }).done(function(data) {
                $('#dumas_by_limpah').data('target', data)
                $('#dumas_by_limpah').html(data)
            });
        }

        function getDataByUnit(unit = ''){
            let url = `{{url('/get-data-unit/${unit}')}}`
            $.ajax({
                url: url,
                method: "get"
            }).done(function(data) {
                $('#dumas_by_unit').data('target', data)
                $('#dumas_by_unit').html(data)
            });
        }

        function getChartData(tipe, chartType, containerId){
            let url = `{{url('/get-chart-data/${tipe}')}}`
            $.ajax({
                url: url,
                method: "get"
            }).done(function(data) {
                $('.loader-view').fadeOut();
                if(chartType == 'line'){
                    lineChartPelanggar(data, tipe, containerId)
                } else if(chartType == 'donut'){
                    donatChartPelanggar(data, tipe, containerId)
                } else if(chartType == 'bar'){
                    barChartPelanggar(data, tipe, containerId)
                }
            });
        }

        function lineChartPelanggar(data, tipe, containerId) {
            var label = [];
            var series = [];
            var seriesOption,xaxisOption,fillOption, title;
            if(tipe == 'rekap_tahunan'){
                const newData = data.kasus_by_month
                for (let kasus in newData){
                    label.push(kasus)
                    series.push(newData[kasus])
                }

                seriesOption = [{
                    name: 'Data Pelanggaran',
                    data: series
                }]

                xaxisOption = {
                    type: 'category',
                    categories: label,
                    tickAmount: label.length,
                }

                fillOption = {
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
                }

                renderChart()
            }

            function renderChart(){
                var options = {
                    series: seriesOption,
                    chart: {
                        height: 330,
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
                    xaxis: xaxisOption,
                    fill: fillOption,
                    yaxis: {
                        min: 0,
                        max: 40
                    }
                };

                var chart = new ApexCharts(document.querySelector(`${containerId}`), options);
                chart.render();
            }

        }

        function donatChartPelanggar(data, tipe, containerId) {
            var label = [];
            var series = [];
            var seriesOption,xaxisoption, fillOption, titleOption, plotOption, colorsOption;

            if(tipe == 'rekap_triwulan1'){
                colorsOption = ['#2EA6CC','#342A29']
                const newData = data.dumas_triwulan
                titleOption = {
                    text: 'TRIWULAN 1',
                    align: 'center'
                }

                plotOption = {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL T1',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return newData['T1 : Januari - Maret']
                                    }
                                }
                            }
                        }
                    }
                }

                let totalOtherQuarter = 0;
                let otherQuarterLabel = '';
                for(let quarter in newData){
                    if(quarter.includes('T1')){
                        series.push(newData[quarter])
                        label.push(quarter)
                    } else {
                        totalOtherQuarter += newData[quarter]
                        otherQuarterLabel += `${quarter}, `
                    }
                }
                series.push(totalOtherQuarter)
                otherQuarterLabel = otherQuarterLabel.slice(0, -2)
                label.push(otherQuarterLabel)

                renderChart()
            } else if(tipe == 'rekap_triwulan2'){
                colorsOption = ['#2EA6CC','#342A29']
                const newData = data.dumas_triwulan
                titleOption = {
                    text: 'TRIWULAN 2',
                    align: 'center'
                }

                plotOption = {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL T2',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return newData['T2 : April - Juni']
                                    }
                                }
                            }
                        }
                    }
                }

                let totalOtherQuarter = 0;
                let otherQuarterLabel = '';
                for(let quarter in newData){
                    if(quarter.includes('T2')){
                        series.push(newData[quarter])
                        label.push(quarter)
                    } else {
                        totalOtherQuarter += newData[quarter]
                        otherQuarterLabel += `${quarter}, `
                    }
                }
                series.push(totalOtherQuarter)
                otherQuarterLabel = otherQuarterLabel.slice(0, -2)
                label.push(otherQuarterLabel)

                renderChart()
            } else if(tipe == 'rekap_triwulan3'){
                colorsOption = ['#2EA6CC','#342A29']
                const newData = data.dumas_triwulan
                titleOption = {
                    text: 'TRIWULAN 3',
                    align: 'center'
                }

                plotOption = {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL T3',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return newData['T3 : Juli - September']
                                    }
                                }
                            }
                        }
                    }
                }

                let totalOtherQuarter = 0;
                let otherQuarterLabel = '';
                for(let quarter in newData){
                    if(quarter.includes('T3')){
                        series.push(newData[quarter])
                        label.push(quarter)
                    } else {
                        totalOtherQuarter += newData[quarter]
                        otherQuarterLabel += `${quarter}, `
                    }
                }
                series.push(totalOtherQuarter)
                otherQuarterLabel = otherQuarterLabel.slice(0, -2)
                label.push(otherQuarterLabel)

                renderChart()
            } else if(tipe == 'rekap_triwulan4'){
                colorsOption = ['#2EA6CC','#342A29']
                const newData = data.dumas_triwulan
                titleOption = {
                    text: 'TRIWULAN 4',
                    align: 'center'
                }

                plotOption = {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL T3',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return newData['T4 : Oktober - Desember']
                                    }
                                }
                            }
                        }
                    }
                }

                let totalOtherQuarter = 0;
                let otherQuarterLabel = '';
                for(let quarter in newData){
                    if(quarter.includes('T4')){
                        series.push(newData[quarter])
                        label.push(quarter)
                    } else {
                        totalOtherQuarter += newData[quarter]
                        otherQuarterLabel += `${quarter}, `
                    }
                }
                series.push(totalOtherQuarter)
                otherQuarterLabel = otherQuarterLabel.slice(0, -2)
                label.push(otherQuarterLabel)

                renderChart()
            } else if(tipe == 'rekap_semester1'){
                colorsOption = ['#E9AC4E','#651915']
                const newData = data.dumas_semester
                titleOption = {
                    text: 'SEMESTER 1',
                    align: 'center'
                }

                plotOption = {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL SEMESTER 1',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return newData['S1 : Januari - Juni']
                                    }
                                }
                            }
                        }
                    }
                }

                let totalOtherQuarter = 0;
                let otherQuarterLabel = '';
                for(let quarter in newData){
                    series.push(newData[quarter])
                    label.push(quarter)
                }

                renderChart()
            } else if(tipe == 'rekap_semester2'){
                colorsOption = ['#E9AC4E','#651915']
                var newData = data.dumas_semester
                var objectOrder = {
                    'S2 : Juli - Desember' : null,
                    'S1 : Januari - Juni' : null,
                }

                newData = Object.assign(objectOrder, newData)
                titleOption = {
                    text: 'SEMESTER 2',
                    align: 'center'
                }

                plotOption = {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                total: {
                                    label:'TOTAL SEMESTER 2',
                                    showAlways: true,
                                    show: true,
                                    formatter: function () {
                                        return newData['S2 : Juli - Desember']
                                    }
                                }
                            }
                        }
                    }
                }

                let totalOtherQuarter = 0;
                let otherQuarterLabel = '';
                for(let quarter in newData){
                    series.push(newData[quarter])
                    label.push(quarter)
                }

                renderChart()
            }

            function renderChart(){
                var options = {
                    series: series,
                    colors: colorsOption,
                    labels: label,
                    chart: {
                        type: 'donut',
                        animate: true,
                        height: 500
                    },
                    title: titleOption,
                    legend : {
                        position: 'bottom',
                        horizontalAlign: 'left',
                        floating: false,
                    },
                    responsive: [{
                        breakpoint: 400,
                        options: {
                            chart: {
                                height: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }],
                    plotOptions: plotOption,
                };

                var chart = new ApexCharts(document.querySelector(`${containerId}`), options);
                chart.render();
            }

        }

        function barChartPelanggar(data, tipe, containerId){
            var label = [];
            var series = [];
            var seriesOption,xaxisOption,fillOption, title, colorsOption;

            tipe = tipe.split('?')[0]
            if(tipe == 'persentase_by_unit'){
                for (let status in data){
                    let tempSeries = []
                    for(let month in data[status]){
                        tempSeries.push(data[status][month])
                        if(label.length < 12){
                            label.push(month)
                        }
                    }

                    series.push({
                        'name' : status,
                        'data' : tempSeries
                    })
                }

                seriesOption = series
                xaxisOption = {
                    type: 'category',
                    categories: label,
                    tickAmount: label.length,
                    title: {
                        text: 'Bulan'
                    }
                }

                fillOption = {
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
                }

                colorsOption = ['#651915', '#2EA6CC', '#DDDB32', '#E9AC4E']
                title = {
                    text: 'TOTAL DUMAS PERUNIT BERDASARKAN STATUS',
                    align: 'center'
                }

                renderChart()
            } else if (tipe == 'total_by_status'){
                for (let status in data){
                    let tempSeries = []
                    for(let month in data[status]){
                        tempSeries.push(data[status][month])
                        if(label.length < 12){
                            label.push(month)
                        }
                    }

                    series.push({
                        'name' : status,
                        'data' : tempSeries
                    })
                }

                seriesOption = series
                xaxisOption = {
                    type: 'category',
                    categories: label,
                    tickAmount: label.length,
                    title: {
                        text: 'Bulan'
                    }
                }

                fillOption = {
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
                }

                colorsOption = ['#E9AC4E', '#DDDB32', '#2EA6CC', '#651915']
                title = {
                    text: 'TOTAL DUMAS BERDASARKAN STATUS',
                    align: 'center'
                }

                renderChart()
            }

            function renderChart(){
                var options = {
                    series: seriesOption,
                    animate: true,
                    chart: {
                        height: 350,
                        type: 'bar',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        toolbar: {
                            show: true
                        }
                    },
                    colors: colorsOption,
                    dataLabels: {
                        enabled: true,
                    },
                    stroke: {
                        curve: 'monotoneCubic',
                        lineCap: 'butt',
                    },
                    title: title,
                    grid: {
                        // borderColor: '#e7e7e7',
                        row: {
                            // colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    markers: {
                        size: 1
                    },
                    xaxis: xaxisOption,
                    yaxis: {
                        title: {
                            text: 'Jumlah Dumas'
                        },
                        min: 0,
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'left',
                        // floating: false,
                        offsetY: 10,
                    }
                };

                var chart = new ApexCharts(document.querySelector(`${containerId}`), options);
                chart.render();
            }
        }

        $('select[name="filter_by_status"]').on('change', function(){
            const selected = $(this).val()
            getDataByStatus(selected)
        })

        $('select[name="filter_by_limpah"]').on('change', function(){
            const selected = $(this).val()
            getDataByLimpah(selected)
        })

        $('select[name="filter_by_unit"]').on('change', function(){
            const selected = $(this).val()
            getDataByUnit(selected)
        })

        $('select[name="persentase_filter_by_unit"]').on('change', function(){
            const selected = $(this).val()
            $('#persentaseDumasByUnit').html('')
            getChartData(`persentase_by_unit?unit=${selected}`, 'bar', '#persentaseDumasByUnit')
        })
    </script>
@endsection
