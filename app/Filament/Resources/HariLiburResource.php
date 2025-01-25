<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HariLiburResource\Pages;
use App\Filament\Resources\HariLiburResource\RelationManagers;
use App\Models\HariLibur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HariLiburResource extends Resource
{


    protected static ?string $model = HariLibur::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->label('Tanggal Libur')
                    ->required()
                    ->unique(HariLibur::class, 'tanggal'), // Validasi tanggal unik
                Forms\Components\Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->required()
                    ->placeholder('Contoh: Hari Raya, Libur Nasional, dsb.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->date(),
                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListHariLiburs::route('/'),
            // 'create' => Pages\CreateHariLibur::route('/create'),
            'edit' => Pages\EditHariLibur::route('/{record}/edit'),
        ];
    }
}
