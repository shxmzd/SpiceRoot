<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING BUYER-SPECIFIC ORDER METHODS ===\n\n";

// Login as a buyer for testing
$buyer = \App\Models\User::where('role', 'buyer')->first();
if (!$buyer) {
    echo "❌ No buyer found in database\n";
    exit(1);
}

echo "✓ Testing with buyer: {$buyer->name} (ID: {$buyer->_id})\n\n";

// Test 1: getBuyerStats method
echo "1. Testing Order::getBuyerStats()...\n";
try {
    $stats = Order::getBuyerStats($buyer->_id);
    echo "   ✓ Total orders: " . $stats['total_orders'] . "\n";
    echo "   ✓ Processing orders: " . $stats['processing_orders'] . "\n";
    echo "   ✓ Delivered orders: " . $stats['delivered_orders'] . "\n";
    echo "   ✓ Total spent: LKR " . number_format($stats['total_spent'], 2) . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: getBuyerOrders method
echo "\n2. Testing Order::getBuyerOrders()...\n";
try {
    $buyerOrders = Order::getBuyerOrders($buyer->_id);
    echo "   ✓ Buyer orders count: " . $buyerOrders->count() . "\n";
    
    // Test filtering
    $confirmedOrders = Order::getBuyerOrders($buyer->_id, 'confirmed');
    echo "   ✓ Confirmed orders: " . $confirmedOrders->count() . "\n";
    
    $pendingOrders = Order::getBuyerOrders($buyer->_id, 'pending');
    echo "   ✓ Pending orders: " . $pendingOrders->count() . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Order instance methods for buyers
echo "\n3. Testing buyer-specific order instance methods...\n";
$order = Order::first();
if ($order) {
    echo "   Testing with order: {$order->order_number}\n";
    
    try {
        // Test canBeCancelledByBuyer method
        if (method_exists($order, 'canBeCancelledByBuyer')) {
            $canCancel = $order->canBeCancelledByBuyer();
            echo "   ✓ Can be cancelled by buyer: " . ($canCancel ? 'Yes' : 'No') . "\n";
        } else {
            echo "   ⚠ canBeCancelledByBuyer method not found\n";
        }
        
        // Test canBeReordered method
        if (method_exists($order, 'canBeReordered')) {
            $canReorder = $order->canBeReordered();
            echo "   ✓ Can be reordered: " . ($canReorder ? 'Yes' : 'No') . "\n";
        } else {
            echo "   ⚠ canBeReordered method not found\n";
        }
        
        // Test canBeRated method
        if (method_exists($order, 'canBeRated')) {
            $canRate = $order->canBeRated();
            echo "   ✓ Can be rated: " . ($canRate ? 'Yes' : 'No') . "\n";
        } else {
            echo "   ⚠ canBeRated method not found\n";
        }
        
        // Test order status tracking for buyers
        if (method_exists($order, 'getOrderSteps')) {
            $steps = $order->getOrderSteps();
            echo "   ✓ Order steps count: " . count($steps) . "\n";
        } else {
            echo "   ⚠ getOrderSteps method not found\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ Error testing order methods: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ⚠ No orders available for testing\n";
}

echo "\n=== TESTING COMPLETE ===\n";
