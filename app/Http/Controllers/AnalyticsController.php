<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        return view('analytics.index'); // Make sure this view file exists
    }
}
