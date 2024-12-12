<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KasResource\Pages;
use App\Filament\Resources\KasResource\RelationManagers;
use App\Models\Kas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KasResource extends Resource
{
    protected static ?string $model = Kas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jenis_transaksi')
                ->options([
                    'Kas Masuk' => 'Kas Masuk',
                    'Kas Keluar' => 'Kas Keluar',
                ])
                ->required()
                ->reactive(), // Membuat field ini reaktif saat memilih opsi

            Forms\Components\Select::make('siswa_id')
                ->relationship('siswa', 'nama')
                ->nullable() // Mengizinkan null jika Kas Keluar dipilih
                ->required(fn($get) => $get('jenis_transaksi') === 'Kas Masuk') // Wajib diisi hanya jika Kas Masuk
                ->visible(fn($get) => $get('jenis_transaksi') === 'Kas Masuk'), // Siswa_id hanya tampil saat Kas Masuk

            Forms\Components\TextInput::make('jumlah')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('keterangan')
                ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('siswa.nama'), // Menampilkan nama siswa di tabel
                Tables\Columns\TextColumn::make('jenis_transaksi'),
                Tables\Columns\TextColumn::make('jumlah')->numeric(),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\TextColumn::make('created_at')->label('Tanggal Transaksi')->dateTime('d M Y H:i'), // Menampilkan tanggal otomatis
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKas::route('/'),
            'create' => Pages\CreateKas::route('/create'),
            'edit' => Pages\EditKas::route('/{record}/edit'),
        ];
    }
}
