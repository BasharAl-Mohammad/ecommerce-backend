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
use Filament\Forms\Components\Section;
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
                Forms\Components\Tabs::make('')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Basic Information')
                                    ->schema([
                                        Forms\Components\Fieldset::make('Product Information')->schema([
                                            Forms\Components\TextInput::make('name')->columnSpan('full'),
                                            Forms\Components\Textarea::make('description')->columnSpan('full'),
                                            Forms\Components\Toggle::make('status')->label('Published'),
                                        ]),
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
                                        ]),
                                    Forms\Components\Tabs\Tab::make('Adding Variants')
                                    ->schema([
                                        Forms\Components\Repeater::make('variants')
                                            ->relationship('variants')
                                            ->schema([
                                                Forms\Components\Grid::make(2)->schema([
                                                    Forms\Components\TextInput::make('sku')->columnSpan(1),
                                                    Forms\Components\TextInput::make('gtin')->columnSpan(1),
                                                    Forms\Components\TextInput::make('mpn')->columnSpan(1),
                                                    Forms\Components\TextInput::make('ean')->columnSpan(1),
                                                    Forms\Components\Select::make('product_option_id')
                                                        ->options(ProductOption::all()->pluck('name', 'id'))
                                                        ->reactive()
                                                        ->afterStateUpdated(function (callable $set) {
                                                            $set('name',null);
                                                        })->columnSpan('full'),
                                                    Forms\Components\Select::make('product_option_value_id')                     
                                                        ->options(function (callable $get) {
                                                            $optionValues = ProductOption::find($get('product_option_id'));
                                                            if(!$optionValues) {
                                                                return [];
                                                            }
                                                            return $optionValues->values->pluck('name','id');
                                                        })
                                                        ->reactive()
                                                        ->columnSpan('full')
                                                    ])
                                                
                                                    ]),
                                                ]),
                                                Forms\Components\Tabs\Tab::make('Sizing and Shipping')
                                                    ->schema([
                                                        Forms\Components\Grid::make(6)
                                                            ->schema([
                                                                Forms\Components\Grid::make(10)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('length_value')->columnSpan(7),
                                                                        Forms\Components\Select::make('length_unit')->options(['cm','mm'])->columnSpan(3)   
                                                                    ])->columnSpan(2),
                                                                Forms\Components\Grid::make(10)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('width_value')->columnSpan(7),
                                                                        Forms\Components\Select::make('width_unit')->options(['cm','mm'])->columnSpan(3)   
                                                                    ])->columnSpan(2),
                                                                Forms\Components\Grid::make(10)
                                                                    ->schema([
                                                                        Forms\Components\TextInput::make('height_value')->columnSpan(7),
                                                                        Forms\Components\Select::make('height_unit')->options(['cm','mm'])->columnSpan(3)   
                                                                    ])->columnSpan(2) 
                                                                    ]),
                                                                Forms\Components\Grid::make(6)
                                                                    ->schema([
                                                                    Forms\Components\Grid::make(10)
                                                                        ->schema([
                                                                            Forms\Components\TextInput::make('weight_value')->columnSpan(7),
                                                                            Forms\Components\Select::make('weight_unit')->options(['cm','mm'])->columnSpan(3)   
                                                                        ])->columnSpan(2),
                                                                    Forms\Components\Grid::make(10)
                                                                        ->schema([
                                                                            Forms\Components\TextInput::make('volume_value')->columnSpan(7),
                                                                            Forms\Components\Select::make('volume_unit')->options(['cm','mm'])->columnSpan(3)   
                                                                        ])->columnSpan(2),
                                                                        ]),
                                                                Forms\components\Toggle::make('shippable')
                                                    ]),
                                                    Forms\Components\Tabs\Tab::make('Inventory')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('stock')
                                                            ->numeric()
                                                            ->minValue(1)
                                                            ->maxValue(10000),
                                                        Forms\Components\TextInput::make('backorder')
                                                            ->numeric()
                                                            ->minValue(10000)
                                                            ->maxValue(100),
                                                        Forms\Components\Select::make('purchasable')
                                                            ->options(['Always','In Stock','Backorder']),
                                                    ])
                                                ])->columnSpan('full'),
                                                
                                
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
