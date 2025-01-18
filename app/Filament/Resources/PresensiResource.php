<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Presensi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PresensiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PresensiResource\RelationManagers;

class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('status')
                    ->options([
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                    ])
                    ->required(),
                TimePicker::make('time_in')
                    ->label('Waktu Masuk')
                    ->nullable()
                    ->required(),
                TimePicker::make('time_out')
                    ->label('Waktu Keluar')
                    ->nullable()
                    ->required(),
                Checkbox::make('is_approved')
                    ->label('Disetujui oleh Wali Kelas')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                BadgeColumn::make('is_approved')
                    ->label('Status Persetujuan')
                    ->enum([
                        true => 'Disetujui',
                        false => 'Belum Disetujui',
                    ])
                    ->color(fn(string $state) => $state === 'true' ? 'success' : 'danger'),
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
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }
}
