<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PemasukanKas;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemasukanKasResource\Pages;
use App\Filament\Resources\PemasukanKasResource\RelationManagers;
use App\Models\Siswa;
use App\Models\Tagihan;
use Filament\Tables\Columns\TextColumn;

class PemasukanKasResource extends Resource
{
    protected static ?string $model = PemasukanKas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tagihan_id')
                    ->label('Pilih Tunggakan')
                    ->options(Tagihan::all()->pluck('tanggal', 'id'))
                    ->searchable(),
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(Siswa::all()->pluck('nama', 'id'))
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama')
                    ->label('Nama Siswa')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tagihan.tanggal')
                    ->label('Tanggal Tagihan')
                    ->sortable()
                    ->date('D , d M Y')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Pelunasan')
                    ->date('D, d M Y')
                    ->sortable(),

                TextColumn::make('tagihan.nominal')
                    ->label('Nominal')
                    ->sortable()
                    ->money('IDR')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPemasukanKas::route('/'),
            'create' => Pages\CreatePemasukanKas::route('/create'),
            'edit' => Pages\EditPemasukanKas::route('/{record}/edit'),
        ];
    }
}
