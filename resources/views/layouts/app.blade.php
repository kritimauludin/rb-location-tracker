<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Radar Bogor') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets') }}/img/favicon.webp" rel="icon">
    <link href="{{ asset('assets') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="{{ asset('assets') }}/vendor/datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    @if (Auth::check())
        <link href="{{ asset('assets') }}/css/style.css" rel="stylesheet">
    @else
        <link href="{{ asset('assets') }}/css/landing-page.css" rel="stylesheet">
    @endif

    <!-- leaflet CSS -->
    <link href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" rel="stylesheet"
        integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin="" />

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
        crossorigin="anonymous"></script>

</head>

<body>
    @if (Auth::check() && Auth::user()->email_verified_at != null)
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="d-flex align-items-center justify-content-between">
                <a href="/home" class="logo d-flex align-items-center">
                    <img src="{{ asset('assets') }}/img/logo.png" alt="">
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div><!-- End Logo -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">

                    <li class="nav-item d-block d-lg-none">
                        <a class="nav-link nav-icon search-bar-toggle " href="#">
                            <i class="bi bi-search"></i>
                        </a>
                    </li><!-- End Search Icon-->

                    <li class="nav-item dropdown p-2">

                        <div class="spinner-grow text-success text-sm" style="width: 10px; height: 10px;"
                            role="status">
                            <span class="visually-hidden">Not Problem Detected...</span>
                        </div>

                    </li><!-- End spinner grow Nav -->

                    <li class="nav-item dropdown pe-3">

                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                            data-bs-toggle="dropdown">
                            @if (is_null(auth()->user()->img_profile))
                                <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            @else
                                <img src="{{ asset('storage/' .  auth()->user()->img_profile) }}" alt="Profile" class="rounded-circle">
                            @endif
                            <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>{{ Auth::user()->name }}</h6>
                                <span>{{ Auth::user()->role->role_name }}</span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="/my-profile">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" target="_blank" href="https://drive.google.com/drive/folders/1eqD2rklpphsryWbihzyhtKnAuk_LCNlp?usp=sharing">
                                    <i class="bi bi-question-circle"></i>
                                    <span>Need Help?</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span> {{ __('Logout') }}</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->

                </ul>
            </nav><!-- End Icons Navigation -->

        </header><!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link @if (Route::has('home')) active @endif"
                            href="{{ route('home') }}">
                            <i class="bi bi-grid"></i>
                            <span>Dashboard</span>
                        </a>
                    </li><!-- End Dashboard Nav -->

                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse"
                            href="#">
                            <i class="bi bi-menu-button-wide"></i><span>Pengguna App</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="/user">
                                    @if (Auth::user()->role_id == 1)
                                        <i class="bi bi-circle"></i><span>Lihat Pengguna</span>
                                    @else
                                        <i class="bi bi-circle"></i><span>Lihat Kurir</span>
                                    @endif
                                </a>
                            </li>
                            {{-- <li>
                            <a href="users-accordion.html">
                                <i class="bi bi-circle"></i><span>Tambah Pengguna</span>
                            </a>
                        </li> --}}
                        </ul>
                    </li><!-- End users Nav -->
                @endif

                @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#newspapers-nav" data-bs-toggle="collapse"
                            href="{{ route('newspaper.index') }}">
                            <i class="bi bi-newspaper"></i><span>Data Koran</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="newspapers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{ route('newspaper.index') }}">
                                    <i class="bi bi-circle"></i><span>Lihat Koran</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('newspaper.create') }}">
                                    <i class="bi bi-circle"></i><span>Tambah Koran</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End newspapers Nav -->

                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#customers-nav" data-bs-toggle="collapse"
                            href="{{ route('customer.index') }}">
                            <i class="bi bi-person-square"></i><span>Data Pelanggan</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="customers-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{ route('customer.index') }}">
                                    <i class="bi bi-circle"></i><span>Lihat Pelanggan</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('customer.create') }}">
                                    <i class="bi bi-circle"></i><span>Tambah Pelanggan</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End customers Nav -->

                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#distributions-nav" data-bs-toggle="collapse"
                            href="{{ route('distribution.index') }}">
                            <i class="bi bi-calendar-plus"></i><span>Data Distribusi</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="distributions-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{ route('distribution.index') }}">
                                    <i class="bi bi-circle"></i><span>Lihat Distribusi</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('distribution.create') }}">
                                    <i class="bi bi-circle"></i><span>Tambah Distribusi</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End distribution Nav -->
                @endif


                {{-- courier role --}}
                @if (Auth::user()->role_id == 3)
                    <li class="nav-item">
                        <a class="nav-link collapsed" data-bs-target="#distributions-today-nav"
                            data-bs-toggle="collapse" href="{{ route('distribution.index') }}">
                            <i class="bi bi-cursor"></i><span>Data Distribusi</span><i
                                class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="distributions-today-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                            <li>
                                <a href="{{ route('distribution.today') }}">
                                    <i class="bi bi-circle"></i><span>Lihat Distribusi Hari Ini</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('distribution.report') }}">
                                    <i class="bi bi-circle"></i><span>Rekap Distribusi Saya</span>
                                </a>
                            </li>
                        </ul>
                    </li><!-- End distribution for courier Nav -->
                @endif

                <li class="nav-heading">Pages</li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="/my-profile">
                        <i class="bi bi-person"></i>
                        <span>Profile</span>
                    </a>
                </li><!-- End Profile Page Nav -->

            </ul>

        </aside><!-- End Sidebar-->

        <main id="main" class="main">
            <div class="container">

                @yield('content')

            </div>
        </main><!-- End #main -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
    @else
        @yield('content')
    @endif


    <!-- Vendor JS Files -->
    <script src="{{ asset('assets') }}/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/chart.js/chart.umd.js"></script>
    <script src="{{ asset('assets') }}/vendor/echarts/echarts.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/quill/quill.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/datatables/datatables.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/tinymce/tinymce.min.js"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets') }}/js/main.js"></script>

</body>

</html>
