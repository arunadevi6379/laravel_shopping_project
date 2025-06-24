<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // If you are using any custom column names, define them here
    protected $fillable = ['name', 'price', 'quantity', 'description', 'image']; // Adjust according to your columns

    // Optional: If your table name is different than 'products'
protected $table='products';
}