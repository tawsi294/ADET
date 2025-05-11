<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $cart[] = $request->input('item');
        session(['cart' => $cart]);

        return redirect()->route('cart');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $index = $request->input('index');

        if (isset($cart[$index])) {
            unset($cart[$index]);
            session(['cart' => array_values($cart)]); // Re-index the array
        }

        return redirect()->route('cart');
    }
}
