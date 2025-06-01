<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get all products for the authenticated seller
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            // Check if user is a seller
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can access this resource.'
                ], 403);
            }

            $products = Product::bySeller($user->_id)
                              ->orderBy('created_at', 'desc')
                              ->get();

            // Transform products for API response
            $transformedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->_id,
                    'name' => $product->name,
                    'category' => $product->category,
                    'price' => $product->price,
                    'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                    'description' => $product->description,
                    'image' => $product->image ? Storage::url($product->image) : null,
                    'status' => $product->status,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully',
                'data' => [
                    'products' => $transformedProducts,
                    'total_count' => $products->count()
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving products: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new product
     */
    public function store(Request $request)
    {
        try {
            $user = $request->user();
            
            // Check if user is a seller
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can create products.'
                ], 403);
            }

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'category' => 'required|string|in:Whole Spices,Ground Spices,Fresh Herbs,Dried Herbs,Seeds,Roots & Rhizomes',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $imagePath = null;
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imagePath = $image->store('products', 'public');
            }

            // Create product
            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'price' => $request->price,
                'description' => $request->description,
                'image' => $imagePath,
                'seller_id' => $user->_id,
                'status' => 'active'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data' => [
                    'product' => [
                        'id' => $product->_id,
                        'name' => $product->name,
                        'category' => $product->category,
                        'price' => $product->price,
                        'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                        'description' => $product->description,
                        'image' => $product->image ? Storage::url($product->image) : null,
                        'status' => $product->status,
                        'created_at' => $product->created_at,
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get a single product
     */
    public function show(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            $product = Product::where('_id', $id)
                             ->where('seller_id', $user->_id)
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or access denied'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product retrieved successfully',
                'data' => [
                    'product' => [
                        'id' => $product->_id,
                        'name' => $product->name,
                        'category' => $product->category,
                        'price' => $product->price,
                        'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                        'description' => $product->description,
                        'image' => $product->image ? Storage::url($product->image) : null,
                        'status' => $product->status,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update a product
     */
    public function update(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            $product = Product::where('_id', $id)
                             ->where('seller_id', $user->_id)
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or access denied'
                ], 404);
            }

            // Validation
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|required|string|max:255',
                'category' => 'sometimes|required|string|in:Whole Spices,Ground Spices,Fresh Herbs,Dried Herbs,Seeds,Roots & Rhizomes',
                'price' => 'sometimes|required|numeric|min:0',
                'description' => 'sometimes|required|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'sometimes|in:active,inactive',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }
                
                $image = $request->file('image');
                $imagePath = $image->store('products', 'public');
                $product->image = $imagePath;
            }

            // Update other fields
            $product->update($request->only(['name', 'category', 'price', 'description', 'status']));

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data' => [
                    'product' => [
                        'id' => $product->_id,
                        'name' => $product->name,
                        'category' => $product->category,
                        'price' => $product->price,
                        'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                        'description' => $product->description,
                        'image' => $product->image ? Storage::url($product->image) : null,
                        'status' => $product->status,
                        'updated_at' => $product->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a product
     */
    public function destroy(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            $product = Product::where('_id', $id)
                             ->where('seller_id', $user->_id)
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or access denied'
                ], 404);
            }

            // Delete image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting product: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get available categories
     */
    public function categories()
    {
        return response()->json([
            'success' => true,
            'message' => 'Categories retrieved successfully',
            'data' => [
                'categories' => [
                    'Whole Spices',
                    'Ground Spices', 
                    'Fresh Herbs',
                    'Dried Herbs',
                    'Seeds',
                    'Roots & Rhizomes'
                ]
            ]
        ]);
    }

    /**
     * Get seller dashboard stats
     */
    public function stats(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can access this resource.'
                ], 403);
            }

            $totalProducts = Product::bySeller($user->_id)->count();
            $activeProducts = Product::bySeller($user->_id)->where('status', 'active')->count();
            $inactiveProducts = Product::bySeller($user->_id)->where('status', 'inactive')->count();

            return response()->json([
                'success' => true,
                'message' => 'Stats retrieved successfully',
                'data' => [
                    'stats' => [
                        'total_products' => $totalProducts,
                        'active_products' => $activeProducts,
                        'inactive_products' => $inactiveProducts,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving stats: ' . $e->getMessage()
            ], 500);
        }
    }
}