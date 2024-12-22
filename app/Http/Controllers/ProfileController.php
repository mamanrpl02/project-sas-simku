<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Mengambil data siswa berdasarkan autentikasi
        return view('siswa.kelolaakun', [
            'siswa' => Auth::guard('siswa')->user(), // Pastikan guard sesuai jika menggunakan selain default
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $siswa = Auth::guard('siswa')->user();

        // Validasi input dengan pesan kustom
        $validatedData = $request->validate([
            'password_lama' => ['required_with:password_baru', 'current_password:siswa'], // Validasi password lama
            'password_baru' => ['nullable', 'string', 'min:8', 'confirmed'], // Password baru minimal 8 karakter dan harus dikonfirmasi
        ], [
            'password_lama.required_with' => 'Password lama harus diisi cuyy!!!.',
            'password_lama.current_password' => 'Password lama yang Anda masukkan salah cuyy!!!.',
            'password_baru.min' => 'Password baru harus terdiri dari minimal 8 karakter cuyy!!!',
            'password_baru.confirmed' => 'Konfirmasi password baru tidak sesuai cuyy!!!.',
        ]);

        // Jika validasi berhasil, lanjutkan
        try {
            // Jika password baru diisi, update password
            if ($request->filled('password_baru')) {
                // Password akan di-hash oleh model otomatis
                $siswa->password = $validatedData['password_baru'];
            }

            $siswa->save();

            return Redirect::route('profile.edit')->with('status', 'Yeayyy password anda berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan. Coba lagi.'])->withInput();
        }
    }




    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $siswa = Auth::guard('web')->user();

        Auth::logout();

        $siswa->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
