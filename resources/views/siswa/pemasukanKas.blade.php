@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-saldo">
            <div class="header">
                <h1>Total Saldo Kas</h1>
                <p>Total Saldo Kas keseluruhan Sebesar </p>
            </div>
            <div class="isi">
                <div class="isi"><i class="bi bi-credit-card-fill"></i> <strong>Rp
                        :</strong>{{ number_format($totalSaldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="containerTransaksi mt-5">

        <div class="text-center count-masuk mb-4">
            <h2>Jumlah Pemasukan Kas Sebesar <br><span> Rp.
                    {{ number_format($pemasukan, 0, ',', '.') }}
                </span></h2><br>
            <a href="{{ route('pengeluaran-kas') }}">Lihat Pengeluaran >> </a>
        </div>


        <!-- Filter Bulan -->
        <form method="GET" action="{{ route('pemasukan-kas') }}">
            <div class="form-group" style="margin-top: 1rem">
                <label for="bulan">Pilih Bulan</label>
                <select name="bulan" id="bulan" class="form-control" onchange="this.form.submit()">
                    <option value="all" {{ request('bulan') == 'all' ? 'selected' : '' }}>Semua</option>
                    @foreach ($bulanList as $key => $bulan)
                        <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                            {{ $bulan }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>


        <div class="table-responsive">
            <table class="tabel-presensi table table-striped table-bordered">
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
                        <tr class="baris">
                            <td class="text-left">{{ $kas->siswa->nama ?? 'Tidak Diketahui' }}</td>
                            <td>{{ \Carbon\Carbon::parse($kas->tagihan->tanggal)->translatedFormat('l, d M Y') ?? '-' }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($kas->created_at)->translatedFormat('l, d M Y') }}</td>
                            <td class="text-warning"><b>Rp {{ number_format($kas->nominal, 0, ',', '.') }}</b></td>
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
