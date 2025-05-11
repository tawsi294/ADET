<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query();

        // Filter by max price if provided
        if ($request->has('max_price')) {
            $products->where('price', '<=', $request->input('max_price'));
        }

        $products = $products->get();

        // Check if the request is AJAX
        if ($request->ajax()) {
            return view('partials.product-grid', compact('products'))->render();
        }

        return view('shop', compact('products'));
    }
}