<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
    public function presensiMasuk(Request $request)
    {
        // Cek apakah data siswa_id ada di request
        Log::info('Siswa ID: ' . $request->siswa_id);

        // Ambil siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();

        // Cek apakah siswa login sudah valid
        Log::info('Siswa Login: ' . $siswa->id);

        // Cek apakah presensi sudah ada hari ini
        $presensi = Presensi::where('siswa_id', $siswa->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$presensi) {
            Presensi::create([
                'siswa_id' => $siswa->id,
                'date' => Carbon::today(),
                'time_in' => Carbon::now()->toTimeString(),
            ]);

            Log::info('Presensi Berhasil Masuk: ' . $siswa->id);
            return response()->json(['success' => 'Berhasil presensi masuk!']);
        }

        Log::info('Presensi Gagal: Sudah presensi hari ini');
        return response()->json(['error' => 'Anda sudah melakukan presensi hari ini!']);
    }

    public function presensiKeluar(Request $request)
    {
        // Ambil siswa yang sedang login
        $siswa = Auth::guard('siswa')->user();

        // Cari presensi untuk hari ini
        $presensi = Presensi::where('siswa_id', $siswa->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if ($presensi && !$presensi->time_out) {
            // Update presensi keluar
            $presensi->update([
                'time_out' => Carbon::now()->toTimeString(),
            ]);

            return response()->json(['success' => 'Berhasil presensi keluar!']);
        }

        return response()->json(['error' => 'Gagal presensi keluar, Anda belum melakukan presensi masuk!']);
    }
}
