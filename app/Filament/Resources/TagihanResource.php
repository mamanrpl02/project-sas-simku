<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Tagihan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use App\Filament\Exports\TagihanExporter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\TagihanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TagihanResource\RelationManagers;

class TagihanResource extends Resource
{
    protected static ?string $model = Tagihan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-currency-dollar';
    protected static ?string $navigationLabel = 'Tagihan Kas';
    protected static ?string $navigationGroup = 'Kas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()) // Default tanggal saat ini
                    ->placeholder('Pilih Tanggal'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')->searchable()->sortable()->date('l, d F Y'),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->label('Tanggal')
                    ->form([
                        DatePicker::make('tanggal')->label('Filter berdasarkan Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when(
                            $data['tanggal'],
                            fn($query, $tanggal) => $query->whereDate('tanggal', $tanggal)
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
            'index' => Pages\ListTagihans::route('/'),
            'create' => Pages\CreateTagihan::route('/create'),
            'edit' => Pages\EditTagihan::route('/{record}/edit'),
        ];
    }
}
