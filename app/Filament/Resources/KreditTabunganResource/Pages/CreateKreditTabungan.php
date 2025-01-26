<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use App\Filament\Resources\KreditTabunganResource;
use App\Mail\KreditNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreateKreditTabungan extends CreateRecord
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate()
    {
        // Mengambil data siswa dan nominal dari record yang baru dibuat
        $siswa = $this->record->siswa;
        $nominal = $this->record->nominal;

        // Kirim email notifikasi
        Mail::to($siswa->email)->send(new KreditNotification($siswa, $nominal));
    }
}
