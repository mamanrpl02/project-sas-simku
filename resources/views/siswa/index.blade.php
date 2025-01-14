@extends('siswa.layout.main')

@section('content')
    <div class="container">
        {{-- <div class="alert-dashboard">
            <a href="{{ route('notif.kas') }}"> <span class="closebtn"
                    onclick="this.parentElement.style.display='none';">&times;</span></a>
            <strong>Pemberitahuan! :</strong><br>Kamu belum membayar kas pada tanggal 12 Dessember 2024. Harap membayar
            kass yaa
        </div> --}}
        @foreach ($tagihanBelumDibayar as $tagihan)
            <div class="alert-dashboard">
                <a href="{{ route('notif.kas') }}"> <span class="closebtn"
                        onclick="this.parentElement.style.display='none';">&times;</span></a>
                <strong>Pemberitahuan! :</strong><br>
                Kamu belum membayar kas pada tanggal {{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}.
                Harap membayar kas yaa
            </div>
        @endforeach

        <div class="card-saldo">
            <div class="header">
                <h1>Halo {{ $siswa->nama }}</h1>
                <p>Saldo Tabungan Kamu sebesar</p>
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

                <a href="{{ route('transaksi') }}">
                    <div class="isi riwayat"><i class="bi bi-arrow-counterclockwise" style="font-size: 16px"></i> Riwayat
                    </div>
                </a>
            </div>
        </div>
    </div>

    <section class="informasi">
        <div class="header">
            <div class="judul">Informasi Pencatatan Keuangan Kas</div>
            <div class="judul button"><a href="{{ route('pengeluaran-kas') }}">Lihat Selengkapnya >>></a></div>
        </div>
        <div class="content">
            @foreach ($pengeluaran as $data)
                <div class="item">
                    <div class="info">
                        <div class="judul">{{ $data->judul }}</div>
                        <div class="detail">{{ $data->keterangan }}</div>
                    </div>
                    <div class="tanggal">
                        <b>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('D, d M Y') ?? '-' }}</b>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
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
            hideSaldo(saldoElement, eyeIcon, false);
        } else {
            showSaldo(saldoElement, eyeIcon, false);
        }
    });

    function toggleSaldo() {
        const saldoElement = document.getElementById('saldo');
        const toggleButton = document.getElementById('toggle-saldo');
        const eyeIcon = toggleButton.querySelector('i');

        if (saldoElement.textContent.includes('*')) {
            // Tampilkan saldo asli
            showSaldo(saldoElement, eyeIcon, true);
            localStorage.setItem('saldoHidden', 'false'); // Simpan status di localStorage
        } else {
            // Sembunyikan saldo
            hideSaldo(saldoElement, eyeIcon, true);
            localStorage.setItem('saldoHidden', 'true'); // Simpan status di localStorage
        }
    }

    function hideSaldo(saldoElement, eyeIcon, animate = true) {
        const originalSaldo = saldoElement.dataset.original.replace(/[^\d]/g, ''); // Ambil hanya angka

        if (animate) {
            saldoElement.classList.add('hidden'); // Tambahkan kelas hidden untuk animasi
            setTimeout(() => {
                saldoElement.textContent = '*'.repeat(originalSaldo.length); // Ganti saldo dengan '*'
                saldoElement.classList.remove('hidden'); // Reset animasi setelah selesai
            }, 600); // Waktu animasi sesuai CSS
        } else {
            saldoElement.textContent = '*'.repeat(originalSaldo.length);
        }

        eyeIcon.className = 'bi bi-eye-slash'; // Ganti ikon menjadi mata tertutup
    }

    function showSaldo(saldoElement, eyeIcon, animate = true) {
        if (animate) {
            saldoElement.classList.add('hidden'); // Tambahkan kelas hidden untuk animasi
            setTimeout(() => {
                saldoElement.textContent = saldoElement.dataset.original; // Tampilkan saldo asli
                saldoElement.classList.remove('hidden'); // Reset animasi setelah selesai
            }, 600); // Waktu animasi sesuai CSS
        } else {
            saldoElement.textContent = saldoElement.dataset.original;
        }

        eyeIcon.className = 'bi bi-eye'; // Ganti ikon menjadi mata terbuka
    }
</script>
