<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends Model
{
    use HasFactory, NodeTrait;

    protected $guarded = [];

    protected $parentColumn = 'parent_id';

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class,$this->parentColumn);
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, $this->parentColumn);
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
