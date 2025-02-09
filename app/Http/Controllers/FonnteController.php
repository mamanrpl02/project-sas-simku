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
            $message = "✅ *Informasi Presensi* \nSeluruh siswa telah melakukan presensi pada hari ini, $tanggalFormatIndo. Terima kasih atas kedisiplinannya.";
        } else {
            $message = "⚠️ *Informasi Presensi* \nBerikut adalah daftar siswa yang belum melakukan presensi pada tanggal *$tanggalFormatIndo*: \n\n";

            foreach ($siswaBelumPresensi as $index => $nama) {
                $message .= ($index + 1) . ". " . $nama . "\n";
            }

            $message .= "\n🗓 Mohon segera melakukan presensi melalui tautan berikut: " . env('APP_URL') . "/presensi \n";
            $message .= "\n📩 Untuk mengajukan izin atau sakit , silahkan klik pada bagian menu pengajuan izin : " . env('APP_URL') . "/pengajuan-izin\n";
            $message .= "\nMohon kerja samanya agar seksi absensi dapat merekap dengan mudah 🙏🏻." . "\n\n";
            $message .= "\nTerima kasih atas perhatian dan kerja samanya.";
        }

        // Kirim pesan ke grup WhatsApp menggunakan Fonnte API
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'),
        ])->post('https://api.fonnte.com/send', [
            'target' => $groupId,
            'message' => $message,
        ]);

        // Cek hasil response dari Fonnte
        if ($response->successful()) {
            Notification::make()
                ->title('Pesan Terkirim')
                ->body('Pesan pengingat presensi telah berhasil dikirim ke grup WhatsApp.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Gagal Mengirim Pesan')
                ->body('Terjadi kendala saat mengirim pesan ke grup WhatsApp. Silakan coba lagi.')
                ->danger()
                ->send();
        }

        return back(); // Kembali ke halaman sebelumnya
    }
}
