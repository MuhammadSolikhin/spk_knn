<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ config('app.name', 'SPK KNN') }} - Landing Page</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container-fluid container-xxl">
            <a class="navbar-brand fw-bolder d-flex align-items-center gap-2" href="#">
                <i class='bx bxs-school fs-3 text-primary'></i> SPK KNN
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item me-2">
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-primary text-white py-5">
        <div class="container-xxl py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold mb-3 text-white">Temukan Minat & Bakatmu!</h1>
                    <p class="lead mb-4">
                        Aplikasi Sistem Pendukung Keputusan (SPK) menggunakan metode K-Nearest Neighbors (KNN) untuk
                        membantu siswa menentukan jurusan atau ekstrakurikuler yang sesuai dengan potensi mereka.
                    </p>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        @auth
                             <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg px-4 me-md-2 fw-bold text-primary">Lihat Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4 me-md-2 fw-bold text-primary">Daftar Sekarang</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Masuk</a>
                        @endauth
                    </div>
                </div>
                <div class="col-lg-6 text-center mt-5 mt-lg-0">
                    <i class='bx bx-analyse' style="font-size: 200px; color: rgba(255,255,255,0.8);"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5 bg-white">
        <div class="container-xxl py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Mengapa Menggunakan Aplikasi Ini?</h2>
                <p class="text-muted">Metode yang akurat dan mudah digunakan.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 text-center">
                    <div class="card h-100 shadow-none border">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class='bx bx-brain text-primary fs-1'></i>
                            </div>
                            <h5 class="card-title fw-bold">Metode KNN</h5>
                            <p class="card-text text-muted">Menggunakan algoritma K-Nearest Neighbors yang terbukti efektif dalam klasifikasi data berdasarkan kemiripan.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card h-100 shadow-none border">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class='bx bx-data text-primary fs-1'></i>
                            </div>
                            <h5 class="card-title fw-bold">Data Akurat</h5>
                            <p class="card-text text-muted">Hasil analisis didasarkan pada data historis dan kriteria yang relevan untuk hasil yang presisi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="card h-100 shadow-none border">
                        <div class="card-body">
                            <div class="mb-3">
                                <i class='bx bx-user-check text-primary fs-1'></i>
                            </div>
                            <h5 class="card-title fw-bold">Mudah Digunakan</h5>
                            <p class="card-text text-muted">Antarmuka yang ramah pengguna memudahkan siswa dan admin dalam mengelola data.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light py-4 mt-auto">
        <div class="container-xxl text-center">
            <div class="mb-2">
                <i class='bx bxs-school fs-4 text-primary'></i> <span class="fw-bold fs-5 align-middle">SPK KNN</span>
            </div>
            <p class="text-muted mb-0">
                &copy; {{ date('Y') }} SPK Minat Bakat Siswa. All rights reserved.
            </p>
        </div>
    </footer>

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
