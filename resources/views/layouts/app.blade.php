<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Al-Izzah Income School Application</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="SHORTCUT ICON" href="{{ asset('alizzah.png') }}" type="image/x-icon" />

    @stack('style')

    <style>
        a.nav-link.active {
            background: transparent !important;
            box-shadow: none !important;
            color: white !important;
        }

        .loading-halaman::before {
            content: " ";
            display: block;
            position: fixed;
            z-index: 9999;
            height: 3px;
            width: 100%;
            top: 0;
            left: 0;
            background-color: #1a73e8;
            -webkit-animation: load-halaman ease-out 2s;
            animation: load-halaman ease-out 2s;
        }

        @-webkit-keyframes load-halaman {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        @keyframes load-halaman {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="loading-halaman">

    </div>
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ asset('adminlte/index3.html') }}" class="brand-link">
                <img src="{{ asset('alizzah.png') }}" alt="AdminLTE Logo" class="brand-image img-circle"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">PPTQ AL-IZZAH</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('avatar_admin.png') }}" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#"
                            class="d-block">{{ @Auth::user()->name == null ? 'Admin' : @Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-igloo"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        @if (auth::user()->role == 'admin-master')
                            @include('menu.admin')
                        @elseif(auth::user()->role == 'admin-keuangan')
                            @include('menu.keuangan')
                        @elseif(auth::user()->role == 'admin-kantin')
                            @include('menu.kantin')
                        @elseif(auth::user()->role == 'siswa')
                            @include('menu.siswa')
                        @endif
                        
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="nav-icon fas fa-arrow-left"></i>
                                <p>Keluar</p>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 2.0
            </div>
            <strong>Template By <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
            Developed by <a href="https://sahretech.com">Nabil Sahretech</a>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('script')

    <script>
        $(document).ready(function() {
            $(".loading-halaman").delay(500).fadeOut("slow");
        });
    </script>
</body>

</html>