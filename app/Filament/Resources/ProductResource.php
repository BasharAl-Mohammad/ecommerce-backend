<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Filament\Forms\FormsComponent;
use PhpOption\Option;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Brand')
                    ->relationship('brand')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required(),
                        Forms\Components\TextInput::make('website'),
                    ]),
                Forms\Components\Fieldset::make('Product Category')
                    ->relationship('productCategory')
                    ->schema([
                        Forms\Components\TextInput::make('name')->required()->columnSpan('full'),
                        Forms\Components\Textarea::make('description')->columnSpan('full'),
                    ]),
                Forms\Components\Repeater::make('variants')
                    ->relationship('variants')
                    ->schema([
                        Forms\Components\TextInput::make('sku'),
                        Forms\Components\Select::make('product_option_id')
                            ->options(ProductOption::all()->pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('name',null);
                                }),
                        Forms\Components\Select::make('product_option_value_id')                     
                            ->options(function (callable $get) {
                                $optionValues = ProductOption::find($get('product_option_id'));
                                    if(!$optionValues) {
                                        return [];
                                        }
                                        return $optionValues->values->pluck('name','id');
                                    })
                            ->reactive()
                        ])
                        ->grid(2)
                        ->columnSpan('full'),
                ]);

                
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
