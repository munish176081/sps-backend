<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'product_id',
        'phone',
        'message',
        'form_type',
        'source_page',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function getStoneNamesAttribute()
    {
        if (!isset($this->data['stones'])) {
            return null;
        }

        return Product::whereIn('id', $this->data['stones'])
            ->pluck('title')
            ->implode(', ');
    }
}
