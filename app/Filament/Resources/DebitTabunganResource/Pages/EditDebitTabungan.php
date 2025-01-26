<?php

namespace App\Filament\Resources\DebitTabunganResource\Pages;

use App\Filament\Resources\DebitTabunganResource;
use App\Mail\DebitNotification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditDebitTabungan extends EditRecord
{
    protected static string $resource = DebitTabunganResource::class;

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
        Mail::to($siswa->email)->send(new DebitNotification($siswa, $nominal));
    }
}
