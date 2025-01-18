<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinPengajuanController extends Controller
{
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

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            // Menyimpan file bukti
            $buktiPath = $request->file('bukti')->store('bukti', 'public');
        }

        Izin::create([
            'siswa_id' => Auth::id(),
            'jenis' => $request->jenis,
            'alasan' => $request->alasan,
            'bukti' => $buktiPath,
            'date' => Carbon::now()->toDateString(),  // Menyimpan tanggal pengajuan izin

        ]);

        // Kembali ke halaman pengajuan dengan data untuk menampilkan alert
        return redirect()->route('pengajuan')->with('swal', [
            'title' => 'Ketidakhadiran Berhasil di Ajukan!',
            'text' => 'Izin Anda telah berhasil diajukan tunggu sampai seksi absensi atau wali kelas menyetujuinya.',
            'icon' => 'success',
            'button' => 'OK'
        ]);
    }
}
