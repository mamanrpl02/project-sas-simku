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
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\PemasukanKasExporter;
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
                SelectFilter::make('siswa_id')->label('Nama Siswa')
                    ->relationship('siswa', 'nama'),
                Filter::make('created_at')
                    ->label('Tanggal')
                    ->form([
                        DatePicker::make('created_at')->label('Filter berdasarkan Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['created_at'],
                            fn($query, $created_at) => $query->whereDate('created_at', $created_at)
                        );
                    }),

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([ 
                Tables\Actions\DeleteBulkAction::make(),
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
