<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        return view('favorites.index');
    }
}
