<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class FonnteController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Ambil nomor tujuan dan pesan dari request
        $message = $request->message;
        $groupId = '120363397369324112@g.us' ;

        // Kirim request ke API Fonnte
        $response = Http::withHeaders([
            'Authorization' => 'zb6NfMAHH9FkwHvyQeh5',
        ])->post('https://api.fonnte.com/send', [
            'target' => $groupId, // ID Grup WhatsApp
            'message' => $message,
        ]);

        // Cek hasil response
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pesan berhasil dikirim!',
                'data' => $response->json()
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengirim pesan.',
                'error' => $response->body()
            ], 500);
        }
    }
}
