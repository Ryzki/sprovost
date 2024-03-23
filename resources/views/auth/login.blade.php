<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign In | DMS PROVOS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/icon/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>

    <section class="auth-bg-cover min-vh-100 p-4 p-lg-5 d-flex align-items-center justify-content-center">
        <div class="bg-overlay"></div>
        <div class="container-fluid px-0">
            <div class="row g-0">
                <div class="col-xl-8 col-lg-6">
                    {{-- <div class="h-100 mb-0 p-4 d-flex flex-column justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <img src="assets/images/provos_light.png" alt="" height="32" />
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!--end col-->
                <div class="col-xl-4 col-lg-6">
                    <div class="card mb-0" style="opacity: 0.9;">
                        <div class="card-body p-3 p-sm-5 m-lg-2">
                            <div class="text-center">
                                <img width="25%" src="{{ asset('assets/images/Provos.png') }}" alt="">
                                <h5 class="text-primary fs-22">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Propam Integrated System.</p>
                            </div>
                            <div class="p-2 mt-5">
                                <form action="{{ route('login-action') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input  type="text" class="form-control" id="username" name="username"
                                            placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        {{-- <div class="float-end">
                                            <a href="auth-pass-reset-basic.html" class="text-muted">Forgot password?</a>
                                        </div> --}}
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input  type="password" class="form-control pe-5 password-input"
                                                name="password" placeholder="Enter password" id="password-input">
                                            <button
                                                class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                type="button" id="password-addon"><i
                                                    class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                    </div>
                                </form>

                                {{-- <div class="text-center mt-5">
                                    <p class="mb-0">Don't have an account ? <a href="auth-signup-cover.html"
                                            class="fw-semibold text-secondary text-decoration-underline"> SignUp</a>
                                    </p>
                                </div> --}}
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end conatiner-->
    </section>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>

    <script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>

</body>

</html>
