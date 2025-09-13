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
        <!-- Filter Bulan & Tahun -->
        <form method="GET" action="{{ route('transaksi') }}" class="mb-4 flex items-center">
            <select name="bulan" id="bulan" class="border rounded p-2 ">
                <option value="0" {{ $bulan == 0 ? 'selected' : '' }}>Semua</option>
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>

            <select name="tahun" id="tahun" class="border rounded p-2">
                @php
                    $tahunSekarang = date('Y');
                @endphp
                @for ($y = $tahunSekarang; $y <= $tahunSekarang + 3; $y++)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <button type="submit"
                style="padding: 4px 10px; background-color: #6793f3; color: white; border-radius: 6px; border: none; cursor: pointer; transition:0.2s ease-in"
                onmouseover="this.style.backgroundColor='#2966e7'" onmouseout="this.style.backgroundColor='#6793f3'">
                Filter
            </button>

        </form>

        <table class="tabel-presensi" style="margin-top: 0.4rem">
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
                    <tr class="{{ $data['keterangan'] == 'Debit' ? 'text-success' : 'text-danger' }}">
                        <td>{{ $tanggal->translatedFormat('l, d F Y') }}</td>
                        <td>{{ number_format(abs($data['nominal']), 0, ',', '.') }}</td>
                        <td>{{ $data['keterangan'] }}</td>
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
