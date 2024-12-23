<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
   
    protected $table = 'tbl_product_images';

    
    protected $primaryKey = 'img_id';

  
    public $timestamps = false;

   
    protected $fillable = ['filename', 'folder', 'pro_id', 'priority', 'created_on', 'modified_on'];

    
    public function product()
    {
        return $this->belongsTo(Product::class, 'pro_id', 'pro_id');
    }
}
