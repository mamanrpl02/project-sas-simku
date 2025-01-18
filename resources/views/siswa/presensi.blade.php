@extends('siswa.layout.main')

@section('content')
    <div class="container">
        <div class="card-presensi">
            <div class="card-header">
                <h3>Tandai Kehadiranmu</h3>
            </div>
            <div class="card-date">
                <p>Hari Sabtu, 18 Januari 2025</p>
            </div>
            <div class="card-button">
                <button class="masuk">Masuk</button>
                <button class="keluar">Keluar</button>
            </div>
            <div class="card-deskripsi">
                <p>Absensi kamu setiap hari harus disetujui oleh seksi Absensi atau Walikelas, Jadi pastikan kamu harus masuk pada saat jam pelajaran yaaa, biar seksi Absensi tauu!!</p>
                <p><a href="#">Klik di sini</a> jika anda Mengajukan Ketidakhadiran</p>
            </div>
        </div>

        <div class="presensi">
            <div class="your-presensi">
                <h3>Presensi Kamu</h3>

                <!-- Filter Bulan -->
                <div class="filter-bulan">
                    <label for="bulan">Filter Bulan:</label>
                    <select id="bulan">
                        <option value="januari">Januari</option>
                        <option value="februari">Februari</option>
                        <option value="maret">Maret</option>
                        <!-- Tambahkan opsi bulan lainnya -->
                    </select>
                </div>

                <!-- Tabel Presensi -->
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
                        <!-- Data dummy -->
                        <tr>
                            <td>18 Januari 2025</td>
                            <td>Sabtu</td>
                            <td>Hadir</td>
                            <td>Masuk tepat waktu</td>
                        </tr>
                        <tr>
                            <td>17 Januari 2025</td>
                            <td>Jumat</td>
                            <td>Hadir</td>
                            <td>Masuk terlambat</td>
                        </tr>
                        <!-- Tambahkan data presensi lainnya -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
