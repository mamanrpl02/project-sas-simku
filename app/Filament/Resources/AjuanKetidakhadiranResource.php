<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Izin;
use Filament\Tables;
use App\Models\Siswa;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\AjuanKetidakhadiran;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AjuanKetidakhadiranResource\Pages;
use App\Filament\Resources\AjuanKetidakhadiranResource\RelationManagers;

class AjuanKetidakhadiranResource extends Resource
{
    protected static ?string $model = Izin::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationGroup = 'Presensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(Siswa::all()->pluck('nama', 'id'))
                    ->searchable()->required(),

                Select::make('jenis')
                    ->options([
                        'Sakit' => 'Sakit',
                        'Izin' => 'Izin',
                    ])->required(),

                DateTimePicker::make('date')
                    ->label('Tanggal')
                    ->nullable()
                    ->required(),

                Textarea::make('alasan')
                    ->autosize()
                    ->required(),

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

                TextColumn::make('jenis')
                    ->label('Jenis')
                    ->sortable(),

                TextColumn::make('date')
                    ->label('Tanggal')
                    ->sortable(),

                TextColumn::make('alasan')
                    ->label('Alasan')
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
                SelectFilter::make('siswa_id')->label('Nama Siswa')
                    ->relationship('siswa', 'nama'),
                Filter::make('date')
                    ->label('Tanggal')
                    ->form([
                        DatePicker::make('date')->label('Filter berdasarkan Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['date'],
                            fn($query, $date) => $query->whereDate('date', $date)
                        );
                    }),

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
            'index' => Pages\ListAjuanKetidakhadirans::route('/'),
            'create' => Pages\CreateAjuanKetidakhadiran::route('/create'),
            'edit' => Pages\EditAjuanKetidakhadiran::route('/{record}/edit'),
        ];
    }
}
