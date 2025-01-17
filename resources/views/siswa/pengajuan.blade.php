@extends('siswa.layout.main')

@section('content')
    <div class="form-pengajuan">
        <h2>Ajukan Izin</h2>
        <form action="" method="POST">
            @csrf
            <div class="form-group">
                <label for="jeenis-izin">Jenis Izin</label>
                <input type="radio" id="html" name="bahasa" value="HTML">
                <label for="html">HTML</label><br>
                <input type="radio" id="css" name="bahasa" value="CSS">
                <label for="css">CSS</label><br>
                <input type="radio" id="js" name="bahasa" value="JS">
                <label for="js">Javascript</label><br>
            </div>
        </form>
    </div>
@endsection
