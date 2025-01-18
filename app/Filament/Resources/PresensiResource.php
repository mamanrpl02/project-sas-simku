<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Presensi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
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
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Nama Siswa')
                    ->required()
                    ->disabled(), // Nonaktifkan edit oleh wali kelas
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->disabled(), // Nonaktifkan edit oleh wali kelas
                Select::make('status')
                    ->options([
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                        'izin' => 'Izin',
                        'sakit' => 'Sakit',
                    ])
                    ->required()
                    ->disabled(),
                TimePicker::make('time_in')->label('Jam Masuk')->disabled(),
                TimePicker::make('time_out')->label('Jam Keluar')->disabled(),
                Toggle::make('is_approved')
                    ->label('Disetujui')
                    ->default(false),
                Select::make('approved_by')
                    ->label('Disetujui Oleh')
                    ->relationship('approvedBy', 'name')
                    ->required()
                    ->default(auth()->user()->id)
                    ->disabled(),
                Textarea::make('note')->label('Keterangan')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama Siswa'),
                TextColumn::make('date')->date('d M Y')->label('Tanggal'),
                TextColumn::make('status')->label('Status'),
                IconColumn::make('is_approved')
                    ->boolean()
                    ->label('Disetujui'),
                TextColumn::make('approvedBy.name')->label('Disetujui Oleh')->nullable(),
            ])
            ->filters([
                Filter::make('is_approved')
                    ->label('Belum Disetujui')
                    ->query(fn(Builder $query) => $query->where('is_approved', false)),
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
