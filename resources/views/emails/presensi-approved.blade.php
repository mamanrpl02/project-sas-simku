<!DOCTYPE html>
<html>

<head>
    <title>Presensi Disetujui</title>
</head>

<body>
    <h1>Halo, {{ $namaSiswa }}</h1>
    <p>Presensi Anda pada tanggal {{ $presensi['date'] }} telah disetujui.</p>

    @if ($presensi['jenis'] === 'I')
        <p>Jenis Presensi: Izin</p>
    @elseif($presensi['jenis'] === 'S')
        <p>Jenis Presensi: Sakit</p>
    @else
        <p>Jenis Presensi: {{ $presensi['jenis'] }}</p>
    @endif

    <!-- Tampilkan gambar jika ada bukti -->
    @if ($bukti)
        <p>Berikut adalah bukti yang telah Anda lampirkan:</p>
        <p><a href="{{ asset('storage/' . $bukti) }}" target="_blank" rel="noopener noreferrer">Bukti Sakit / Izin Anda</a></p>

    @endif
    <p>Terima kasih!</p>
</body>
</html>
