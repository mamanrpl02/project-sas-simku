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
                        @forelse ($presensiList as $presensi)
                            @php
                                $date = \Carbon\Carbon::parse($presensi->date);
                                $timeIn = $presensi->time_in ? \Carbon\Carbon::parse($presensi->time_in) : null;
                                $timeOut = $presensi->time_out ? \Carbon\Carbon::parse($presensi->time_out) : null;
                            @endphp

                            @if ($presensi->is_approved || (($presensi->jenis === 'I' || $presensi->jenis === 'S') && $presensi->is_approved))
                                <tr>
                                    <!-- Tanggal -->
                                    <td>{{ $date->format('d F Y') }}</td>

                                    <!-- Hari -->
                                    <td>{{ $date->translatedFormat('l') }}</td>

                                    <!-- Status Presensi -->
                                    <td>
                                        @if ($presensi->jenis === 'I' || $presensi->jenis === 'S')
                                            <!-- Izin atau Sakit -->
                                            <span
                                                class="text-warning">{{ ucfirst($presensi->jenis == 'I' ? 'Izin' : 'Sakit') }}</span>
                                        @elseif ($timeIn)
                                            <!-- Hadir -->
                                            <span
                                                class="{{ $timeIn->greaterThan(\Carbon\Carbon::parse('07:00:00')) ? 'text-danger' : 'text-success' }}">
                                                Hadir Jam {{ $presensi->time_in }}
                                            </span>
                                        @else
                                            <!-- Alpha -->
                                            <span class="text-danger">Alpha</span>
                                        @endif
                                    </td>

                                    <!-- Keterangan -->
                                    <td>
                                        @if ($presensi->jenis === 'I' || $presensi->jenis === 'S')
                                            <!-- Keterangan Izin atau Sakit -->
                                            <span class="text-warning">{{ $presensi->alasan }}</span>
                                        @elseif ($timeIn && $timeOut)
                                            <!-- Keterangan Pulang -->
                                            <span
                                                class="{{ $timeOut->greaterThanOrEqualTo(\Carbon\Carbon::parse('16:00:00')) ? 'text-success' : 'text-danger' }}">
                                                Pulang jam {{ $presensi->time_out }}
                                            </span>
                                        @elseif($timeIn)
                                            <!-- Jika belum pulang -->
                                            <span class="text-warning">Belum Pulang</span>
                                        @else
                                            <!-- Belum presensi -->
                                            <span class="text-danger">Belum presensi</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <!-- Jika tidak ada data presensi -->
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data presensi untuk bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination justify-content-center">
                    {{-- {{ $presensiList->links() }} --}}
                </div>
            </div>
        </div>
        <img src="{{ asset('storage/bukti' . $presensi->bukti) }}" alt="Bukti Presensi">

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
