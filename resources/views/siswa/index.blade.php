@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="alert-dashboard">
            <a href="{{ route('notif.kas') }}"> <span class="closebtn"
                    onclick="this.parentElement.style.display='none';">&times;</span></a>
            <strong>Pemberitahuan! :</strong><br>Kamu belum membayar kas pada tanggal 12 Dessember 2024. Harap membayar
            kass yaa
        </div>
        <div class="card-saldo">
            <div class="header">
                <h1>Halo {{ $siswa->nama }}</h1>
                <p>Saldo Tabungan Kamu sebesar</p>
            </div>
            <div class="isi">
                <div class="isi"><i class="bi bi-credit-card-fill"></i> <strong>Rp : </strong>
                    {{ number_format($siswa->saldo, 0, ',', '.') }}</div>
                <a href="{{ route('transaksi') }}">
                    <div class="isi riwayat"><i class="bi bi-arrow-counterclockwise" style="font-size: 16px"></i> Riwayat
                        Saldo
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
                   <div class="tanggal"><b>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('D, d M Y') ?? '-' }}</b></div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
