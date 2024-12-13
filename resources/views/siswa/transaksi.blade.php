@extends('siswa.layout.main')

@section('content')
    <div class="containerTransaksi mt-5">
        <h2 class="text-center mb-4">Riwayat Transaksi</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($transaksi as $index => $data) --}}
                        <tr class="baris">
                            <td>1</td>
                            <td>12 Desember 2024</td>
                            <td>Rp 200.000</td>
                            <td>Berhasil</td>
                        </tr>
                        <tr class="baris">
                            <td>1</td>
                            <td>12 Desember 2024</td>
                            <td>Rp 200.000</td>
                            <td>Berhasil</td>
                        </tr>
                        <tr class="baris">
                            <td>1</td>
                            <td>12 Desember 2024</td>
                            <td>Rp 200.000</td>
                            <td>Berhasil</td>
                        </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection

