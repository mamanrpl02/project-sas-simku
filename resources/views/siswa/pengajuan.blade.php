@extends('siswa.layout.main')

@section('content')
    <div class="form-pengajuan">
        <h2>Ajukan Izin</h2>

        <form action="{{ route('siswa.izin.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="bukti">Bukti Ketidakhadiran (Opsional)</label>
                <input type="file" id="bukti" name="bukti" accept="image/*, .pdf">
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
@endsection
