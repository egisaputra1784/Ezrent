<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | Aplikasi</title>

    <!-- base:css -->
    <link rel="stylesheet" href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/css/vendor.bundle.base.css">
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/css/vertical-layout-light/style.css">
    <link rel="shortcut icon" href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/images/favicon.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">

                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center">
                                <img src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/images/logo.svg" alt="logo">
                            </div>

                            <h4 class="text-center">Welcome back 👋</h4>
                            <h6 class="font-weight-light text-center mb-4">
                                Login untuk melanjutkan
                            </h6>

                            {{-- ALERT ERROR --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{-- FORM LOGIN --}}
                            <form class="pt-3" method="POST" action="{{ route('login.process') }}">
                                @csrf

                                <div class="form-group">
                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="Email"
                                        value="{{ old('email') }}"
                                        required
                                    >
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Password"
                                        required
                                    >
                                    @error('password')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button
                                        type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        SIGN IN
                                    </button>
                                </div>

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="#" class="auth-link text-black">Forgot password?</a>
                                </div>
                            </form>
                            {{-- END FORM --}}

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- base:js -->
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/js/vendor.bundle.base.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/off-canvas.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/hoverable-collapse.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/template.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/settings.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/todolist.js"></script>
</body>

</html>
