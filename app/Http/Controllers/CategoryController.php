<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($id)
    {
        // Just an example; you can fetch categories from your database.
        $categories = [
            1 => 'Cat',
            2 => 'Dog',
            3 => 'Bird',
        ];

        $category = $categories[$id] ?? 'Category Not Found';

        return view('category', compact('category'));
    }
}
