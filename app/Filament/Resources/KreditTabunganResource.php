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
                    ->searchable()
                    ->relationship('siswa', 'nama'),
                TextInput::make('nominal')->numeric(),
            ]);
    }



    public static function table(Table $table): Table


    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama'),
                TextColumn::make('nominal')->numeric(),
                TextColumn::make('created_at')->dateTime('D d M Y')->label('Tanggal'),
            ])
            ->filters([
                SelectFilter::make('siswa_id')
                    ->relationship('siswa', 'nama')

            ])
            ->actions([])
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
