@extends('siswa.layout.main')

@section('content')
    <div class="containerEditProfile">
        <h1>Ubah Password Akun</h1>

        <!-- Menampilkan pesan sukses atau error -->
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')


            <div class="form-groupEditProfile">
                <label for="password_lama">Password Lama</label>
                <input type="password" name="password_lama" id="password_lama" class="form-control"
                    placeholder="Masukkan password lama" required>
                @error('password_lama')
                    <div class="alert-info alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-groupEditProfile">
                <label for="password_baru">Password Baru</label>
                <input type="password" name="password_baru" id="password_baru" class="form-control"
                    placeholder="Masukkan password baru" required>
                @error('password_baru')
                    <div class="alert-info alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-groupEditProfile">
                <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                <input type="password" name="password_baru_confirmation" id="password_baru_confirmation"
                    class="form-control" placeholder="Konfirmasi password baru" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
@endsection
