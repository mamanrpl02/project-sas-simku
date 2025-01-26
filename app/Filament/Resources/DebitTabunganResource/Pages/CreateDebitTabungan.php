<?php

namespace App\Filament\Resources\DebitTabunganResource\Pages;

use Filament\Actions;
use App\Mail\DebitNotification;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DebitTabunganResource;

class CreateDebitTabungan extends CreateRecord
{
    protected static string $resource = DebitTabunganResource::class;

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
        Mail::to($siswa->email)->send(new DebitNotification($siswa, $nominal));
    }

    protected function afterUpdate()
    {
        // Mengambil data siswa dan nominal dari record yang baru dibuat
        $siswa = $this->record->siswa;
        $nominal = $this->record->nominal;

        // Kirim email notifikasi
        Mail::to($siswa->email)->send(new DebitNotification($siswa, $nominal));
    }
}
