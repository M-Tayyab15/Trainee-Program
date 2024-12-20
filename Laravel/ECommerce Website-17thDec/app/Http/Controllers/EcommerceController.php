<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class EcommerceController extends Controller
{
    public function index()
    {
        // Fetch all categories (no need to filter H priority images for categories)
        $categories = Category::with('products')->get();

        // Fetch hot products with H priority images
        $hotProducts = Product::hotProducts(); // This already filters for H priority images

        // Fetch products for specific categories (Football, Cricket, etc.)
        $footballCategory = Category::where('name', 'Football')->first();
        $cricketCategory = Category::where('name', 'Cricket')->first();
        $hockeyCategory = Category::where('name', 'Hockey')->first();
        $tennisCategory = Category::where('name', 'Tennis')->first();
        $badmintonCategory = Category::where('name', 'Badminton')->first();

        $footballProducts = $footballCategory ? $footballCategory->products()
            ->whereHas('images', function ($query) {
                $query->where('priority', 'H');
            })
            ->where('status', 1) // Filter by active status
            ->get() : [];

        $cricketProducts = $cricketCategory ? $cricketCategory->products()
            ->whereHas('images', function ($query) {
                $query->where('priority', 'H');
            })
            ->where('status', 1) // Filter by active status
            ->get() : [];

        $hockeyProducts = $hockeyCategory ? $hockeyCategory->products()
            ->whereHas('images', function ($query) {
                $query->where('priority', 'H');
            })
            ->where('status', 1) // Filter by active status
            ->get() : [];

        $tennisProducts = $tennisCategory ? $tennisCategory->products()
            ->whereHas('images', function ($query) {
                $query->where('priority', 'H');
            })
            ->where('status', 1) // Filter by active status
            ->get() : [];

        $badmintonProducts = $badmintonCategory ? $badmintonCategory->products()
            ->whereHas('images', function ($query) {
                $query->where('priority', 'H');
            })
            ->where('status', 1) // Filter by active status
            ->get() : [];

        return view('ecommerce', compact(
            'categories',
            'hotProducts',
            'footballProducts',
            'cricketProducts',
            'hockeyProducts',
            'tennisProducts',
            'badmintonProducts'
        ));
    }
}
