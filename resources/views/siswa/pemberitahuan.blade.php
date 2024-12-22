@extends('siswa.layout.main')

@section('content')
    <div class="boxAlert">
        <h1>Haloo {{ $siswa->nama }}</h1>

        @if ($tagihanBelumDibayar->isNotEmpty())
            @foreach ($tagihanBelumDibayar as $tagihan)
                <p>Tagihan Kass setiap hari Senin Dan Kamis. Pastikan kamu membayar kass selalu yaa</p>
                <div class="alert">
                    <span class="closebtn">
                        <i class="bi bi-exclamation-circle"></i>
                    </span>
                    <strong>Pemberitahuan! :</strong><br>
                    Kamu belum membayar kas pada tanggal
                    <b>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d F Y') }}.</b> Harap segera membayar kas
                    secepatnya yaa terimakasih.
                </div>
            @endforeach
        @else
            <p>Terimakasih {{ $siswa->nama }} sudah rajin membayar kas, kamu tidak ada tunggakan kas</p>
        @endif


    </div>
@endsection
