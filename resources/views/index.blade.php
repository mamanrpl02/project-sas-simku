<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>SIMKU - Sistem InforMasi Keuangan Unesco</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <!-- Favicons -->
    <link href="{{ asset('img/logoUnesco.png') }}" rel="icon" />
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
</head>

<body class="index-page">
    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="index.html" class="logo d-flex align-items-center me-auto" style="padding-right:2rem;">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">SIMKU</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li>
                        <a href="{{ route('landing') }}" class="active">Home<br /></a>
                    </li>
                    <li>
                        <a href="{{ route('landing') }}#about" class="active">Tentng Kami</a>
                    </li>
                    <li>
                        <a href="{{ route('landing') }}#kenapa-kami" class="active">Tentng Kami</a>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="btn-getstarted" href="/login">Login</a>
        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <img src="assets/img/hero-bg.jpg" alt="" data-aos="fade-in" />

            <div class="container">
                <h2 data-aos="fade-up" data-aos-delay="100">
                    Keuangan Rapi,<br />Masa Depan Pasti.
                </h2>
                <p data-aos="fade-up" data-aos-delay="200">
                    SIMKU dirancang untuk mengelola dan memantau keuangan di kelas
                    secara efisien.
                </p>
                <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                    <a href="#tentang-kami" class="btn-get-started">Tentang Kami</a>
                </div>
            </div>
        </section>
        <!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section" style="padding-top: 15rem;">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                        <img src="assets/img/about.png" class="img-fluid" alt="UNESCO" style="height: 500px" />
                    </div>

                    <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                        <h3>Sistem InforMasi Keuangan Unesco</h3>
                        <p class="">
                            SIMKU kependekan dari Sistem Informasi Manajemen Keuangan
                            Unesco, yang dimana UNESCO adalah singkatan dari kelas kami
                            yaitu
                            <span class="italic">UNitEd class Smart and COol</span>
                        </p>
                        <p>Kenapa SIMKU dibuat? <br /></p>
                        <ul>
                            <li>
                                <i class="bi bi-check-circle"></i>
                                <span>SIMKU ini adalah salah satu project SAS kami (Sumaif Akhir
                                    Semester)</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle"></i>
                                <span>Memudahkan pencatatan keuangan yang transparan untuk kelas
                                    kami.</span>
                            </li>
                            <li>
                                <i class="bi bi-check-circle"></i>
                                <span>Memberikan akses kepada siswa untuk melihat kondisi
                                    keuangan kapan saja dan di mana saja.</span>
                            </li>
                        </ul>
                        <a href="#kenapa-kami" class="read-more"><span>Read More</span><i
                                class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Us Section -->
        <section id="kenapa-kami" class="section why-us" class="padding-top:20rem;">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="why-box">
                            <h3>Kenapa SIMKU?</h3>
                            <p>
                                SIMKU, atau Sistem Informasi Manajemen Keuangan UNESCO, adalah
                                alat digital yang membantu mengatur keuangan dengan mudah dan
                                rapi. Dengan SIMKU, semua catatan pemasukan, pengeluaran, dan
                                anggaran bisa dilakukan secara otomatis. Karena berbasis
                                online, pengguna (Siswa) dapat melihat laporan keuangan kapan
                                saja dan di mana saja, sehingga lebih praktis dan cepat untuk
                                mengambil keputusan.
                            </p>
                            <div class="text-center">
                                <a href="#" class="more-btn"><span>Learn More</span> <i
                                        class="bi bi-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <!-- End Why Box -->

                    <div class="col-lg-8 d-flex align-items-stretch">
                        <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="col-xl-4">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-clipboard-data"></i>
                                    <h4>Pengelolaan Keuangan</h4>
                                    <p>
                                        Membantu dalam pencatatan, pelaporan, dan pengelolaan
                                        transaksi keuangan, seperti pemasukan, pengeluaran,
                                        tabungan, atau kas.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-cash-coin"></i>
                                    <h4>Automasi Proses Keuangan</h4>
                                    <p>
                                        Mengurangi pekerjaan manual dengan menyediakan fitur
                                        seperti laporan otomatis, perhitungan, dan pengelolaan
                                        anggaran.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->

                            <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                    <i class="bi bi-globe"></i>
                                    <h4>Akses Data Real-time</h4>
                                    <p>
                                        Memberikan akses kepada pengguna (Siswa) untuk melihat
                                        kondisi keuangan kapan saja dan di mana saja karena sistem
                                        ini berbasis online.
                                    </p>
                                </div>
                            </div>
                            <!-- End Icon Box -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Features Section -->
    </main>

    <footer id="footer" class="footer position-relative light-background">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">SIMKU</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>RPL - SMKN 1 Pusakanagara</p>
                        <p>Kec. Pusakanagara , Kab. Subang , Jawa Barat</p>
                        <!-- <p class="mt-3">
                <strong>Instagram </strong><a href="https://www.instagram.com/xii.unesco22/" target="_blank">@xii.unesco22</a>
              </p> -->
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-instagram"></i></a>
                    </div>
                </div>

                {{-- <div class="col-lg-2 col-md-3 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">About us</a></li>
              <li><a href="#">Services</a></li>
              <li><a href="#">Terms of service</a></li>
              <li><a href="#">Privacy policy</a></li>
            </ul>
          </div> --}}

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Kelasmu Mau Juga? Hubungi Kami</h4>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4" style="bottom: 0">
            <p>
                © <span>Copyright</span>
                <strong class="px-1 sitename">Mentor</strong>
                <span>All Rights Reserved</span>
            </p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by
                <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by
                <a href=“https://themewagon.com>ThemeWagon
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
