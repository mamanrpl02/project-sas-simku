@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-presensi">
            <div class="card-header">
                <h3>Tandai Kehadiranmu</h3>
            </div>
            <div class="card-date">
                <p>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
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
                <p><strong><a href="{{ route('pengajuan') }}">Klik di sini</a></strong> jika anda ingin mengajukan
                    ketidakhadiran ( Sakit, Izin , dll )</p>
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

                <table class="tabel-presensi">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Hari</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($presensiList->groupBy('date') as $presensiGroup)
                            <!-- Ambil tanggal dari grup -->
                            @php
                                $hasNonH = false;
                                $presensiHadir = null;
                            @endphp

                            @foreach ($presensiGroup as $presensi)
                                @if ($presensi->jenis !== 'H' && $presensi->is_approved)
                                    <!-- Jika ada izin selain H yang di-approve -->
                                    @php
                                        $hasNonH = true;
                                    @endphp
                                @elseif ($presensi->jenis === 'H' && $presensi->is_approved)
                                    <!-- Simpan presensi Hadir untuk ditampilkan jika tidak ada izin selain H -->
                                    @php
                                        $presensiHadir = $presensi;
                                    @endphp
                                @endif
                            @endforeach

                            <!-- Tampilkan presensi jika ada izin selain H atau jika tidak ada izin tampilkan presensi H -->
                            @if ($hasNonH)
                                @foreach ($presensiGroup as $presensi)
                                    @if ($presensi->jenis !== 'H' && $presensi->is_approved)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($presensi->date)->format('d F Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($presensi->date)->translatedFormat('l') }}</td>
                                            <td>
                                                <!-- Ubah tampilan S, I, A menjadi teks deskriptif -->
                                                @if ($presensi->jenis == 'S')
                                                    <span class="text-warning">Sakit</span>
                                                @elseif ($presensi->jenis == 'I')
                                                    <span class="text-warning">Izin</span>
                                                @elseif ($presensi->jenis == 'A')
                                                    <span class="text-warning">Alfa</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span
                                                    class="text-warning">{{ $presensi->alasan ?? 'Tidak ada alasan' }}</span>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @elseif ($presensiHadir)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($presensiHadir->date)->format('d F Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($presensiHadir->date)->translatedFormat('l') }}</td>
                                    <td>
                                        <span
                                            class="{{ \Carbon\Carbon::parse($presensiHadir->time_in)->greaterThan(\Carbon\Carbon::parse('07:00:00')) ? 'text-danger' : 'text-success' }}">
                                            Hadir Jam {{ $presensiHadir->time_in }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($presensiHadir->time_out)
                                            @if (\Carbon\Carbon::parse($presensiHadir->time_out)->greaterThanOrEqualTo(\Carbon\Carbon::parse('16:00:00')))
                                                <span class="text-success">Pulang jam {{ $presensiHadir->time_out }}</span>
                                            @else
                                                <span class="text-danger">Pulang jam {{ $presensiHadir->time_out }}</span>
                                            @endif
                                        @else
                                            Belum Pulang
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
    // Fungsi untuk mendapatkan hari saat ini
    function cekHariIni() {
        const hariIni = new Date().getDay(); // 0 untuk Minggu, 6 untuk Sabtu
        if (hariIni === 0 || hariIni === 6) {
            Swal.fire({
                icon: 'error',
                title: 'Tidak Dapat Presensi',
                text: 'Presensi tidak diizinkan pada hari Sabtu dan Minggu.',
            });
            return false; // Hentikan presensi jika hari Sabtu atau Minggu
        }
        return true;
    }

    function presensiMasuk() {
        if (!cekHariIni()) {
            return; // Batalkan presensi jika hari Sabtu atau Minggu
        }

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
                        title: 'Presensi Datang Berhasil',
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
        if (!cekHariIni()) {
            return; // Batalkan presensi jika hari Sabtu atau Minggu
        }

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
                        title: 'Presensi Pulang Berhasil',
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
