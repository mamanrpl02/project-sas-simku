<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Presensi;
use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Libur;  // Asumsikan ada model Libur

class PresensiController extends Controller
{

    public function isHoliday($date)
    {
        // Cek apakah tanggal ada di tabel hari_libur
        return HariLibur::where('tanggal', $date->toDateString())->exists();
    }

    public function presensi(Request $request)
    {
        // Mendapatkan data siswa yang sedang login
        $siswa = Auth::user();

        // Daftar bulan
        $bulanList = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        // Ambil bulan yang dipilih atau bulan sekarang
        $bulanDipilih = $request->input('bulan', '0'); // default '0' jika tidak ada bulan yang dipilih

        // Ambil data presensi siswa berdasarkan bulan yang dipilih
        if ($bulanDipilih == '0') {
            // Jika memilih "Semua", ambil semua presensi tanpa filter bulan
            $presensiList = Presensi::where('siswa_id', $siswa->id)
                ->orderBy('date', 'desc') // Mengurutkan dari yang terbaru ke yang lama
                ->get();
        } else {
            // Jika ada bulan yang dipilih, filter berdasarkan bulan tersebut
            $presensiList = Presensi::where('siswa_id', $siswa->id)
                ->whereMonth('date', $bulanDipilih)
                ->orderBy('date', 'desc') // Mengurutkan dari yang terbaru ke yang lama
                ->get();
        }

        $presensi = Presensi::all();

        // Return ke view dengan data presensi
        return view('siswa.presensi', compact('siswa', 'presensiList', 'bulanList', 'presensi'));
    }



    public function presensiMasuk(Request $request)
    {
        $siswa = Auth::user();
        $today = Carbon::today();
        $kemarin = Carbon::yesterday();

        // Periksa apakah hari ini Sabtu, Minggu, atau hari libur
        if ($today->isWeekend() || $this->isHoliday($today)) {
            return response()->json([
                'error' => 'Hari ini adalah hari libur atau tanggal merah, Anda tidak dapat melakukan presensi.',
            ]);
        }

        // Cek apakah hari kemarin adalah hari libur atau akhir pekan
        if (!$kemarin->isWeekend() && !$this->isHoliday($kemarin)) {
            // Cek apakah siswa sudah presensi kemarin
            $presensiKemarin = Presensi::where('siswa_id', $siswa->id)
                ->whereDate('date', $kemarin)
                ->exists();

            if (!$presensiKemarin) {
                // Jika tidak ada presensi kemarin, tambahkan data Absen (A)
                Presensi::create([
                    'siswa_id' => $siswa->id,
                    'date' => $kemarin,
                    'jenis' => 'A',  // A = Absen
                    'is_approved' => true,
                ]);
            }
        }

        // Cek apakah sudah presensi hari ini
        $presensiHariIni = Presensi::where('siswa_id', $siswa->id)
            ->whereDate('date', $today)
            ->first();

        if ($presensiHariIni) {
            return response()->json([
                'error' => 'Anda sudah melakukan presensi hari ini!',
            ]);
        }

        $presensi = Presensi::create([
            'siswa_id' => $siswa->id,
            'date' => $today,
            'time_in' => Carbon::now()->format('H:i:s'),
            'jenis' => 'H',
            'is_approved' => false,
        ]);

        return response()->json([
            'success' => 'Presensi datang berhasil!',
            'data' => $presensi,
        ]);
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



    // Store data izin
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|string',
            'alasan' => 'required|string',
            'bukti' => 'required|file|mimes:jpg,jpeg,png|max:2048',
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

    // Method pengajuan izin
    public function create()
    {
        return view('siswa.pengajuan'); // Mengarahkan ke form pengajuan izin
    }
}
