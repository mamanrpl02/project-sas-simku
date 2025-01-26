<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Debit Tabungan</title>
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

        .button {
            display: inline-block;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            font-weight: bold;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Halo {{ $namaSiswa }},</h1>
        <p>Kami ingin memberitahukan bahwa tabungan Anda baru saja diperbarui.</p>

        <p>Tabungan Anda kini bertambah sebesar: <span class="highlight">Rp{{ number_format($nominal, 0, ',', '.') }}</span></p>

        <p>Terima kasih telah konsisten menabung. Tabungan ini akan membantu Anda mencapai tujuan keuangan di masa depan.</p>

        <p>Untuk melihat rincian tabungan Anda atau melakukan pengelolaan lebih lanjut, silakan klik link di bawah ini:</p>

        <p>Lihat Tabungan Saya di: <a href="{{ route('dashboard') }}">{{ env('APP_URL') }}dashboard</a></p>

        <div class="footer">
            <p>Semoga hari Anda menyenankan dan terus semangat menabung!</p>
        </div>
    </div>

</body>
</html>
