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

    <div class="containerTransaksi mt-5">
        <h2 class="text-center mb-4">Riwayat Transaksi</h2>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $data)
                        <tr class="baris {{ $data['keterangan'] == 'Debit' ? 'text-success' : 'text-danger' }}">
                            <td>{{ $data['tanggal']->translatedFormat('l, d M Y') }}</td>
                            <td>Rp {{ number_format($data['nominal'], 0, ',', '.') }}</td>
                            <td>{{ $data['keterangan'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
