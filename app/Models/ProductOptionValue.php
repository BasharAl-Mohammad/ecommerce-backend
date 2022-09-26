<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    use HasFactory;

    protected $guarded =[''];

    public function option()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }

    public function variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            "product_option_value_product_variant",
            'value_id',
            'variant_id'
        )->withTimestamps();
    }
}
