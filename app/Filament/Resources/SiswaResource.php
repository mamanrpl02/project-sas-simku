<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Pages\ViewSiswa;
use App\Models\Siswa;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\SiswaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SiswaResource\Pages\EditSiswa;
use App\Filament\Resources\SiswaResource\Pages\ListSiswas;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Filament\Resources\SiswaResource\Pages\CreateSiswa;


class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nisn')->numeric()->required(),
                Forms\Components\TextInput::make('nama')->required(),
                Forms\Components\Select::make('jenis_kelamin')
                    ->required()
                    ->options([
                        'Laki - Laki' => 'Laki - Laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Forms\Components\Textarea::make('alamat')->required()->placeholder('Contoh : Dsn. Pusakajati Ds. Pusakaratu RT.09 RW.02 Kec. Pusakanagara Kab. Subang Prov. Jawa Barat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nisn'),
                TextColumn::make('nama'),
                TextColumn::make('jenis_kelamin'),

                TextColumn::make('debit')
                    ->label('Total Debit')
                    ->getStateUsing(function ($record) {
                        return 'Rp ' . number_format($record->debitTabungans()->sum('nominal'), 0, ',', '.');
                    }),

                TextColumn::make('kredit')
                    ->label('Total Kredit')
                    ->getStateUsing(function ($record) {
                        return 'Rp ' . number_format($record->kreditTabungans()->sum('nominal'), 0, ',', '.');
                    }),

                TextColumn::make('saldo')
                    ->label('Total Saldo')
                    ->getStateUsing(function ($record) {
                        return 'Rp ' . number_format($record->saldo, 0, ',', '.');
                    }),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            // 'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
