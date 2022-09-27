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
        return $this->belongsTo(ProductOption::class);
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'product_option_value_variant', 'product_option_value_id', 'product_variant_id');
    }
        
}
