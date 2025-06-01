<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;
use App\Models\Product;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING SELLER FUNCTIONALITY ===\n\n";

// Test 1: Order model basic functionality
echo "1. Testing Order model...\n";
try {
    $orderCount = Order::count();
    echo "   ✓ Order count: {$orderCount}\n";
    
    if ($orderCount > 0) {
        $firstOrder = Order::first();
        echo "   ✓ First order ID: {$firstOrder->_id}\n";
        echo "   ✓ Order status: {$firstOrder->status}\n";
        echo "   ✓ Order items count: " . count($firstOrder->items) . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n2. Testing User model seller methods...\n";
try {
    $users = User::take(3)->get();
    foreach ($users as $user) {
        echo "   User {$user->name}: ";
        echo "Seller=" . ($user->isSeller() ? 'Yes' : 'No') . ", ";
        echo "Buyer=" . ($user->isBuyer() ? 'Yes' : 'No') . ", ";
        echo "Admin=" . ($user->isAdmin() ? 'Yes' : 'No') . "\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n3. Testing Product model...\n";
try {
    $productCount = Product::count();
    echo "   ✓ Product count: {$productCount}\n";
    
    if ($productCount > 0) {
        $firstProduct = Product::first();
        echo "   ✓ First product: {$firstProduct->name}\n";
        echo "   ✓ Product seller_id: {$firstProduct->seller_id}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n4. Testing seller order functionality...\n";
try {
    // Find a seller
    $seller = User::where('role', 'seller')->first();
    if ($seller) {
        echo "   ✓ Found seller: {$seller->name} (ID: {$seller->_id})\n";
        
        // Test seller order methods
        $sellerOrders = Order::getSellerOrders($seller->_id);
        echo "   ✓ Seller orders count: " . $sellerOrders->count() . "\n";
        
        $newOrdersCount = Order::getNewOrdersCount($seller->_id);
        echo "   ✓ New orders for seller: {$newOrdersCount}\n";
        
        // Test order methods for seller
        if ($sellerOrders->isNotEmpty()) {
            $order = $sellerOrders->first();
            $sellerItems = $order->getSellerItems($seller->_id);
            $sellerTotal = $order->getSellerTotal($seller->_id);
            echo "   ✓ Seller items in first order: " . $sellerItems->count() . "\n";
            echo "   ✓ Seller total for first order: LKR {$sellerTotal}\n";
            
            echo "   ✓ Can be cancelled: " . ($order->canBeCancelledBySeller($seller->_id) ? 'Yes' : 'No') . "\n";
            echo "   ✓ Can be shipped: " . ($order->canBeShippedBySeller($seller->_id) ? 'Yes' : 'No') . "\n";
            echo "   ✓ Can be delivered: " . ($order->canBeDeliveredBySeller($seller->_id) ? 'Yes' : 'No') . "\n";
        }
    } else {
        echo "   ⚠ No seller found in database\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== SELLER FUNCTIONALITY TEST COMPLETE ===\n";
