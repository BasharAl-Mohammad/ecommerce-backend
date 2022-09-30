<?php

namespace App\Filament\Resources\ProductResource\Pages;

use stdClass;
use Filament\Pages\Actions;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductOptionResource;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function beforeCreate(): void
    {
        // dd($this->data);
        $option=new stdClass();
        $values= array();
        foreach ($this->data['variants'] as $varKey => $variant) {
            $values=[];
            foreach($variant['values'] as $key => $value) {
                $option = ProductOption::where('name',$key)->first(['name','id']);
                if(is_null($option)){
                    $productOption = new ProductOption([
                        'name' => $key,
                    ]);
                    $productOption->save();

                    $productOptionValue = new ProductOptionValue([
                        'product_option_id' => $productOption->id,
                        'name' => $value
                    ]);
                    $productOptionValue->save();
                    array_push($values,$productOptionValue->id);
                } else{
                    $productValue = ProductOptionValue::where([
                        ['name','=',$value],
                        ['product_option_id','=',$option->id]
                    ])->first(['name','id']);
                    if(is_null($productValue)){
                        $productOptionValue = new ProductOptionValue([
                            'product_option_id' => $option->id,
                            'name' => $value
                        ]);
                        $productOptionValue->save();
                        array_push($values,$productOptionValue->id);
                    }else{
                        array_push($values,$productValue->id);}

                }                    
            }
            $this->data['variants'][$varKey]['values']=$values;
        }
        // dd($this->data);
    }
}
