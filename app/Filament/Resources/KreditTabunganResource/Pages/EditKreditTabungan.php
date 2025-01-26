<?php

namespace App\Filament\Resources\KreditTabunganResource\Pages;

use Filament\Actions;
use App\Mail\KreditNotification;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\KreditTabunganResource;
use Illuminate\Support\Facades\Mail;

class EditKreditTabungan extends EditRecord
{
    protected static string $resource = KreditTabunganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterUpdate()
    {
        // Mengambil data siswa dan nominal dari record yang diperbarui
        $siswa = $this->record->siswa;
        $nominal = $this->record->nominal;

        // Kirim email notifikasi setelah update
        Mail::to($siswa->email)->send(new KreditNotification($siswa, $nominal));
    }
}
