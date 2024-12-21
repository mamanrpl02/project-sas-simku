<?php

namespace App\Filament\Resources;

use Actions\Action;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DebitTabungan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DebitTabunganResource\Pages;
use App\Filament\Resources\DebitTabunganResource\RelationManagers;

class DebitTabunganResource extends Resource
{
    protected static ?string $model = DebitTabungan::class;

    protected static ?string $navigationGroup = 'Tabungan';
    protected static ?string $navigationLabel = 'Debit Tabungan';

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('siswa_id')
                    ->required() 
                    ->relationship('siswa', 'nama'),
                TextInput::make('nominal')->numeric()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.nama')->label('Nama'),
                TextColumn::make('nominal')->numeric()->label('Nominal'),
                TextColumn::make('created_at')->dateTime('D d M Y')->label('Tanggal'),
            ])
            ->filters([
                SelectFilter::make('siswa_id')->label('Nama Siswa')
                    ->relationship('siswa', 'nama')
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
            'index' => Pages\ListDebitTabungans::route('/'),
            'create' => Pages\CreateDebitTabungan::route('/create'),
            'edit' => Pages\EditDebitTabungan::route('/{record}/edit'),
        ];
    }
}
