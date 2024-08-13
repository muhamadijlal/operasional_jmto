<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('') }}assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    {{-- <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-eval' 'unsafe-inline' https://www.google.com https://www.gstatic.com;"> --}}

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | JMTO Operasional</title>

    <meta name="description" content="@yield('description', 'Deskripsi Default')">
    {{-- <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-eval';"> --}}
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('') }}assets/img/jmto.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/fonts/flag-icons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet"
        href="{{ asset('') }}assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet" href="{{ asset('') }}assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{ asset('') }}assets/vendor/js/helpers.js"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('') }}assets/js/config.js"></script>

    <style>

    #loading-screen {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    #loading-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    #loading-content img {
        width: 50px;
        /* Sesuaikan ukuran gambar loading */
    }

    #loading-content p {
        margin-top: 10px;
    }
    </style>

    @yield('css')
</head>

<body>
    @include('sweetalert::alert')
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->

            <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="container-xxl">
                    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                        <a href="/peserta/dashboard" class="app-brand-link gap-2">
                            {{-- <span class="app-brand-logo demo">
                  <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                      fill="#7367F0" />
                    <path
                      opacity="0.06"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                      fill="#161616" />
                    <path
                      opacity="0.06"
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                      fill="#161616" />
                    <path
                      fill-rule="evenodd"
                      clip-rule="evenodd"
                      d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                      fill="#7367F0" />
                  </svg>
                </span> --}}
                            <span class="app-brand-text demo menu-text fw-bold">JMTO Operasional</span>
                        </a>

                        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                            <i class="ti ti-x ti-sm align-middle"></i>
                        </a>
                    </div>

                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                            <i class="ti ti-menu-2 ti-sm"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <!-- Language -->


                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">

                                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama_pegawai }}&background=random&color=random"
                                            alt class="h-auto rounded-circle" />

                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">


                                                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama_pegawai }}&background=random&color=random"
                                                            alt class="h-auto rounded-circle" />


                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span
                                                        class="fw-semibold d-block">{{ auth()->user()->nama_pegawai}}</span>
                                                    {{-- <small class="text-muted">{{ auth()->user()->role}}</small>
                                                    --}}
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/admin/my-profile">
                                            <i class="ti ti-user-check me-2 ti-sm"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/logout">
                                            <i class="ti ti-logout me-2 ti-sm"></i>
                                            <span class="align-middle">Log Out</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>


                </div>
            </nav>

            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    {{-- @include('/admin/horizontalMenu') --}}

                    <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal  menu bg-menu-theme flex-grow-0">
                        <div class="container-xxl d-flex h-100">
                          <ul class="menu-inner">
                            <li class="menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                {{-- {{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} --}}
                                <a href="/admin/dashboard" class="menu-link" >
                                  <i class="menu-icon tf-icons ti ti-smart-home"></i>
                                  <div>Dashboards</div>
                                </a>
                            </li>
                            <li class="menu-item {{ request()->is('admin/tarif/*') ? 'active' : '' }}">
                                {{-- {{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} --}}
                                <a href="#" class="menu-link menu-toggle" >
                                  <i class="menu-icon tf-icons ti ti-file"></i>
                                  <div>Tarif</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item {{ request()->is('admin/tarif/dasar') ? 'active' : '' }}">
                                        <a href="/admin/tarif/dasar" class="menu-link" >
                                          <i class="menu-icon tf-icons ti ti-pencil"></i>
                                          <div>Dasar Tarif</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('admin/manajemen-tarif/*') ? 'active' : '' }}">

                                        <a href="#" class="menu-link menu-toggle" >
                                            <i class="menu-icon tf-icons ti ti-file"></i>
                                            <div>Manajemen Tarif</div>
                                          </a>
                                          <ul class="menu-sub">
                                            <li class="menu-item {{ request()->is('admin/manajemen-tarif/open') ? 'active' : '' }}">
                                                <a href="/admin/manajemen-tarif/open" class="menu-link" >
                                                  <i class="menu-icon tf-icons ti ti-pencil"></i>
                                                  <div>Tarif Open</div>
                                                </a>
                                            </li>
                                            <li class="menu-item {{ request()->is('admin/manajemen-tarif/close') ? 'active' : '' }}">
                                                <a href="/admin/manajemen-tarif/close" class="menu-link" >
                                                  <i class="menu-icon tf-icons ti ti-pencil"></i>
                                                  <div>Tarif Close</div>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li class="menu-item {{ request()->is('admin/petugas/*') ? 'active' : '' }}">
                                {{-- {{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} --}}
                                <a href="#" class="menu-link menu-toggle" >
                                  <i class="menu-icon tf-icons ti ti-user"></i>
                                  <div>Petugas</div>
                                </a>
                                <ul class="menu-sub">
                                    <li class="menu-item {{ request()->is('admin/petugas/buat-petugas') ? 'active' : '' }}">
                                        <a href="/admin/petugas/buat-petugas" class="menu-link" >
                                          <i class="menu-icon tf-icons ti ti-pencil"></i>
                                          <div>Buat Petugas</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('admin/petugas/buat-kartu-ops') ? 'active' : '' }}">
                                        <a href="/admin/petugas/buat-kartu-ops" class="menu-link" >
                                          <i class="menu-icon tf-icons ti ti-pencil"></i>
                                          <div>Buat Kartu Ops</div>
                                        </a>
                                    </li>
                                    <li class="menu-item {{ request()->is('admin/petugas/data-petugas') ? 'active' : '' }}">
                                        <a href="/admin/petugas/data-petugas" class="menu-link" >
                                          <i class="menu-icon tf-icons ti ti-pencil"></i>
                                          <div>Data Petugas</div>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item {{ request()->is('admin/log') ? 'active' : '' }}">
                                {{-- {{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }} --}}
                                <a href="/admin/logs" class="menu-link" >
                                    <i class="menu-icon fa-solid fa-clock-rotate-left"></i>
                                  <div>Logs</div>
                                </a>
                            </li>

                        </ul>
                    </div>
                  </aside>

                    <!-- / Menu -->

                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <div id="loading-screen">
                            <div id="loading-content">
                                <img src="{{ asset('') }}assets/img/loading.gif" alt="Loading..." />
                                <p>Loading...</p>
                            </div>
                        </div>
                        @yield('content')
                    </div>
                    <!--/ Content -->

                    <!-- Footer -->
                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl">
                            <div
                                class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                                <div>
                                    ©
                                    <script>
                                        document.write(new Date().getFullYear());

                                    </script>
                                    , made with ❤️ by <a href="#" target="_blank" class="fw-semibold"> JMTO
                                        Operasional</a>
                                </div>

                            </div>
                        </div>
                    </footer>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('') }}assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('') }}assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/node-waves/node-waves.js"></script>

    <script src="{{ asset('') }}assets/vendor/libs/hammer/hammer.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/i18n/i18n.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>


    <script src="{{ asset('') }}assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Main JS -->
    <script src="{{ asset('') }}assets/js/main.js"></script>
    <script src="{{ asset('') }}assets/js/extended-ui-sweetalert2.js"></script>
    <script src="{{ asset('') }}assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    @yield('js')
    @stack('scripts')
</body>

</html>
