<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Presensi;
use Filament\Notifications\Notification; // Import Filament Notification

class FonnteController extends Controller
{
    public function sendAbsentStudentsToGroup()
    {
        // ID Grup WhatsApp
        $groupId = '120363397369324112@g.us';

        // Ambil tanggal hari ini dalam format yang lebih terbaca
        $tanggalHariIni = Carbon::now()->toDateString();
        $tanggalFormatIndo = Carbon::now()->translatedFormat('d F Y'); // Contoh: 07 Februari 2025

        // Ambil daftar siswa yang belum presensi hari ini
        $siswaBelumPresensi = Siswa::whereDoesntHave('presensis', function ($query) use ($tanggalHariIni) {
            $query->where('date', $tanggalHariIni)
                ->where('jenis', 'H')
                ->where('is_approved', true);
        })->pluck('nama');

        // Jika semua siswa sudah presensi
        if ($siswaBelumPresensi->isEmpty()) {
            $message = "✅ Semua siswa telah presensi hari ini!";
        } else {
            $message = "⚠️ *Daftar siswa yang belum presensi hari ini tanggal $tanggalFormatIndo :*\n";
            foreach ($siswaBelumPresensi as $index => $nama) {
                $message .= ($index + 1) . ". " . $nama . "\n";
            }
            $message .= "\nMohon segera melakukan presensi di website " . env('APP_URL') . "\nMohon kerja samanya agar seksi absensi dapat merekap dengan mudah" . "\nCara Mengajukan izin atau sakit https://youtube.com";
        }

        // Kirim pesan ke grup WhatsApp menggunakan Fonnte API
        $response = Http::withHeaders([
            'Authorization' => 'zb6NfMAHH9FkwHvyQeh5', // Ganti dengan API Key Fonnte Anda
        ])->post('https://api.fonnte.com/send', [
            'target' => $groupId,
            'message' => $message,
        ]);

        // Cek hasil response dari Fonnte
        if ($response->successful()) {
            Notification::make()
                ->title('Pesan Terkirim')
                ->body('Pesan berhasil dikirim ke grup WhatsApp.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Gagal Mengirim Pesan')
                ->body('Terjadi kesalahan saat mengirim pesan ke grup WhatsApp.')
                ->danger()
                ->send();
        }

        return back(); // Kembali ke halaman sebelumnya
    }
}
