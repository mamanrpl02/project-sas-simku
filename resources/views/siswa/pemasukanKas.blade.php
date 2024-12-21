@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-saldo">
            <div class="header">
                <h1>Total Saldo Kas</h1>
                <p>Total Saldo Kas keseluruhan Sebesar </p>
            </div>
            <div class="isi">
                <div class="isi"><i class="bi bi-credit-card-fill"></i> <strong>Rp :
                    </strong>{{ number_format($totalSaldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="containerTransaksi mt-5">

        <div class="text-center count-masuk mb-4"><h2>Jumlah Pemasukan Kas Sebesar <br><span> Rp.
                {{ number_format($pemasukan, 0, ',', '.') }}
            </span></h2><br>
            <a href="{{ route('pengeluaran-kas') }}">Lihat Pengeluaran >> </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Tanggal Tagihan</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pemasukanKas as $kas)
                        <tr>
                            <td class="border border-gray-300 px-4 py-2">{{ $kas->siswa->nama ?? 'Tidak Diketahui' }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ \Carbon\Carbon::parse($kas->tagihan->tanggal)->translatedFormat('l, d M Y') ?? '-' }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                {{ \Carbon\Carbon::parse($kas->created_at)->translatedFormat('l, d M Y') }}</td>
                            <td class="border border-gray-300 px-4 py-2">Rp {{ number_format($kas->nominal, 0, ',', '.') }}
                            </td>
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
