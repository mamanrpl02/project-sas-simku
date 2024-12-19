@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-saldo">
            <div class="header">
                <h1>Total Saldo Kas</h1>
                <p>Total Saldo Kas keseluruhan Sebesar </p>
            </div>
            <div class="isi">
                <div class="isi"><i class="bi bi-credit-card-fill"></i> <strong>Rp : </strong> 300.000</div>
            </div>
        </div>
    </div>

    <div class="containerTransaksi mt-5">
        <h2 class="text-center mb-4">Catatan Pengeluaran Kas</h2>

        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">
                            <form method="GET" action="">
                                <select name="bulan" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="" {{ request('bulan') == '' ? 'selected' : '' }}>Tanggal</option>
                                    <option value="01" {{ request('bulan') == '01' ? 'selected' : '' }}>Januari</option>
                                    <option value="02" {{ request('bulan') == '02' ? 'selected' : '' }}>Februari
                                    </option>
                                    <option value="03" {{ request('bulan') == '03' ? 'selected' : '' }}>Maret</option>
                                    <option value="04" {{ request('bulan') == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ request('bulan') == '05' ? 'selected' : '' }}>Mei</option>
                                    <option value="06" {{ request('bulan') == '06' ? 'selected' : '' }}>Juni</option>
                                    <option value="07" {{ request('bulan') == '07' ? 'selected' : '' }}>Juli</option>
                                    <option value="08" {{ request('bulan') == '08' ? 'selected' : '' }}>Agustus
                                    </option>
                                    <option value="09" {{ request('bulan') == '09' ? 'selected' : '' }}>September
                                    </option>
                                    <option value="10" {{ request('bulan') == '10' ? 'selected' : '' }}>Oktober
                                    </option>
                                    <option value="11" {{ request('bulan') == '11' ? 'selected' : '' }}>November
                                    </option>
                                    <option value="12" {{ request('bulan') == '12' ? 'selected' : '' }}>Desember
                                    </option>
                                </select>
                            </form>
                        </th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse ($transaksi as $index => $data) --}}
                    <tr class="baris">
                        <td>1</td>
                        <td>12 Desember 20224</td>
                        <td>Rp 200.000</td>
                        <td>Sukses</td>
                    </tr>
                    {{-- @empty --}}
                    {{-- <tr>
                            <td colspan="4" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>
    </div>
@endsection
