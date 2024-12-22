@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-saldo">
            <div class="header">
                <h1>Total Saldo Kas</h1>
                <p>Total Saldo Kas keseluruhan Sebesar </p>
            </div>
            <div class="isi">
                <div class="isi"><i class="bi bi-credit-card-fill"></i> <strong>Rp .
                    </strong>{{ number_format($totalSaldo, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <div class="containerTransaksi mt-5">
        <div class="text-center count warning mb-4">
            <h2>Jumlah Pengeluaran Kas Sebesar <br><span> Rp.
                    {{ number_format($pengeluaranKas, 0, ',', '.') }}
                </span></h2><br>
            <a href="{{ route('pemasukan-kas') }}">Lihat Pemasukan >> </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">
                            Tanggal
                        </th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengeluaran as $data)
                        <tr class="baris">
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('l, d M Y') ?? '-' }}</td>
                            <td class="text-warning"><b>{{ number_format($data->nominal, 0, ',', '.') }}</b></td>
                            <td class="text-left">{{ $data->keterangan }}</td>
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
