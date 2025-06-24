<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';  // Specify the table name if it's different from the default (cart)

    // Define the fillable columns (optional)
    protected $fillable = [
        'username', 'product_id', 'quantity'
    ];

    // Define the relationship with Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
}
}
