<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Siswa;
use App\Mail\sendEmail;
use App\Models\Presensi;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\DateFilter;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\PresensiExporter;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\PresensiResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\PresensiResource\RelationManagers;


class PresensiResource extends Resource
{
    protected static ?string $model = Presensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Presensi';


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

                Select::make('jenis')
                    ->required()
                    ->options([
                        'S' => 'Sakit',
                        'I' => 'Izin',
                        'A' => 'Alpha',
                        'H' => 'Hadir',
                    ]),

                FileUpload::make('bukti')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                    ->directory('bukti')
                    ->image()
                    ->imageEditor(),

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
                    ->sortable()
                    ->searchable(),

                TextColumn::make('time_in')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('time_out')
                    ->label('Pulang')
                    ->sortable()
                    ->searchable(),

                SelectColumn::make('jenis')
                    ->options([
                        'S' => 'S',
                        'I' => 'I',
                        'A' => 'A',
                        'H' => 'H',
                    ])
                    ->sortable()
                    ->searchable(),

                // SpatieMediaLibraryImageColumn::make('bukti'),

                CheckboxColumn::make('is_approved')
                    ->label('Setujui')
                    ->afterStateUpdated(function ($record, $state) {
                        // Mengubah nilai di database sesuai dengan checkbox
                        $record->update([
                            'is_approved' => $state ? 1 : 0,
                        ]);

                        // Jika is_approved adalah true (disetujui), kirim email ke siswa
                        if ($state) {
                            $siswa = $record->siswa;
                            $presensi = [
                                'date' => $record->date,
                                'time_in' => $record->time_in,
                                'time_out' => $record->time_out,
                                'jenis' => $record->jenis,
                                'bukti' => $record->bukti, // Pastikan field bukti diambil di sini
                            ];

                            // Kirim email
                            Mail::to($siswa->email)->send(new sendEmail($siswa, $presensi));
                        }
                    })
            ])
            ->filters([
                SelectFilter::make('siswa_id')->label('Nama Siswa')
                    ->relationship('siswa', 'nama'),

                SelectFilter::make('jenis')
                    ->label('Jenis Presensi')
                    ->options([
                        'S' => 'Sakit',
                        'I' => 'Izin',
                        'A' => 'Alfa',
                        'H' => 'Hadir',
                    ]),

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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
        ;
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
