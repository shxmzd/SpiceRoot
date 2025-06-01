<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;
use App\Models\Product;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEBUGGING SELLER ORDER MISMATCH ===\n\n";

// Get all orders and examine their items
$orders = Order::all();
echo "Total orders: " . $orders->count() . "\n\n";

foreach ($orders as $order) {
    echo "Order: {$order->order_number} (Status: {$order->status})\n";
    echo "Items:\n";
    
    foreach ($order->items as $index => $item) {
        echo "  Item {$index}:\n";
        echo "    Product ID: " . ($item['product_id'] ?? 'N/A') . "\n";
        echo "    Product Name: " . ($item['product_name'] ?? 'N/A') . "\n";
        echo "    Seller ID: " . ($item['seller_id'] ?? 'N/A') . "\n";
        echo "    Seller Name: " . ($item['seller_name'] ?? 'N/A') . "\n";
        echo "    Quantity: " . ($item['quantity'] ?? 'N/A') . "\n";
        echo "    Price: " . ($item['price'] ?? 'N/A') . "\n";
    }
    echo "\n";
}

echo "=== SELLERS IN DATABASE ===\n";
$sellers = User::where('role', 'seller')->get();
foreach ($sellers as $seller) {
    echo "Seller: {$seller->name} (ID: {$seller->_id})\n";
}

echo "\n=== PRODUCTS IN DATABASE ===\n";
$products = Product::all();
foreach ($products as $product) {
    echo "Product: {$product->name} (Seller ID: {$product->seller_id})\n";
}

echo "\n=== CROSS-CHECKING SELLER IDs ===\n";
foreach ($orders as $order) {
    foreach ($order->items as $item) {
        if (isset($item['seller_id'])) {
            $sellerId = trim($item['seller_id']);
            $seller = User::where('_id', $sellerId)->first();
            if ($seller) {
                echo "✓ Seller ID {$sellerId} matches user: {$seller->name}\n";
            } else {
                echo "✗ Seller ID {$sellerId} NOT FOUND in users table\n";
            }
        }
    }
}
