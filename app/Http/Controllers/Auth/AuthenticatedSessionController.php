<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): RedirectResponse|View
    {
        // Cek apakah siswa sudah login
        if (Auth::guard('siswa')->check()) {
            // Redirect ke halaman dashboard
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Pastikan menggunakan guard 'siswa'
        $credentials = $request->only('email', 'password');

        // Menggunakan Auth::guard('siswa')->attempt() untuk login siswa
        if (Auth::guard('siswa')->attempt($credentials, $request->boolean('remember'))) {
            // Regenerasi session untuk menghindari session fixation
            $request->session()->regenerate();

            // Redirect ke halaman dashboard jika login berhasil
            return redirect()->route('dashboard'); // pastikan 'dashboard' adalah rute yang benar
        }

        // Jika gagal login, kembalikan error
        return back()->withErrors([
            'email' => 'Email atau password Anda salah.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // Logout guard 'siswa'
        Auth::guard('siswa')->logout();

        // Hapus session dan token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman utama setelah logout
        return redirect('/');
    }
}
