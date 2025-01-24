<?php

namespace App\Filament\Resources;

use App\Filament\Exports\KreditTabunganExporter;
use Filament\Forms;
use Filament\Tables;
use App\Models\Siswa;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\KreditTabungan;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Actions\ExportBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KreditTabunganResource\Pages;
use App\Filament\Resources\KreditTabunganResource\RelationManagers;
use Filament\Actions\ExportAction;

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
                    ->label('Siswa')
                    ->options(Siswa::all()->pluck('nama', 'id'))
                    ->searchable()->required(),

                TextInput::make('nominal')
                    ->numeric()
                    ->required()
                    ->minValue(1000)
                    ->maxValue(100000)
                    ->placeholder('Masukkan nominal')
                    ->helperText('Minimal 1.000, dan maksimal 100.000'),
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
            'index' => Pages\ListKreditTabungans::route('/'),
            'create' => Pages\CreateKreditTabungan::route('/create'),
            'edit' => Pages\EditKreditTabungan::route('/{record}/edit'),
        ];
    }
}
