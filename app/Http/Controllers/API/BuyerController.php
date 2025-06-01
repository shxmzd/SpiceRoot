<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BuyerController extends Controller
{
    /**
     * Get all active products (for buyers to browse)
     */
    public function products(Request $request)
    {
        try {
            $user = $request->user();
            
            // Check if user is a buyer
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access this resource.'
                ], 403);
            }

            // Get query parameters
            $category = $request->query('category');
            $search = $request->query('search');
            $sort = $request->query('sort', 'newest'); // newest, oldest, price_low, price_high
            $limit = $request->query('limit', 20);
            $page = $request->query('page', 1);

            // Build query
            $query = Product::where('status', 'active');

            // Filter by category
            if ($category) {
                $query->where('category', $category);
            }

            // Search functionality
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Sorting
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }

            // Pagination
            $offset = ($page - 1) * $limit;
            $totalProducts = $query->count();
            $products = $query->skip($offset)->take($limit)->get();

            // Transform products for API response
            $transformedProducts = $products->map(function ($product) {
                // Get seller info
                $seller = User::find($product->seller_id);
                
                return [
                    'id' => $product->_id,
                    'name' => $product->name,
                    'category' => $product->category,
                    'price' => $product->price,
                    'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                    'description' => $product->description,
                    'image' => $product->image ? Storage::url($product->image) : null,
                    'seller' => [
                        'id' => $seller ? $seller->_id : null,
                        'name' => $seller ? $seller->name : 'Unknown Seller',
                    ],
                    'created_at' => $product->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully',
                'data' => [
                    'products' => $transformedProducts,
                    'pagination' => [
                        'current_page' => (int)$page,
                        'total_pages' => ceil($totalProducts / $limit),
                        'total_products' => $totalProducts,
                        'per_page' => (int)$limit,
                        'has_next' => ($page * $limit) < $totalProducts,
                        'has_previous' => $page > 1,
                    ],
                    'filters' => [
                        'category' => $category,
                        'search' => $search,
                        'sort' => $sort,
                    ]
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
     * Get a single product details
     */
    public function productDetails(Request $request, $id)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access this resource.'
                ], 403);
            }

            $product = Product::where('_id', $id)
                             ->where('status', 'active')
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or not available'
                ], 404);
            }

            // Get seller info
            $seller = User::find($product->seller_id);

            // TODO: Add to recently viewed (you can implement this later)
            // RecentlyViewed::addProduct($user->_id, $product->_id);

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
                        'seller' => [
                            'id' => $seller ? $seller->_id : null,
                            'name' => $seller ? $seller->name : 'Unknown Seller',
                        ],
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
     * Get products by category
     */
    public function productsByCategory(Request $request, $category)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access this resource.'
                ], 403);
            }

            // Decode URL encoded category
            $category = urldecode($category);

            // Validate category
            $validCategories = [
                'Whole Spices',
                'Ground Spices', 
                'Fresh Herbs',
                'Dried Herbs',
                'Seeds',
                'Roots & Rhizomes'
            ];

            if (!in_array($category, $validCategories)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid category. Valid categories are: ' . implode(', ', $validCategories)
                ], 400);
            }

            $products = Product::where('status', 'active')
                              ->where('category', $category)
                              ->orderBy('created_at', 'desc')
                              ->get();

            // Transform products
            $transformedProducts = $products->map(function ($product) {
                $seller = User::find($product->seller_id);
                
                return [
                    'id' => $product->_id,
                    'name' => $product->name,
                    'category' => $product->category,
                    'price' => $product->price,
                    'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                    'description' => $product->description,
                    'image' => $product->image ? Storage::url($product->image) : null,
                    'seller' => [
                        'id' => $seller ? $seller->_id : null,
                        'name' => $seller ? $seller->name : 'Unknown Seller',
                    ],
                    'created_at' => $product->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => "Products in {$category} category retrieved successfully",
                'data' => [
                    'category' => $category,
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
     * Search products
     */
    public function searchProducts(Request $request)
    {
        // Add debug logging
        \Log::info('Search method called', [
            'user_id' => $request->user() ? $request->user()->_id : 'no user',
            'query_params' => $request->query()
        ]);

        try {
            $user = $request->user();
            
            \Log::info('User found', ['user_role' => $user->role]);
            
            if ($user->role !== 'buyer') {
                \Log::warning('Non-buyer trying to search', ['role' => $user->role]);
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access this resource.'
                ], 403);
            }

            // Get search query from URL parameter
            $searchQuery = $request->query('query');
            \Log::info('Search query received', ['query' => $searchQuery]);

            if (!$searchQuery || strlen(trim($searchQuery)) < 2) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query must be at least 2 characters long'
                ], 422);
            }

            $searchQuery = trim($searchQuery);
            \Log::info('Starting product search', ['trimmed_query' => $searchQuery]);

            $products = Product::where('status', 'active')
                              ->where(function($q) use ($searchQuery) {
                                  $q->where('name', 'like', "%{$searchQuery}%")
                                    ->orWhere('description', 'like', "%{$searchQuery}%")
                                    ->orWhere('category', 'like', "%{$searchQuery}%");
                              })
                              ->orderBy('created_at', 'desc')
                              ->get();

            \Log::info('Products found', ['count' => $products->count()]);

            // Transform products
            $transformedProducts = $products->map(function ($product) {
                $seller = User::find($product->seller_id);
                
                return [
                    'id' => $product->_id,
                    'name' => $product->name,
                    'category' => $product->category,
                    'price' => $product->price,
                    'formatted_price' => 'Rs. ' . number_format($product->price, 2),
                    'description' => $product->description,
                    'image' => $product->image ? Storage::url($product->image) : null,
                    'seller' => [
                        'id' => $seller ? $seller->_id : null,
                        'name' => $seller ? $seller->name : 'Unknown Seller',
                    ],
                    'created_at' => $product->created_at,
                ];
            });

            \Log::info('Products transformed successfully');

            return response()->json([
                'success' => true,
                'message' => 'Search completed successfully',
                'data' => [
                    'search_query' => $searchQuery,
                    'products' => $transformedProducts,
                    'total_results' => $products->count()
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Search error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error searching products: ' . $e->getMessage(),
                'debug_info' => config('app.debug') ? [
                    'line' => $e->getLine(),
                    'file' => $e->getFile(),
                    'trace' => $e->getTraceAsString()
                ] : null
            ], 500);
        }
    }

    /**
     * Get signature collection (categories with descriptions)
     */
    public function signatureCollection()
    {
        return response()->json([
            'success' => true,
            'message' => 'Signature collection retrieved successfully',
            'data' => [
                'signature_collection' => [
                    [
                        'name' => 'Whole Spices',
                        'image' => 'whole-spices.jpg',
                        'description' => 'Premium whole spices for authentic flavors',
                        'category' => 'Whole Spices'
                    ],
                    [
                        'name' => 'Ground Spices',
                        'image' => 'ground-spices.jpg',
                        'description' => 'Freshly ground spices for convenience',
                        'category' => 'Ground Spices'
                    ],
                    [
                        'name' => 'Fresh Herbs',
                        'image' => 'fresh-herbs.jpg',
                        'description' => 'Garden-fresh herbs for vibrant dishes',
                        'category' => 'Fresh Herbs'
                    ],
                    [
                        'name' => 'Dried Herbs',
                        'image' => 'dried-herbs.jpg',
                        'description' => 'Carefully dried herbs with concentrated flavors',
                        'category' => 'Dried Herbs'
                    ],
                    [
                        'name' => 'Seeds',
                        'image' => 'seeds.jpg',
                        'description' => 'Aromatic seeds for seasoning and garnishing',
                        'category' => 'Seeds'
                    ],
                    [
                        'name' => 'Roots & Rhizomes',
                        'image' => 'roots-rhizomes.jpg',
                        'description' => 'Traditional roots for medicinal and culinary use',
                        'category' => 'Roots & Rhizomes'
                    ]
                ]
            ]
        ]);
    }
}