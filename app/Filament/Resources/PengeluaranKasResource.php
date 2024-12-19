<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PengeluaranKas;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengeluaranKasResource\Pages;
use App\Filament\Resources\PengeluaranKasResource\RelationManagers;

class PengeluaranKasResource extends Resource
{
    protected static ?string $model = PengeluaranKas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                    ->date('D , d M Y')
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
            'index' => Pages\ListPengeluaranKas::route('/'),
            'create' => Pages\CreatePengeluaranKas::route('/create'),
            'edit' => Pages\EditPengeluaranKas::route('/{record}/edit'),
        ];
    }
}
