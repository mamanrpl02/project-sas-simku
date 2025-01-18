<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>SIMKU - RPL B</title>



    <link rel="icon" href="{{ asset('img/logoUnesco.png') }}">
    <!-- My Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Bootsrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- My Style -->
    <link rel="stylesheet" href="{{ asset('siswaCss/style.css') }}">


</head>

<body>

    <!-- Ini Bagian Navbar -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">SIMKU</a>
        <div class="navbar-nav">
            <a href="{{ route('dashboard') }}">Beranda</a>
            <a href="{{ route('presensi') }}">Pesensi</a>
            <a href="{{ route('pengajuan') }}">Pengajuan Ketidakhadiran</a>
            <a href="{{ route('profile.edit') }}">Ubah Password</a>
            <a href="{{ route('transaksi') }}">Riwayat Saldo</a>
            <a href="{{ route('pengeluaran-kas') }}">Pengeluaran Kas</a>
            <a href="{{ route('pemasukan-kas') }}">Pemasukan Kas</a>
            <a href="{{ route('notif.kas') }}">Pemberitahuan</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>

            <form id="logout-form" action="{{ route('siswa.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <div class="navbar-exstra">
            {{-- <a href="#" id="search"><i data-feather="search"></i>
            </a> --}}
            <a href="#" id="hamburger-menu"><i data-feather="menu"></i>
            </a>
        </div>
    </nav>
    <!-- Ini Bagian Akhir Navbar -->

    @yield('content')

    <script>
        feather.replace();
    </script>
    <script src="{{ asset('siswaJs/script.js') }}"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.9/dist/sweetalert2.min.js"></script>

</body>

</html>
