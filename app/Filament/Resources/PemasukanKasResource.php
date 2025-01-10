<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Siswa;
use App\Models\Tagihan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PemasukanKas;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PemasukanKasResource\Pages;
use App\Filament\Resources\PemasukanKasResource\RelationManagers;

class PemasukanKasResource extends Resource
{
    protected static ?string $model = PemasukanKas::class;
    protected static ?string $navigationGroup = 'Kas';
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationLabel = 'Pemasukan Kas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('tagihan_id')
                    ->label('Pilih Tunggakan')
                    ->options(Tagihan::all()->pluck('tanggal', 'id'))
                    ->searchable()->required(),
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(Siswa::all()->pluck('nama', 'id'))
                    ->searchable()->required(),
                TextInput::make('nominal')
                    ->numeric()
                    ->required()
                    ->minValue(2000)
                    ->maxValue(100000)
                    ->helperText('Minimal 2.000, dan maksimal 100.000'),
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
                    ->date('l, d F Y')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Pelunasan')
                    ->date('l, d F Y')
                    ->sortable(),

                TextColumn::make('nominal')
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
