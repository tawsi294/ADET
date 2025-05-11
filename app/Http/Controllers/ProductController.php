<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller  
{
    public function index(Request $request)
    {
        $products = Product::query();

        // Filter by max price if provided
        if ($request->has('max_price')) {
            $products->where('price', '<=', $request->input('max_price'));
        }

        $products = $products->paginate(12);

        // Check if the request is AJAX
        if ($request->ajax()) {
            return view('partials.product-grid', compact('products'))->render();
        }

        return view('shop', compact('products'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', "%{$query}%")
                          ->orWhere('description', 'like', "%{$query}%")
                          ->paginate(12);

        return view('shop', compact('products'));
    }

    public function favorites()
    {
        // Fetch the user's favorite products (for now, just returning all products as a placeholder)
        $products = Product::paginate(12);

        return view('favorites', compact('products')); 
    }

    public function show($id)
    {
    $product = Product::findOrFail($id); // Fetch the product by ID
    return view('product-detail', compact('product')); // Return the product detail view
    }
}
