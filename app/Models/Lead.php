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
        'source'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
