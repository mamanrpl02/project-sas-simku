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

            <!-- Custom Upload File -->
            <div class="form-group">
                <label for="bukti">Bukti Ketidakhadiran</label>
                <div class="upload-container">
                    <input type="file" id="bukti" name="bukti" required accept="image/*, .pdf" hidden>
                    <label for="bukti" class="upload-label">
                        <span id="upload-text">Pilih File</span>
                    </label>
                    <div class="progress-bar">
                        <div class="progress"></div>
                    </div>
                    <img id="preview-image" src="#" alt="Preview" style="display: none;">
                </div>
            </div>

            <button class="submit-pengajuan" type="submit">Ajukan Izin</button>
        </form>

    </div>

    <!-- SweetAlert -->
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
        document.getElementById('bukti').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const uploadText = document.getElementById('upload-text');
            const previewImage = document.getElementById('preview-image');
            const progressBar = document.querySelector('.progress');

            if (file) {
                uploadText.textContent = file.name;

                // Jika file gambar, tampilkan preview
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.style.display = 'none';
                }

                // Animasi progress bar
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.width = '100%';
                }, 300);
            }
        });
    </script> 
@endsection
