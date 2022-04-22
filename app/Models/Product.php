<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price'
    ];

    public function product_attributes()
    {
        return $this->belongsToMany(Attribute::class, AttributeProduct::class);
    }

    public function get_product_specifications_attribute()
    {
        $specs = $this->specifications;
        $category_specs = $this->categories()->with('specifications')->get()->pluck('specifications')->collapse();
        return $category_specs;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, CategoryProduct::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, ProductSpecification::class);
    }
}
