<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductOptionResource\Pages;
use App\Filament\Resources\ProductOptionResource\RelationManagers;
use App\Models\ProductOption;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductOptionResource extends Resource
{
    protected static ?string $model = ProductOption::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Products Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\Repeater::make('Values')
                        ->relationship('values')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                    ])->hiddenOn('edit')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\ValuesRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductOptions::route('/'),
            'create' => Pages\CreateProductOption::route('/create'),
            'edit' => Pages\EditProductOption::route('/{record}/edit'),
        ];
    }    
}
