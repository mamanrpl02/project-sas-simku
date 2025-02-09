<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WhatsAppGroupController extends Controller
{
    public function index()
    {
        // Ambil data grup dari API Fonnte
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'), // Ganti dengan token Fonnte Anda
        ])->post('https://api.fonnte.com/get-whatsapp-group');

        $data = $response->json();

        // Pastikan data grup ada dan valid
        $groups = $data['data'] ?? [];

        // Kirim data ke tampilan
        return view('whatsapp-groups', compact('groups'));
    }

    public function updateGroup()
    {
        // Ambil data grup dari API Fonnte
        $response = Http::withHeaders([
            'Authorization' => env('FONNTE_API_KEY'), // Ganti dengan token Fonnte Anda
        ])->post('https://api.fonnte.com/fetch-group');


        // Ambil respons dari API
        $data = $response->json();

        // Periksa apakah update berhasil
        if ($response->successful() && isset($data['status']) && $data['status'] === true) {
            return redirect()->back()->with('success', 'Grup berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui grup.');
        }
    }
}
