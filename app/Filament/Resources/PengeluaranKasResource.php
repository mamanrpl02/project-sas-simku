<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PengeluaranKas;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Exports\PengeluaranKasExporter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengeluaranKasResource\Pages;
use App\Filament\Resources\PengeluaranKasResource\RelationManagers;

class PengeluaranKasResource extends Resource
{
    protected static ?string $model = PengeluaranKas::class;
    protected static ?string $navigationGroup = 'Kas';
    protected static ?string $navigationIcon = 'heroicon-o-document-minus';
    protected static ?string $navigationLabel = 'Pengeluaran Kas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('judul')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Judul'),

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()) // Default tanggal saat ini
                    ->placeholder('Pilih Tanggal'),

                TextInput::make('nominal')
                    ->label('Nominal')
                    ->required()
                    ->numeric()
                    ->placeholder('Masukkan Nominal'),

                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('judul')
                    ->label('Judul')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tanggal')
                    ->label('Tanggal Pengeluaran')
                    ->sortable()
                    ->date('l, d F Y')
                    ->searchable(),

                TextColumn::make('nominal')
                    ->label('nominal')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->sortable(),
            ])
            ->filters([
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
            'index' => Pages\ListPengeluaranKas::route('/'),
            'create' => Pages\CreatePengeluaranKas::route('/create'),
            'edit' => Pages\EditPengeluaranKas::route('/{record}/edit'),
        ];
    }
}
