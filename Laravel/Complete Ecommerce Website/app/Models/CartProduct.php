<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'tbl_cart_products';

    // Disable timestamps since your table doesn't have created_at or updated_at columns
    public $timestamps = false;

    // Specify the primary key of the table (if not the default 'id')
    protected $primaryKey = 'cart_product_id';

    // Define the fillable columns (columns that can be mass assigned)
    protected $fillable = [
        'cart_id',
        'user_id',
        'pro_id',
        'quantity',
        'product_price',
        'total_price',
    ];

    // Define relationships (for example, a cart product belongs to a cart)
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'cart_id');
    }

    // Optionally, if you want to get the product associated with the cart product
    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'pro_id');
    }
}
