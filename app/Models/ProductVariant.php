<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $guarded = [''];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function values()
    {
        return $this->belongsToMany(
            ProductOptionValue::class,
            "product_option_value_product_variant",
            'variant_id',
            'value_id'
        )->withTimestamps();
    }
}
