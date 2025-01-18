@extends('siswa.layout.main')

@section('content')
    <div class="form-pengajuan">
        <h2>Ajukan Izin</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="jenis_izin">Jenis Izin</label>
                <div>
                    <input type="radio" id="sakit" name="jenis_izin" value="Sakit" required>
                    <label for="sakit">Sakit</label><br>

                    <input type="radio" id="izin" name="jenis_izin" value="Izin" required>
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
@endsection
