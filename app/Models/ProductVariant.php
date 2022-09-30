<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProductVariant extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [''];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function values()
    {
        return $this->belongsToMany(ProductOptionValue::class, 'product_option_value_variant', 'product_variant_id', 'product_option_value_id');
    }
}
