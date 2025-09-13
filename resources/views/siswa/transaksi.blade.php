@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-saldo">
            <div class="header">
                <h1>Halo {{ $siswa->nama }}</h1>
                <p>Saldo Tabungan Kamu sebesar </p>
            </div>
            <div class="isi">
                <div class="isi">
                    <i class="bi bi-credit-card-fill"></i>
                    <strong>Rp: </strong>
                    <span id="saldo" style="font-size: 1.4rem; letter-spacing: 3px; font-weight:600;">
                        {{ number_format($siswa->saldo, 0, ',', '.') }}
                    </span>
                    <button id="toggle-saldo" class="eyes" onclick="toggleSaldo()"
                        style="padding: 10px; border-radius:5px;background-color:#f4d03f;">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="containerTransaksi">
        <h2 class="text-center mb-4" style="color: black">Riwayat Transaksi Kamu</h2>

        <!-- Filter Bulan -->
        <form method="GET" action="{{ route('transaksi') }}">
            <div class="form-group">
                <label for="bulan">Pilih Bulan</label>
                    
            </div>
        </form>

        <table class="tabel-presensi">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi as $data)
                    @php
                        $tanggal = \Carbon\Carbon::parse($data['tanggal']);
                    @endphp
                    <tr class=" {{ $data['keterangan'] == 'Debit' ? 'text-success' : 'text-danger' }}">
                        <td>{{ $tanggal->translatedFormat('l, d F Y') }}</td>
                        <td>{{ number_format($data['nominal'], 0, ',', '.') }}</td>
                        <td>
                            @if ($data['keterangan'] == 'Debit')
                                <span class="text-success">Debit</span>
                            @else
                                <span class="text-danger">Kredit</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Tidak ada data transaksi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const saldoElement = document.getElementById('saldo');
        const toggleButton = document.getElementById('toggle-saldo');
        const eyeIcon = toggleButton.querySelector('i');

        // Ambil status dari localStorage
        const isHidden = localStorage.getItem('saldoHidden') === 'true';

        if (saldoElement.dataset.original === undefined) {
            saldoElement.dataset.original = saldoElement.textContent; // Simpan nilai asli
        }

        // Atur tampilan awal berdasarkan status dari localStorage
        if (isHidden) {
            hideSaldo(saldoElement, eyeIcon);
        } else {
            showSaldo(saldoElement, eyeIcon);
        }
    });

    function toggleSaldo() {
        const saldoElement = document.getElementById('saldo');
        const toggleButton = document.getElementById('toggle-saldo');
        const eyeIcon = toggleButton.querySelector('i');

        if (saldoElement.textContent.includes('*')) {
            // Tampilkan saldo asli
            showSaldo(saldoElement, eyeIcon);
            localStorage.setItem('saldoHidden', 'false'); // Simpan status di localStorage
        } else {
            // Sembunyikan saldo
            hideSaldo(saldoElement, eyeIcon);
            localStorage.setItem('saldoHidden', 'true'); // Simpan status di localStorage
        }
    }

    function hideSaldo(saldoElement, eyeIcon) {
        const originalSaldo = saldoElement.dataset.original.replace(/[^\d]/g, ''); // Ambil hanya angka
        saldoElement.textContent = '*'.repeat(originalSaldo.length); // Ganti saldo dengan '*'
        eyeIcon.className = 'bi bi-eye-slash'; // Ganti ikon menjadi mata tertutup
    }

    function showSaldo(saldoElement, eyeIcon) {
        saldoElement.textContent = saldoElement.dataset.original; // Tampilkan saldo asli
        eyeIcon.className = 'bi bi-eye'; // Ganti ikon menjadi mata terbuka
    }
</script>
