<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tagihan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TagihanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagihanResource\RelationManagers;

class TagihanResource extends Resource
{
    protected static ?string $model = Tagihan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationLabel = 'Tagihan Kas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()) // Default tanggal saat ini
                    ->placeholder('Pilih Tanggal'),

                TextInput::make('pesan')
                    ->label('Pesan')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukkan Pesan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal'),
                TextColumn::make('pesan'),
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
            'index' => Pages\ListTagihans::route('/'),
            'create' => Pages\CreateTagihan::route('/create'),
            'edit' => Pages\EditTagihan::route('/{record}/edit'),
        ];
    }
}
