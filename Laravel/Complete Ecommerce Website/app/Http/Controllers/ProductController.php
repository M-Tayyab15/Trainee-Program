<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $filters = $request->only(['category_name', 'product_name', 'price']);

        $products = Product::filter($filters)->withImageCount()->paginate(5);

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.1',
            'description' => 'nullable|string|max:500',
            'category_id' => 'required|exists:tbl_category,cat_id',
            'images' => 'nullable|array|max:1',
            'images.*' => 'image|mimes:jpeg,png,gif|max:2048',
            'priority' => 'in:H',
        ]);


        $product = Product::createFromRequest($request);


        $product->uploadProductImages($request);

 
        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function uploadImages(Request $request, $id)
    {

        $product = Product::findOrFail($id);
       
        $product->uploadProductImages($request);

        return redirect()->route('products.index')->with('success', 'Images uploaded successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'product_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:tbl_category,cat_id',
        'description' => 'nullable|string|max:500',
        'popularity' => 'nullable|in:0,1',  
    ]);

    $product = Product::findOrFail($id);

    // Update product details including popularity
    $product->updateFromRequest($request);

    // Update the popularity field
    $product->popularity = $request->has('popularity') ? 1 : 0;
    $product->save();

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}


    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->deactivate();

        return redirect()->route('products.index')->with('success', 'Product deactivated successfully.');
    }
    
    public function show($encryptedProductId)
    {
        // Decrypt the product ID
        $productId = decrypt($encryptedProductId);
    
        // Fetch the product with its images and category using Eloquent relationships
        $product = Product::with(['category', 'images' => function($query) {
            $query->orderBy('priority', 'desc'); // Prioritize 'H' images first
        }])->findOrFail($productId);
    
        // Separate the high priority images
        $mainImage = $product->images->firstWhere('priority', 'H');
        $otherImages = $product->images->where('priority', '!=', 'H');
    
        return view('products.details', compact('product', 'mainImage', 'otherImages'));
    }
}
