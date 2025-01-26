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

    <style>
        .card-presensi {
            padding: 2rem;
            border-radius: 5px;
            width: 90%;
            margin: auto;
            /* Memberikan jarak vertikal dan horizontal */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            color: #333;
            display: flex;
            flex-direction: column;
            /* Mengatur elemen dalam kolom */
            align-items: flex-start;
            /* Elemen lainnya rata kiri */
        }

        .card-header {
            /* padding-bottom: 1rem; */
            color: #333;
            text-align: left;
            /* Judul tetap rata kiri */
        }

        .card-date {
            padding-top: 1rem;
            border-top: 1px solid #3333338c;
            margin: 0.5rem 0;
            /* Jarak vertikal antar elemen */
            display: block;
        }

        .container .card-presensi .card-button {
            padding-top: 2rem;
            display: flex;
            justify-content: space-evenly;
            /* Memusatkan tombol secara horizontal */
            align-items: center;
            /* Memusatkan tombol secara vertikal */
            width: 100%;
            /* Membuat tombol mengikuti lebar penuh parent */
            margin-bottom: 2rem;
            /* Jarak vertikal antar elemen */
            /* border-top: 1px solid #3333338c; */
        }

        .container .card-presensi .card-button form {
            display: flex;
            /* Atur <form> sebagai flex container */
            justify-content: space-evenly;
            /* Terapkan jarak yang merata */
            align-items: center;
            /* Pastikan elemen berada di tengah secara vertikal */
            width: 100%;
            /* Sesuaikan lebar <form> */
        }

        .container .card-presensi .card-button form button {
            background-color: #007bff;
            color: #fff;
            /* Warna teks tombol */
            padding: 1rem 2rem;
            /* Padding tombol */
            border-radius: 5px;
            border: none;
            /* Menghilangkan border */
            cursor: pointer;
            /* Menampilkan pointer saat hover */
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: 500;
        }

        .container .card-presensi .card-button form .masuk {
            background-color: #007bff;
        }

        .container .card-presensi .card-button form .keluar {
            background-color: #ff0000;
        }

        .container .card-presensi .card-button button:hover {
            background-color: #0056b3;
            /* Warna saat hover */
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }

        .container .card-presensi .card-button .masuk:hover {
            background-color: #0056b3;
            /* Warna saat hover */
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }

        .container .card-presensi .card-button .keluar:hover {
            background-color: #c00000;
            /* Warna saat hover */
            transform: scale(1.05);
            /* Efek zoom saat hover */
        }

        .card-deskripsi {
            margin-top: 1rem;
            color: #333;
            text-align: left;
            /* Deskripsi tetap rata kiri */
            line-height: 1.5;
            font-size: 0.9rem;
        }

        /* Ketidakhadiran */
        .form-pengajuan {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            margin: 9rem auto;
        }

        /* Judul halaman */
        .form-pengajuan h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 26px;
            color: #3b3b3b;
        }

        /* Style untuk form-group */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label untuk input dan textarea */
        .form-group label {
            font-weight: bold;
            margin-bottom: 10px;
            display: inline-block;
            color: #3b3b3b;
        }

        /* Input, textarea, dan radio button */
        input[type="text"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        /* Styling untuk textarea */
        textarea {
            resize: vertical;
        }

        /* Radio buttons */
        input[type="radio"] {
            margin-right: 10px;
        }

        /* Button Kirim */
        .submit-pengajuan {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        /* Button hover */
        .submit-pengajuan:hover {
            background-color: #45a049;
        }

        /* Pesan error */
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: none;
        }

        .presensi {
            width: 90%;
            margin: 3rem auto;
            padding: 20px;
            background-color: #f9f9f9;
            color: #292929;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.475);
        }

        .presensi h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .filter-bulan {
            margin-bottom: 20px;
        }

        .filter-bulan label {
            margin-right: 10px;
            font-weight: bold;
            color: #555;
        }

        .filter-bulan select {
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            background-color: #fff;
        }

        .tabel-presensi th,
        .tabel-presensi td {
            text-align: left;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .tabel-presensi th {
            background-color: #f2f2f2;
            color: #333;
        }

        .tabel-presensi tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .tabel-presensi tr:hover {
            background-color: #f1f1f1;
        }
    </style>

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

</body>

</html>
