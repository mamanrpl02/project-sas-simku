<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Disetujui</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
            font-size: 24px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            color: #555;
        }

        .highlight {
            color: #2196F3;
            font-weight: bold;
        }

        .footer {
            font-size: 14px;
            color: #888;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Halo, {{ $namaSiswa }}</h1>
        <p>Presensi Anda pada tanggal {{ $presensi['date'] }} telah disetujui. Kami ingin mengonfirmasi bahwa Anda telah
            resmi tercatat sesuai dengan jenis presensi yang kamu ajukan hari ini.</p>

        @if ($presensi['jenis'] === 'I')
            <p>Jenis Presensi: <span class="highlight">Izin</span></p>
        @elseif($presensi['jenis'] === 'S')
            <p>Jenis Presensi: <span class="highlight">Sakit</span></p>
        @elseif($presensi['jenis'] === 'H')
            <p>Jenis Presensi: <span class="highlight">Hadir</span></p>
        @else
            <p>Jenis Presensi: <span class="highlight">{{ $presensi['jenis'] }}</span></p>
        @endif

        <!-- Tampilkan gambar jika ada bukti -->
        @if ($bukti)
            <p>Berikut adalah bukti yang telah Anda lampirkan:</p>
            <p><a href="{{ asset('storage/' . $bukti) }}" target="_blank" rel="noopener noreferrer">Lihat Bukti Anda</a>
            </p>
        @else
        @endif

        <p>Terima kasih telah mengajukan presensi. Kami berharap Anda selalu sehat dan terus semangat dalam menjalani
            kegiatan belajar!</p>

        <p>Lihat Presensi kamu di : <a href="{{ route('presensi') }}">{{ env('APP_URL') }}presensi</a></p>

        <div class="footer">
            <p>Jika ada pertanyaan, jangan ragu untuk menghubungi kami.</p>
        </div>
    </div>

</body>

</html>
