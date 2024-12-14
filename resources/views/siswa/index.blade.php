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
            <div class="item">
                <div class="info">
                    <div class="judul">Iuran Untuk Hari Guru</div>
                    <div class="detail">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Accusantium iusto
                        porro
                        dolorem molestias a numquam, dolores deserunt, error itaque, corrupti laboriosam nemo nostrum
                        excepturi adipisci odio asperiores unde consequatur eos voluptates nihil aspernatur laborum
                        eaque.
                        Laborum dolorum molestias laboriosam, quas amet deserunt consequatur nam quis dolor soluta illo
                        voluptatem magni?</div>
                </div>
                <div class="tanggal">28 November 2024, 12:54:42</div>
            </div>
            <div class="item">
                <div class="info">
                    <div class="judul">Beli Kue Untuk Hari Guru</div>
                    <div class="detail">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quis, aperiam
                        dignissimos!
                        Corporis, inventore. Tempora, at pariatur. Fuga fugiat consectetur quas! Eum, iure tempora iusto
                        eius in suscipit optio ea praesentium. Quos, sed! Praesentium modi optio, dicta quae culpa
                        soluta
                        excepturi iusto a non veniam aspernatur delectus iure minima autem laborum!</div>
                </div>
                <div class="tanggal">25 November 2024, 14:51:10</div>
            </div>
        </div>
    </section>
@endsection
