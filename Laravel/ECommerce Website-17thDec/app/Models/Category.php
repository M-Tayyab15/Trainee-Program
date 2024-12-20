<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_category'; // Ensure this is the correct table name
    protected $primaryKey = 'cat_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'img_path',
        'created_by',
        'created_on',
        'modified_by',
        'modified_on',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'cat_id', 'cat_id');
    }
    public function getImageUrlAttribute()
    {
        return asset($this->img_path);
    }
}
