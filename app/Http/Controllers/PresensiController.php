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
            return response()->json(['success' => 'Presensi berhasil, tunggu di approve oleh seksi absensi yaa!']);
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

            return response()->json(['success' => 'Berhasil presensi pulang!']);
        }

        return response()->json(['error' => 'Gagal presensi pulang, Anda belum melakukan presensi masuk!']);
    }

    public function create()
    {
        return view('siswa.pengajuan'); // Mengarahkan ke form pengajuan izin
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'alasan' => 'required|string',
            'bukti' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Simpan file bukti jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti', 'public');
        }

        // Buat data presensi baru
        Presensi::create([
            'siswa_id' => Auth::id(),
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'bukti' => $buktiPath,
            'date' => now()->toDateString(), // Simpan tanggal hari ini
        ]);

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil di ajukan, tunggu di setujui oleh absensi yaa.');
    }

    public function render()
    {
        return view('livewire.presensi');
    }
}
