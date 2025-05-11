<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $email = $request->input('email');

        // For now, we'll just flash the email to session as a placeholder
        session()->flash('success', "Subscribed successfully with email: $email");

        return redirect()->back();
    }
}
