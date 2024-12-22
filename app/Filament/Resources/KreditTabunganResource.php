<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\KreditTabungan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextInputColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KreditTabunganResource\Pages;
use App\Filament\Resources\KreditTabunganResource\RelationManagers;

class KreditTabunganResource extends Resource
{
    protected static ?string $model = KreditTabungan::class;

    protected static ?string $navigationGroup = 'Tabungan';
    protected static ?string $navigationLabel = 'Kredit Tabungan';


    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('siswa_id')
                    ->required()
                    ->relationship('siswa', 'nama'),
                TextInput::make('nominal')
                    ->numeric()
                    ->required()
                    ->minValue(1000)
                    ->maxValue(100000) 
                    ->placeholder('Masukkan nominal')
                    ->helperText('Nominal harus kelipatan 500, minimal 1.000, dan maksimal 100.000'),
            ]);
    }



    public static function table(Table $table): Table


    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama'),
                TextColumn::make('nominal')->numeric(),
                TextColumn::make('created_at')->dateTime('l, d F Y')->label('Tanggal'),
            ])
            ->filters([
                SelectFilter::make('siswa_id')
                    ->relationship('siswa', 'nama')

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
            'index' => Pages\ListKreditTabungans::route('/'),
            'create' => Pages\CreateKreditTabungan::route('/create'),
            'edit' => Pages\EditKreditTabungan::route('/{record}/edit'),
        ];
    }
}
