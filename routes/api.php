<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\BuyerController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\SellerOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Product routes - All authenticated users can view categories
    Route::get('/products/categories', [ProductController::class, 'categories']);
    
    // Seller-specific product routes
    Route::middleware('check.seller')->group(function () {
        // Product CRUD for sellers
        Route::get('/seller/products', [ProductController::class, 'index']);          // Get seller's products
        Route::post('/seller/products', [ProductController::class, 'store']);         // Create new product
        Route::get('/seller/products/{id}', [ProductController::class, 'show']);      // Get single product
        Route::put('/seller/products/{id}', [ProductController::class, 'update']);    // Update product
        Route::delete('/seller/products/{id}', [ProductController::class, 'destroy']); // Delete product
        
        // Seller dashboard
        Route::get('/seller/stats', [ProductController::class, 'stats']);      // Get seller stats
        
        // Seller order management routes
        Route::get('/seller/orders', [SellerOrderController::class, 'index']);                     // Get seller's orders
        Route::get('/seller/orders/status-options', [SellerOrderController::class, 'statusOptions']); // Get status filter options
        Route::get('/seller/orders/new-count', [SellerOrderController::class, 'getNewOrdersCount']); // Get new orders count
        Route::get('/seller/orders/{orderNumber}', [SellerOrderController::class, 'show']);        // Get order details
        Route::post('/seller/orders/{orderNumber}/ship', [SellerOrderController::class, 'shipOrder']); // Ship order
        Route::post('/seller/orders/{orderNumber}/deliver', [SellerOrderController::class, 'deliverOrder']); // Mark as delivered
        Route::post('/seller/orders/{orderNumber}/cancel', [SellerOrderController::class, 'cancelOrder']); // Cancel order
    });

    // Buyer-specific routes
    Route::middleware('check.buyer')->group(function () {
        // Browse all products (for buyers)
        Route::get('/buyer/products', [BuyerController::class, 'products']);               // Browse all products
        Route::get('/buyer/products/{id}', [BuyerController::class, 'productDetails']);   // Get product details
        Route::get('/buyer/category/{category}', [BuyerController::class, 'productsByCategory']); // Products by category
        Route::get('/buyer/search', [BuyerController::class, 'searchProducts']);          // Search products
        Route::get('/buyer/signature-collection', [BuyerController::class, 'signatureCollection']); // Get categories info
        
        // Cart management routes
        Route::get('/buyer/cart', [CartController::class, 'index']);                      // Get cart items
        Route::post('/buyer/cart/add', [CartController::class, 'addToCart']);            // Add to cart
        Route::put('/buyer/cart/{cartItemId}', [CartController::class, 'updateQuantity']); // Update quantity
        Route::delete('/buyer/cart/{cartItemId}', [CartController::class, 'removeFromCart']); // Remove from cart
        Route::delete('/buyer/cart', [CartController::class, 'clearCart']);              // Clear entire cart
        Route::get('/buyer/cart/count', [CartController::class, 'getCartCount']);        // Get cart count
        
        // Recently viewed routes
        Route::get('/buyer/recently-viewed', [BuyerController::class, 'recentlyViewed']); // Get recently viewed products
        Route::post('/buyer/track-view', [BuyerController::class, 'trackProductView']);   // Manually track product view
        Route::delete('/buyer/recently-viewed', [BuyerController::class, 'clearRecentlyViewed']); // Clear all recently viewed
        Route::delete('/buyer/recently-viewed/{productId}', [BuyerController::class, 'removeFromRecentlyViewed']); // Remove specific product
        
        // Order management routes
        Route::get('/buyer/orders', [OrderController::class, 'index']);                  // Get buyer's orders
        Route::get('/buyer/orders/status-options', [OrderController::class, 'statusOptions']); // Get status filter options (MOVED UP)
        Route::get('/buyer/orders/new-count', [OrderController::class, 'getNewOrdersCount']); // Get new orders count (MOVED UP)
        Route::get('/buyer/orders-stats', [OrderController::class, 'stats']);            // Get order statistics
        Route::get('/buyer/orders/{orderNumber}', [OrderController::class, 'show']);     // Get order details
        Route::post('/buyer/orders/{orderNumber}/cancel', [OrderController::class, 'cancel']); // Cancel order
        Route::post('/buyer/orders/{orderNumber}/reorder', [OrderController::class, 'reorder']); // Reorder
    });
    
    // Test protected route
    Route::get('/test', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Protected route accessed successfully',
            'user' => [
                'id' => $request->user()->_id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
            ]
        ]);
    });
    
    // Debug routes - remove in production
    Route::get('/debug/buyer-check', function (Request $request) {
        $user = $request->user();
        return response()->json([
            'success' => true,
            'user_role' => $user->role,
            'is_buyer' => $user->isBuyer(),
            'message' => 'Buyer middleware working'
        ]);
    })->middleware('check.buyer');
    
    // Test search without middleware
    Route::get('/debug/search-no-middleware', function (Request $request) {
        try {
            $query = $request->query('query', 'test');
            
            $products = \App\Models\Product::where('status', 'active')
                                          ->where('name', 'like', "%{$query}%")
                                          ->get();
            
            return response()->json([
                'success' => true,
                'search_query' => $query,
                'products_count' => $products->count(),
                'products' => $products->take(3)->map(function($p) {
                    return [
                        'id' => $p->_id,
                        'name' => $p->name,
                        'category' => $p->category
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    });
    
    // Super simple search test
    Route::get('/test-search', function (Request $request) {
        try {
            $query = $request->query('query', 'test');
            
            return response()->json([
                'success' => true,
                'message' => 'Simple search test',
                'search_query' => $query,
                'user_role' => $request->user()->role,
                'timestamp' => now()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    });
});