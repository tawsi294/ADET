<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InventoryController extends Controller
{
    /**
     * Display a listing of inventory items
     */
    public function index()
    {
        $inventories = Inventory::with('category')->get();
        $categories = Category::all();
        return view('inventory', compact('inventories', 'categories'));
    }

    /**
     * Store a newly created inventory item
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'sku' => 'required|string|max:50|unique:inventories,sku',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'cost' => 'required|numeric|min:0',
            'status' => 'required|in:active,low_stock,out_of_stock',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Handle file upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs('inventories', $imageName, 'public');
            }

            // Create inventory item
            $inventory = Inventory::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'sku' => $request->sku,
                'stock' => $request->stock,
                'price' => $request->price,
                'discount' => $request->discount ?? 0,
                'cost' => $request->cost,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            // Load category for response
            $inventory->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Inventory item created successfully.',
                'inventory' => $inventory,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create inventory item: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Show a single inventory item
     */
    public function show($id)
    {
        try {
            $inventory = Inventory::with('category')->findOrFail($id);
            return response()->json([
                'success' => true,
                'inventory' => $inventory,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inventory item not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve inventory item: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an existing inventory item
     */
    public function update(Request $request, $id)
    {
        try {
            $inventory = Inventory::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'sku' => 'required|string|max:50|unique:inventories,sku,' . $inventory->id,
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'discount' => 'nullable|numeric|min:0|max:100',
                'cost' => 'required|numeric|min:0',
                'status' => 'required|in:active,low_stock,out_of_stock',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                ], 422);
            }

            // Handle file upload
            $imagePath = $inventory->image;
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $imagePath = $request->file('image')->storeAs('inventories', $imageName, 'public');
            }

            // Update inventory item
            $inventory->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'sku' => $request->sku,
                'stock' => $request->stock,
                'price' => $request->price,
                'discount' => $request->discount ?? 0,
                'cost' => $request->cost,
                'status' => $request->status,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            // Load category for response
            $inventory->load('category');

            return response()->json([
                'success' => true,
                'message' => 'Inventory item updated successfully.',
                'inventory' => $inventory,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inventory item not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update inventory item: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Placeholder for future stock history retrieval
     * Requires a stock_history table and model
     */
    /*
    public function getStockHistory($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            // Example: $history = StockHistory::where('inventory_id', $id)->get();
            return response()->json([
                'success' => true,
                'history' => [], // Replace with actual history data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inventory item not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve stock history: ' . $e->getMessage(),
            ], 500);
        }
    }
    */

    /**
     * Placeholder for future price/discount history retrieval
     * Requires a price_discount_history table and model
     */
    /*
    public function getPriceDiscountHistory($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            // Example: $history = PriceDiscountHistory::where('inventory_id', $id)->get();
            return response()->json([
                'success' => true,
                'history' => [], // Replace with actual history data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Inventory item not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve price/discount history: ' . $e->getMessage(),
            ], 500);
        }
    }
    */
}