<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EZRent || @yield('title')</title>
    <!-- base:css -->
    <link rel="stylesheet"
        href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet"
        href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet"
        href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon"
        href="{{ asset('celestialAdmin-free-admin-template-main/template') }}/images/favicon.png" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    @stack('css')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->

        @includeIf('layouts.navbar')


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->
            <div class="theme-setting-wrapper">
                <div id="settings-trigger"><i class="typcn typcn-cog-outline"></i></div>
                <div id="theme-settings" class="settings-panel">
                    <i class="settings-close typcn typcn-delete-outline"></i>
                    <p class="settings-heading">SIDEBAR SKINS</p>
                    <div class="sidebar-bg-options" id="sidebar-light-theme">
                        <div class="img-ss rounded-circle bg-light border mr-3"></div>
                        Light
                    </div>
                    <div class="sidebar-bg-options selected" id="sidebar-dark-theme">
                        <div class="img-ss rounded-circle bg-dark border mr-3"></div>
                        Dark
                    </div>
                    <p class="settings-heading mt-2">HEADER SKINS</p>
                    <div class="color-tiles mx-0 px-4">
                        <div class="tiles success"></div>
                        <div class="tiles warning"></div>
                        <div class="tiles danger"></div>
                        <div class="tiles primary"></div>
                        <div class="tiles info"></div>
                        <div class="tiles dark"></div>
                        <div class="tiles default border"></div>
                    </div>
                </div>
            </div>
            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->

            @includeIf('layouts.sidebar')

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">


                    @yield('content')


                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->

                @includeIf('layouts.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- base:js -->
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/chart.js/Chart.min.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/off-canvas.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/hoverable-collapse.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/template.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/settings.js"></script>
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/todolist.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script
        src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/vendors/progressbar.js/progressbar.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="{{ asset('celestialAdmin-free-admin-template-main/template') }}/js/dashboard.js"></script>
    <!-- End custom js for this page-->

    @stack('scripts')

</body>

</html>
