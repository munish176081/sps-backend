<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'status',
        'banner_image',
        'title',
        'subtitle',
        'overview',
        'gallery',
        'specs',
        'collections_title',
        'collections_description',
        'faqs',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'specs' => 'array',
        'faqs' => 'array',
        'gallery' => 'array',
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function booted()
    {
        static::saving(function ($category) {
            if ($category->name) {
                $category->name = Str::title($category->name);
            }
        });
    }
}
