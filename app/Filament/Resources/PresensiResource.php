<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Siswa;
use App\Models\Presensi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\DateTimePicker;
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
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(Siswa::all()->pluck('nama', 'id'))
                    ->searchable()->required(),

                DatePicker::make('date')
                    ->label('Tanggal')
                    ->nullable()
                    ->required(),

                TimePicker::make('time_in')
                    ->label('Waktu Masuk')
                    ->nullable(),

                TimePicker::make('time_out')
                    ->label('Waktu Keluar')
                    ->nullable(),

                Checkbox::make('is_approved')
                    ->label('Aprove')
                    ->default(false),
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

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->sortable(),

                TextColumn::make('time_in')
                    ->label('Datang')
                    ->sortable(),

                TextColumn::make('time_out')
                    ->label('Pulang')
                    ->sortable(),

                CheckboxColumn::make('is_approved')
                    ->label('Setujui')
                    ->afterStateUpdated(function ($record, $state) {
                        // Mengubah nilai di database sesuai dengan checkbox
                        $record->update([
                            'is_approved' => $state ? 1 : 0, // Jika dicentang, bernilai 1, jika tidak, bernilai 0
                        ]);
                    })
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
            'index' => Pages\ListPresensis::route('/'),
            'create' => Pages\CreatePresensi::route('/create'),
            // 'edit' => Pages\EditPresensi::route('/{record}/edit'),
        ];
    }
}
