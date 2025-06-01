<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING SELLER FUNCTIONALITY WITH CORRECT SELLER ===\n\n";

// Test with seller 'nasla' who actually has orders
$sellerId = '683413ca505b644966084ec3';
$seller = User::where('_id', $sellerId)->first();

if ($seller) {
    echo "Testing seller: {$seller->name} (ID: {$seller->_id})\n\n";
    
    // Test seller order methods
    echo "1. Testing getSellerOrders()...\n";
    $sellerOrders = Order::getSellerOrders($sellerId);
    echo "   ✓ Seller orders count: " . $sellerOrders->count() . "\n";
    
    foreach ($sellerOrders as $index => $order) {
        echo "   Order " . ($index + 1) . ": {$order->order_number} (Status: {$order->status})\n";
    }
    
    echo "\n2. Testing getNewOrdersCount()...\n";
    $newOrdersCount = Order::getNewOrdersCount($sellerId);
    echo "   ✓ New orders for seller: {$newOrdersCount}\n";
    
    echo "\n3. Testing individual order methods...\n";
    if ($sellerOrders->isNotEmpty()) {
        $order = $sellerOrders->first();
        echo "   Testing with order: {$order->order_number}\n";
        
        $sellerItems = $order->getSellerItems($sellerId);
        echo "   ✓ Seller items count: " . $sellerItems->count() . "\n";
        
        $sellerTotal = $order->getSellerTotal($sellerId);
        echo "   ✓ Seller total: LKR {$sellerTotal}\n";
        
        echo "   ✓ Can be cancelled: " . ($order->canBeCancelledBySeller($sellerId) ? 'Yes' : 'No') . "\n";
        echo "   ✓ Can be shipped: " . ($order->canBeShippedBySeller($sellerId) ? 'Yes' : 'No') . "\n";
        echo "   ✓ Can be delivered: " . ($order->canBeDeliveredBySeller($sellerId) ? 'Yes' : 'No') . "\n";
        
        // Test item details
        echo "\n   Item details:\n";
        foreach ($sellerItems as $item) {
            echo "     - Product: {$item['product_name']}\n";
            echo "       Quantity: {$item['quantity']}\n";
            echo "       Price: LKR {$item['price']}\n";
            echo "       Subtotal: LKR {$item['subtotal']}\n";
        }
    }
    
    echo "\n4. Testing filtering options...\n";
    
    // Test status filtering
    $confirmedOrders = Order::getSellerOrders($sellerId, 'confirmed');
    echo "   ✓ Confirmed orders: " . $confirmedOrders->count() . "\n";
    
    $pendingOrders = Order::getSellerOrders($sellerId, 'pending');
    echo "   ✓ Pending orders: " . $pendingOrders->count() . "\n";
    
    // Test search functionality
    $searchOrders = Order::getSellerOrders($sellerId, null, 'ORD-6835A9B27DF2F');
    echo "   ✓ Search results for 'ORD-6835A9B27DF2F': " . $searchOrders->count() . "\n";
    
} else {
    echo "✗ Seller not found!\n";
}

echo "\n=== SELLER FUNCTIONALITY TEST COMPLETE ===\n";
