<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon untuk manipulasi tanggal
use App\Models\Siswa; // Model Siswa
use App\Models\Presensi; // Model Presensi

class FonnteController extends Controller
{
    public function sendAbsentStudentsToGroup()
    {
        // ID Grup WhatsApp
        $groupId = '120363397369324112@g.us'; // Ganti dengan ID grup yang valid

        // Ambil daftar siswa yang belum presensi hari ini
        $tanggalHariIni = Carbon::now()->toDateString(); // Format YYYY-MM-DD

        $siswaBelumPresensi = Siswa::whereDoesntHave('presensis', function ($query) use ($tanggalHariIni) {
            $query->where('date', $tanggalHariIni)
                  ->where('jenis', 'H') // Hanya yang hadir
                  ->where('is_approved', true); // Sudah disetujui
        })->pluck('nama'); // Ambil hanya nama siswa

        // Jika semua siswa sudah presensi
        if ($siswaBelumPresensi->isEmpty()) {
            $message = "✅ Semua siswa telah presensi hari ini!";
        } else {
            // Format daftar siswa dalam bentuk pesan WhatsApp
            $message = "⚠️ *Daftar Siswa yang Belum Presensi Hari Ini:*\n";
            foreach ($siswaBelumPresensi as $index => $nama) {
                $message .= ($index + 1) . ". " . $nama . "\n";
            }
            $message .= "\nMohon segera melakukan presensi! 📢";
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
            return response()->json([
                'status' => 'success',
                'message' => 'Pesan berhasil dikirim ke grup!',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim pesan ke grup.',
                'error' => $response->body()
            ], 500);
        }
    }
}
