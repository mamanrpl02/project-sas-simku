@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-presensi">
            <div class="card-header">
                <h3>Tandai Kehadiranmu</h3>
            </div>
            <div class="card-date">
                <p></p> {{-- Tanggal saat ini --}}
            </div>
            <div class="card-button">
                <form class="form">
                    <button type="button" id="btnMasuk" class="masuk" onclick="presensiMasuk()">Datang</button>
                    <button type="button" id="btnKeluar" class="keluar" onclick="presensiKeluar()">Pulang</button>
                </form>
            </div>
            <div class="card-deskripsi">
                <p>Absensi kamu setiap hari harus disetujui oleh seksi Absensi atau Walikelas. Jadi, pastikan kamu masuk
                    pada saat jam pelajaran ya!</p>
                <p><a href="{{ route('pengajuan') }}">Klik di sini</a> jika anda Mengajukan Ketidakhadiran</p>
            </div>
        </div>

        <div class="presensi mt-5">
            <div class="your-presensi">
                <h3>Presensi Kamu</h3>

                <!-- Filter Bulan -->
                <form method="GET" action="{{ route('presensi') }}">
                    <div class="form-group">
                        <label for="bulan">Pilih Bulan</label>
                        <select name="bulan" id="bulan" class="form-control" onchange="this.form.submit()">
                            @foreach ($bulanList as $key => $bulan)
                                <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>
                                    {{ $bulan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <table class="table mt-4 tabel-presensi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presensiList as $presensi)
                            @if ($presensi->is_approved == 1)
                                <!-- Kondisi untuk memeriksa is_approved -->
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($presensi->date)->format('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($presensi->date)->translatedFormat('l') }}</td>
                                    <td>
                                        @if ($presensi->time_in)
                                            <!-- Status dengan warna hijau jika datang tepat waktu, merah jika terlambat -->
                                            <span
                                                class="{{ \Carbon\Carbon::parse($presensi->time_in)->greaterThan(\Carbon\Carbon::parse('07:00:00')) ? 'text-danger' : 'text-success' }}">
                                                @if (\Carbon\Carbon::parse($presensi->time_in)->greaterThan(\Carbon\Carbon::parse('07:00:00')))
                                                    Terlambat
                                                @else
                                                    Tepat Waktu
                                                @endif
                                            </span>
                                        @else
                                            Tidak Hadir
                                        @endif
                                    </td>
                                    <td>
                                        @if ($presensi->time_in && $presensi->time_out)
                                            <!-- Keterangan pulang setelah jam 16:00 -->
                                            @if (\Carbon\Carbon::parse($presensi->time_out)->greaterThanOrEqualTo(\Carbon\Carbon::parse('16:00:00')))
                                                Full
                                            @else
                                                <!-- Mengambil keterangan dari database (kolom keterangan_pulang) jika tidak pulang setelah jam 16:00 -->
                                                Kamu pulang jam {{ $presensi->time_out  }}
                                            @endif
                                        @elseif($presensi->time_in)
                                            <!-- Jika hanya time_in ada, keterangan tetap Datang Tepat Waktu atau Terlambat -->
                                            @if (\Carbon\Carbon::parse($presensi->time_in)->greaterThan(\Carbon\Carbon::parse('07:00:00')))
                                                Datang Terlambat
                                            @else
                                                Datang Tepat Waktu
                                            @endif
                                        @else
                                            Belum presensi
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @if ($presensiList->isEmpty())
                            <tr>
                                <td colspan="4">Tidak ada data presensi untuk bulan ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>



                <!-- Pagination -->
                <div class="pagination justify-content-center">
                    {{-- {{ $presensiList->links() }} --}}
                </div>
            </div>
        </div>

    </div>
@endsection

<script>
    function presensiMasuk() {
        fetch("{{ route('presensi.masuk') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    siswa_id: {{ auth()->id() }} // Kirim ID siswa yang sedang login
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Masuk',
                        text: data.success,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan!',
                });
            });
    }

    function presensiKeluar() {
        fetch("{{ route('presensi.keluar') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    siswa_id: {{ auth()->id() }} // Kirim ID siswa yang sedang login
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Presensi Keluar',
                        text: data.success,
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Terjadi kesalahan!',
                });
            });
    }
</script>
