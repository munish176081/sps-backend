<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
