<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <!-- Sweet Alert-->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
        @yield('lib')
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <style>
            #loading {
                position: fixed;
                left: 0;
                top: 0;
                height: 100vh;
                right: 0;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            #loading img{
                width: 150px;
            }
            .footer {
                left: 0;
            }
        </style>
        @yield('extension_style')

        @yield('style');

    </head>

    <body data-sidebar="dark">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('backend.elements.header')


            <!-- ========== Left Sidebar Start ========== -->
            @include('backend.elements.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content" style="position: relative; min-height: 97vh">
                <div class="page-content">
                    @yield('content')
                    <!-- container-fluid -->
                        <div id="loading" style="display: none;">
                            <img  src="{{ asset('assets/images/loading.gif') }}" alt="">
                        </div>
                </div>
                <!-- End Page-content -->
            <!-- end main content-->
                @include('backend.elements.footer')
            </div>

        </div>
        <!-- END layout-wrapper -->


        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

        <!--Morris Chart-->
        <script src="{{ asset('assets/libs/morris.js/morris.min.js') }}"></script>
        <script src="{{ asset('assets/libs/raphael/raphael.min.js') }}"></script>

        <!-- Sweet Alerts js -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <!-- Plugins js -->
        <script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>

        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script src="{{ asset('assets/js/common.js') }}"></script>

        @yield('extension_script')
        @yield('script')
    </body>

</html>
