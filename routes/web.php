<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

// MongoDB connection test route
Route::get('/test-mongodb', function () {
    try {
        // Test the connection by attempting to list collections
        $connection = DB::connection('mongodb');
                 
        // Try to ping the database
        $result = $connection->getMongoClient()->selectDatabase(config('database.connections.mongodb.database'))->command(['ping' => 1]);
                 
        // Get database name and connection info
        $databaseName = config('database.connections.mongodb.database');
        $host = config('database.connections.mongodb.host');
        $port = config('database.connections.mongodb.port');
                 
        return response()->json([
            'status' => 'success',
            'message' => 'MongoDB connection is working!',
            'database' => $databaseName,
            'host' => $host,
            'port' => $port,
            'ping_result' => $result->toArray()
        ], 200);
             
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'MongoDB connection failed',
            'error' => $e->getMessage(),
            'database' => config('database.connections.mongodb.database'),
            'host' => config('database.connections.mongodb.host'),
            'port' => config('database.connections.mongodb.port')
        ], 500);
    }
});

// Test email functionality (temporary - remove in production)
Route::get('/test-email', function () {
    try {
        \Illuminate\Support\Facades\Mail::raw('Test email from Laravel', function ($message) {
            $message->to('test@example.com')
                    ->subject('Test Email');
        });
        
        return response()->json([
            'status' => 'success',
            'message' => 'Email sent successfully! Check your storage/logs/laravel.log file for the email content.',
            'mail_driver' => config('mail.default'),
            'from_address' => config('mail.from.address')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error', 
            'message' => 'Email failed to send',
            'error' => $e->getMessage()
        ], 500);
    }
})->name('test.email');

// Default dashboard (fallback) - redirects to role-based dashboard
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Redirect to role-based dashboard
        return match($user->role) {
            'seller' => redirect()->route('seller.dashboard'),
            'buyer' => redirect()->route('buyer.dashboard'),
            default => view('dashboard'), // fallback view
        };
    })->name('dashboard');
});

// Role-based dashboard routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Seller dashboard
    Route::get('/seller/dashboard', \App\Livewire\Seller\Dashboard::class)
        ->middleware('check.seller')
        ->name('seller.dashboard');

    // Buyer dashboard  
    Route::get('/buyer/dashboard', \App\Livewire\Buyer\Dashboard::class)
        ->middleware('check.buyer')
        ->name('buyer.dashboard');

    // Seller-only routes
    Route::middleware([\App\Http\Middleware\CheckSeller::class])->group(function () {
        Route::get('/seller/products/add_product', \App\Livewire\Seller\AddProduct::class)->name('seller.products.add');
        Route::get('/seller/products/view_products', \App\Livewire\Seller\ViewProducts::class)->name('seller.products.view');
        Route::get('/seller/orders', \App\Livewire\Seller\Orders::class)->name('seller.orders');
        Route::get('/seller/orders/{orderId}', \App\Livewire\Seller\OrderDetails::class)->name('seller.order.details');
    });

    // Buyer routes
    Route::middleware([\App\Http\Middleware\CheckBuyer::class])->group(function () {
        Route::get('/buyer/shop', \App\Livewire\Buyer\Shop::class)->name('buyer.shop');
        Route::get('/buyer/shop/product/{id}', \App\Livewire\Buyer\ProductDetails::class)->name('buyer.product.details');
        Route::get('/buyer/cart', \App\Livewire\Buyer\Cart::class)->name('buyer.cart');
        Route::get('/buyer/wishlist', \App\Livewire\Buyer\Wishlist::class)->name('buyer.wishlist');
        Route::get('/buyer/checkout', \App\Livewire\Buyer\Checkout::class)->name('buyer.checkout');
        Route::get('/buyer/checkout/success/{order}', \App\Livewire\Buyer\CheckoutSuccess::class)->name('buyer.checkout.success');
        Route::get('/buyer/orders', \App\Livewire\Buyer\Orders::class)->name('buyer.orders');
    });
});

