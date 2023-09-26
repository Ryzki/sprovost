<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">


<head>
    <meta charset="utf-8" />
    <title>Dashboard | Provost</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Dashboard Provost" name="description" />
    <!-- App favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/icon/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css"> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.2/css/dataTables.bootstrap5.min.css">

    {{-- <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .loader-view {
            margin-left: auto;
            margin-right: auto;
            margin-top: auto;
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid blue;
            border-bottom: 16px solid blue;
            width: 120px;
            height: 120px;
            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
        }

        .f1-steps {
            overflow: hidden;
            position: relative;
            margin-top: 20px;
        }

        .f1-progress {
            position: absolute;
            top: 24px;
            left: 0;
            width: 100%;
            height: 1px;
            background: #ddd;
        }

        .f1-progress-line {
            position: absolute;
            top: 0;
            left: 0;
            height: 1px;
            background: #338056;
        }

        .f1-step {
            position: relative;
            float: left;
            width: 20%;
            padding: 0 5px;
        }

        .f1-step-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin-top: 4px;
            background: #ddd;
            font-size: 16px;
            color: #fff;
            line-height: 40px;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border-radius: 50%;
        }

        .f1-step.activated .f1-step-icon {
            background: #fff;
            border: 1px solid #338056;
            color: #338056;
            line-height: 38px;
        }

        .f1-step.active .f1-step-icon {
            width: 48px;
            height: 48px;
            margin-top: 0;
            background: #0c19db;
            font-size: 22px;
            line-height: 48px;
        }

        .f1-step p {
            color: #ccc;
        }

        .f1-step.activated p {
            color: #338056;
        }

        .f1-step.active p {
            color: #338056;
        }

        .f1 fieldset {
            display: none;
            text-align: left;
        }

        .f1-buttons {
            text-align: right;
        }

        .f1 .input-error {
            border-color: #f35b3f;
        }

        .title h1,
        .title h2,
        .title h3,
        .title h4 {
            margin: 5px;
        }

        .title {
            position: relative;
            display: block;
            padding-bottom: 0;
            border-bottom: 3px double #dcdcdc;
            margin-bottom: 30px;
        }

        .title::before {
            width: 15%;
            height: 3px;
            background: #53bdff;
            position: absolute;
            bottom: -3px;
            content: '';
        }

        a {
            color: #53bdff;
            text-decoration: none;
            outline: 0;
        }

        a:hover {
            color: #06a0ff;
            text-decoration: none;
        }

        p {
            margin: 10px 0;
        }

        #editor {
            resize: vertical;
            overflow: auto;
            line-height: 1.5;
            background-color: #fafafa;
            background-image: none;
            border: 0;
            border-bottom: 1px solid #3b8dbd;
            min-height: 500px;
            box-shadow: none;
            padding: 8px 16px;
            margin: 0 auto;
            font-size: 14px;
            transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
        }

        #editor:focus {
            background-color: #f0f0f0;
            border-color: #38af5b;
            box-shadow: none;
            outline: 0 none;
        }

        .format-pre pre {
            background: #49483e;
            color: #f7f7f7;
            padding: 10px;
            font-size: 14px;
        }
    </style>

    @stack('styles')
</head>

<body>
    {{-- <script type="text/javascript" charset="utf-8">
        let a;
        let time;
        setInterval(() => {
            a = new Date();
            time = a.getHours() + ':' + a.getMinutes() + ':' + a.getSeconds();
            document.getElementById('current-time').innerHTML = time;
        }, 1000);
    </script> --}}
    <div id="layout-wrapper">
        <div class="top-tagbar">
            <div class="w-100">
                <div class="row justify-content-between align-items-center">
                    <div class="col-md-4 col-9">
                        <div class="text-white-50 fs-13">
                            <i class="bi bi-clock align-middle me-2"></i> <span id="current-time"></span>
                        </div>
                    </div>
                    {{-- <div class="col-md-4 col-6 d-none d-lg-block">
                        <div class="d-flex align-items-center justify-content-center gap-3 fs-13 text-white-50">
                            <div>
                                <i class="bi bi-envelope align-middle me-2"></i> support@themesbrand.com
                            </div>
                            <div>
                                <i class="bi bi-globe align-middle me-2"></i> www.themesbrand.com
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        @include('partials.navbar')

        @include('partials.sidebar')

        <div class="vertical-overlay"></div>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <div id="preloader">
            <div id="status">
                <div class="spinner-border text-primary avatar-sm" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>

        <div class="customizer-setting d-none d-md-block">
            <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
                data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
            </div>
        </div>


        <!-- Theme Settings -->
        @include('partials.theme')

        @include('partials.javascript')

        @yield('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
        <script>
            @if(Session::has('message'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.success("{{ session('message') }}");
            @endif

            @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.error("{{ session('error') }}");
            @endif

            @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.info("{{ session('info') }}");
            @endif

            @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
                    toastr.warning("{{ session('warning') }}");
            @endif
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "700",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
          </script>

    </div>

</body>

</html>
