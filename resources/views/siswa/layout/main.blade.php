<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Navbar Responsisve</title>

    <!-- My Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">


    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="siswaCss/style.css">


</head>

<body>

    <!-- Ini Bagian Navbar -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">SIMKU</a>
        <div class="navbar-nav">
            <a href="#">Beranda</a>
            <a href="#">Tentang Saya</a>
            <a href="#">Melayani</a>
            <a href="#">Berita Terkini</a>
            <a href="#">Contct</a>
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


    <!-- Feather Icons -->
    <script>
        feather.replace();
    </script>
    <script src="siswaJs/script.js"></script>
</body>

</html>
