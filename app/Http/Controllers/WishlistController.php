<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        $wishlist = session()->get('wishlist', []);
        $item = $request->input('item');

        if (in_array($item, $wishlist)) {
            $wishlist = array_filter($wishlist, fn($wishlistItem) => $wishlistItem !== $item);
        } else {
            $wishlist[] = $item;
        }

        session(['wishlist' => array_values($wishlist)]);

        return redirect()->back();
    }
}
