@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-saldo">
            <div class="header">
                <h1>Halo {{ $siswa->nama }}</h1>
                <p>Saldo Tabungan Kamu sebesar </p>
            </div>
            <div class="isi">
                <div class="isi"><i class="bi bi-credit-card-fill"></i> <strong>Rp : </strong>
                    {{ number_format($siswa->saldo, 0, ',', '.') }}</div>
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
