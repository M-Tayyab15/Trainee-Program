<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    protected $table = 'tbl_product';
    protected $primaryKey = 'pro_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'description',
        'cat_id',
        'popularity',
        'created_on',
        'updated_on',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cat_id', 'cat_id');
    }
   

    public static function hotProducts()
    {
        // Only fetch products with 'H' priority images
        return self::where('popularity', 1)
            ->with(['images' => function ($query) {
                $query->where('priority', 'H');
            }])
            ->limit(10)
            ->get();
    }

    // Fetch images with H priority
    public function imagesWithHPriority()
    {
        return $this->images()->where('priority', 'H');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'pro_id', 'pro_id');
    }


    public function scopeFilter($query, $filters)
    {

        if (isset($filters['category_name'])) {
            $query->whereHas('category', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['category_name'] . '%');
            });
        }

        //filters
        if (isset($filters['product_name'])) {
            $query->where('name', 'like', '%' . $filters['product_name'] . '%');
        }


        if (isset($filters['price'])) {
            $query->where('price', 'like', '%' . $filters['price'] . '%');
        }

        return $query->where('status', 1);
    }

    public function scopeWithImageCount($query)
    {
        return $query->withCount('images');
    }



    // create 
    public static function createFromRequest($request)
    {
        return self::create([
            'name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'cat_id' => $request->category_id,
            'created_on' => now()->timestamp,
            'status' => 1,
        ]);
    }

    // edit
    public function updateFromRequest($request)
    {
        $this->update([
            'name' => $request->product_name,
            'price' => $request->price,
            'description' => $request->description,
            'cat_id' => $request->category_id,
        ]);
    }

    //delete
    public function deactivate()
    {
        $this->update(['status' => 0]);
    }

    // Handle image upload 
    public function uploadProductImages(Request $request)
    {
        $maxImages = 5;
        $existingImagesCount = $this->images()->count();
        $remainingImages = $maxImages - $existingImagesCount;

        // only images
        $request->validate([
            'images' => 'nullable|array|max:' . $remainingImages,
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // no image passing on creation handling
        $images = $request->file('images') ?? [];

        // Check if the number of images exceeds the remaining slots
        if (count($images) > $remainingImages) {
            return false;
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('uploads/products/' . $this->pro_id), $imageName);

                $this->images()->create([
                    'filename' => $imageName,
                    'folder' => 'uploads/products/' . $this->pro_id,
                    'created_on' => now()->timestamp,
                    'priority' => $request->priority ?? 'L',
                ]);
            }
        }

        return true;
    }

    public function cartProducts()
{
    return $this->hasMany(CartProduct::class, 'pro_id', 'pro_id');
}

}
