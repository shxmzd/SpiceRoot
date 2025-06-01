<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Http\Middleware\CheckSeller;
use Illuminate\Http\Request;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING SELLER AUTHENTICATION & MIDDLEWARE ===\n\n";

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

// Test 2: CheckSeller middleware
echo "2. Testing CheckSeller middleware...\n";
try {
    $middleware = new CheckSeller();
    echo "   ✓ CheckSeller middleware instantiated successfully\n";
    
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
if (isset($routeMiddleware['CheckSeller'])) {
    echo "   ✓ CheckSeller middleware is registered in app config\n";
} else {
    echo "   ⚠ CheckSeller middleware not found in app aliases\n";
}

// Test 4: Seller count and statistics
echo "\n4. Testing seller statistics...\n";
$sellerCount = User::where('role', 'seller')->count();
$buyerCount = User::where('role', 'buyer')->count();
$adminCount = User::where('role', 'admin')->count();

echo "   Total sellers: {$sellerCount}\n";
echo "   Total buyers: {$buyerCount}\n";
echo "   Total admins: {$adminCount}\n";

// Test 5: Seller with products and orders
echo "\n5. Testing seller business data...\n";
$sellers = User::where('role', 'seller')->get();
foreach ($sellers as $seller) {
    $productCount = \App\Models\Product::where('seller_id', $seller->_id)->count();
    $orderCount = \App\Models\Order::getSellerOrders($seller->_id)->count();
    $newOrderCount = \App\Models\Order::getNewOrdersCount($seller->_id);
    
    echo "   Seller: {$seller->name}\n";
    echo "     Products: {$productCount}\n";
    echo "     Total Orders: {$orderCount}\n";
    echo "     New Orders: {$newOrderCount}\n";
    echo "\n";
}

echo "=== SELLER AUTHENTICATION & MIDDLEWARE TESTING COMPLETE ===\n";
