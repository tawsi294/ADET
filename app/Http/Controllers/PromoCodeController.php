<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of promo codes
     */
    public function index()
    {
        $promoCodes = PromoCode::paginate(10); // Adjust per-page as needed
        return view('promocodes.index', compact('promoCodes'));
    }

    /**
     * Store a newly created promo code
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:promocodes,code',
            'description' => 'nullable|string|max:255',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'expiration_date' => 'required|date|after_or_equal:today',
            'usage_limit' => 'nullable|integer|min:1',
            'min_purchase' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $promoCode = PromoCode::create([
                'code' => $request->code,
                'description' => $request->description,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'start_date' => $request->start_date,
                'expiration_date' => $request->expiration_date,
                'usage_limit' => $request->usage_limit,
                'min_purchase' => $request->min_purchase,
                'is_active' => $request->boolean('is_active', false),
                'usage_count' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Promo code created successfully.',
                'promo' => $promoCode,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create promo code: ' . $e->getMessage(),
            ], 500);
        }
    }
}