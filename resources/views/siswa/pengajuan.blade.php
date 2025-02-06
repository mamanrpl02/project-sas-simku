@extends('siswa.layout.main')

@section('content')
    <div class="form-pengajuan">
        <h2>Ajukan Izin</h2>

        <form id="form-izin" action="{{ route('siswa.izin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="jenis_izin">Jenis Izin</label>
                <div>
                    <input type="radio" id="sakit" name="jenis" value="S" required>
                    <label for="sakit">Sakit</label><br>

                    <input type="radio" id="izin" name="jenis" value="I" required>
                    <label for="izin">Izin</label><br>
                </div>
            </div>

            <div class="form-group">
                <label for="alasan">Alasan Ketidakhadiran</label>
                <textarea id="alasan" name="alasan" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="bukti">Bukti Ketidakhadiran</label>
                <input type="file" id="bukti" name="bukti" required accept="image/*, .pdf">
            </div>

            <button class="submit-pengajuan" type="submit" class="btn btn-primary">Ajukan Izin</button>
        </form>

    </div>

    <!-- Tambahkan SweetAlert -->
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Oke'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            });
        </script>
    @endif

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
                return false; // Hentikan pengajuan jika hari Sabtu atau Minggu
            }
            return true;
        }

        // Menangani submit form
        document.getElementById('form-izin').addEventListener('submit', function(event) {
            // Jika hari ini adalah Sabtu atau Minggu, hentikan submit
            if (!cekHariIni()) {
                event.preventDefault(); // Hentikan form submit
            }
        });
    </script>



<form action="/send-group" method="POST">
    @csrf
    {{-- <input type="text" name="group_id" placeholder="Masukkan ID Grup"> --}}
    <textarea name="message" placeholder="Pesan ke grup"></textarea>
    <button type="submit">Kirim</button>
</form>

@endsection
