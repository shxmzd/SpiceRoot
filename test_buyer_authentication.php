<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Http\Middleware\CheckBuyer;
use Illuminate\Http\Request;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING BUYER AUTHENTICATION & MIDDLEWARE ===\n\n";

// Test 1: User role validation
echo "1. Testing User role validation methods...\n";
$users = User::take(5)->get();
foreach ($users as $user) {
    echo "   User: {$user->name}\n";
    echo "     Role: {$user->role}\n";
    echo "     isSeller(): " . ($user->isSeller() ? 'true' : 'false') . "\n";
    echo "     isBuyer(): " . ($user->isBuyer() ? 'true' : 'false') . "\n";
    echo "     isAdmin(): " . ($user->isAdmin() ? 'true' : 'false') . "\n";
    echo "\n";
}

// Test 2: CheckBuyer middleware
echo "2. Testing CheckBuyer middleware...\n";
try {
    $middleware = new CheckBuyer();
    echo "   ✓ CheckBuyer middleware instantiated successfully\n";
    
    // Check if handle method exists
    if (method_exists($middleware, 'handle')) {
        echo "   ✓ Middleware has handle() method\n";
    } else {
        echo "   ✗ Middleware missing handle() method\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Route middleware registration
echo "\n3. Testing route middleware registration...\n";
$routeMiddleware = config('app.aliases');
if (isset($routeMiddleware['CheckBuyer'])) {
    echo "   ✓ CheckBuyer middleware is registered in app config\n";
} else {
    echo "   ⚠ CheckBuyer middleware not found in app aliases\n";
}

// Test 4: Buyer count and statistics
echo "\n4. Testing buyer statistics...\n";
$sellerCount = User::where('role', 'seller')->count();
$buyerCount = User::where('role', 'buyer')->count();
$adminCount = User::where('role', 'admin')->count();

echo "   Total buyers: {$buyerCount}\n";
echo "   Total sellers: {$sellerCount}\n";
echo "   Total admins: {$adminCount}\n";

// Test 5: Buyer with orders and cart data
echo "\n5. Testing buyer business data...\n";
$buyers = User::where('role', 'buyer')->get();
foreach ($buyers as $buyer) {
    $orderCount = \App\Models\Order::where('user_id', $buyer->_id)->count();
    $cartCount = \App\Models\Cart::where('user_id', $buyer->_id)->count();
    $wishlistCount = \App\Models\Wishlist::where('user_id', $buyer->_id)->count();
    $reviewCount = \App\Models\Review::where('user_id', $buyer->_id)->count();
    
    echo "   Buyer: {$buyer->name}\n";
    echo "     Orders: {$orderCount}\n";
    echo "     Cart Items: {$cartCount}\n";
    echo "     Wishlist Items: {$wishlistCount}\n";
    echo "     Reviews: {$reviewCount}\n";
    echo "\n";
}

// Test 6: Buyer role permissions
echo "6. Testing buyer role permissions...\n";
$buyer = User::where('role', 'buyer')->first();
if ($buyer) {
    echo "   Testing with buyer: {$buyer->name}\n";
    
    // Test role checking methods
    echo "   ✓ hasRole('buyer'): " . ($buyer->hasRole('buyer') ? 'true' : 'false') . "\n";
    echo "   ✓ hasRole('seller'): " . ($buyer->hasRole('seller') ? 'true' : 'false') . "\n";
    echo "   ✓ hasAnyRole(['buyer', 'admin']): " . ($buyer->hasAnyRole(['buyer', 'admin']) ? 'true' : 'false') . "\n";
    echo "   ✓ hasAnyRole(['seller', 'admin']): " . ($buyer->hasAnyRole(['seller', 'admin']) ? 'true' : 'false') . "\n";
} else {
    echo "   ⚠ No buyer found for role testing\n";
}

// Test 7: User constants and available roles
echo "\n7. Testing User role constants...\n";
echo "   Available roles: " . implode(', ', User::getRoles()) . "\n";
echo "   ROLE_BUYER constant: " . User::ROLE_BUYER . "\n";
echo "   ROLE_SELLER constant: " . User::ROLE_SELLER . "\n";
echo "   ROLE_ADMIN constant: " . User::ROLE_ADMIN . "\n";

// Test 8: Buyer shopping activity
echo "\n8. Testing buyer shopping activity...\n";
$buyers = User::where('role', 'buyer')->take(3)->get();
foreach ($buyers as $buyer) {
    $recentlyViewedCount = \App\Models\RecentlyViewed::where('user_id', $buyer->_id)->count();
    $totalSpent = \App\Models\Order::where('user_id', $buyer->_id)
                                   ->where('status', 'delivered')
                                   ->sum('total_amount');
    
    echo "   Buyer: {$buyer->name}\n";
    echo "     Recently viewed products: {$recentlyViewedCount}\n";
    echo "     Total spent: LKR " . number_format($totalSpent, 2) . "\n";
}

echo "\n=== BUYER AUTHENTICATION & MIDDLEWARE TESTING COMPLETE ===\n";
