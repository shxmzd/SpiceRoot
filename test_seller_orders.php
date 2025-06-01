<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing seller orders functionality...\n";

// Get all orders to see the structure
$orders = \App\Models\Order::all();
echo "Total orders: " . $orders->count() . "\n";

foreach ($orders as $order) {
    echo "\nOrder: " . $order->order_number . " - Status: " . $order->status . "\n";
    echo "Items count: " . count($order->items) . "\n";
    
    foreach ($order->items as $index => $item) {
        echo "  - " . $item['product_name'] . " (Seller ID: " . $item['seller_id'] . ")\n";
        echo "    Seller ID type: " . gettype($item['seller_id']) . "\n";
        echo "    Raw item data: " . json_encode($item) . "\n";
        if (is_object($item['seller_id'])) {
            echo "    Seller ID class: " . get_class($item['seller_id']) . "\n";
            echo "    Seller ID string: " . (string)$item['seller_id'] . "\n";
        }
    }
}

// Test getting seller-specific orders
echo "\n--- Testing Seller Query ---\n";
$testSellerId = null;
if (!empty($orders)) {
    $firstOrder = $orders->first();
    if (!empty($firstOrder->items)) {
        $testSellerId = $firstOrder->items[0]['seller_id'];
        echo "Testing with seller ID: " . $testSellerId . "\n";        // Clean the seller ID and test again
        $cleanSellerId = trim($testSellerId);
        echo "Clean seller ID: '" . $cleanSellerId . "'\n";
        echo "Original seller ID: '" . $testSellerId . "'\n";
        echo "Are they equal? " . ($cleanSellerId === $testSellerId ? 'Yes' : 'No') . "\n";
        
        echo "Testing elemMatch query with clean ID...\n";
        $sellerOrders1 = \App\Models\Order::where('items', 'elemMatch', ['seller_id' => $cleanSellerId])->get();
        echo "elemMatch result: " . $sellerOrders1->count() . " orders\n";
        
        echo "Testing whereRaw with \$elemMatch and clean ID...\n";
        $sellerOrders5 = \App\Models\Order::whereRaw(['items' => ['$elemMatch' => ['seller_id' => $cleanSellerId]]])->get();
        echo "whereRaw \$elemMatch result: " . $sellerOrders5->count() . " orders\n";
    }
}

echo "\nDone.\n";
