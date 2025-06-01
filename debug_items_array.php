<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Debugging items array structure and queries...\n";

// Get an order and examine the exact structure
$order = \App\Models\Order::first();
echo "Order ID: " . $order->_id . "\n";
echo "Order items structure:\n";

// Convert to array to see the exact structure
$orderArray = $order->toArray();
echo "Items as array: " . json_encode($orderArray['items'], JSON_PRETTY_PRINT) . "\n";

echo "\nTesting different array query approaches...\n";

$sellerId = '683413ca505b644966084ec3';

// Test 1: Direct array position query
echo "1. Query by array position (items.0.seller_id):\n";
$result1 = \App\Models\Order::where('items.0.seller_id', $sellerId)->count();
echo "   Result: $result1 orders\n";

// Test 2: Let's see if we can query items array at all
echo "2. Check if items array exists:\n";
$result2 = \App\Models\Order::whereNotNull('items')->count();
echo "   Result: $result2 orders\n";

// Test 3: Check if items is not empty
echo "3. Check items array is not empty:\n";
$result3 = \App\Models\Order::where('items', '!=', [])->count();
echo "   Result: $result3 orders\n";

// Test 4: Size of items array
echo "4. Check items array size > 0:\n";
try {
    $result4 = \App\Models\Order::where('items', 'size', 1)->count();
    echo "   Result: $result4 orders\n";
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

// Test 5: Let's try a completely different approach - iterate through orders manually
echo "5. Manual iteration check:\n";
$manualCount = 0;
$orders = \App\Models\Order::all();
foreach ($orders as $order) {
    foreach ($order->items as $item) {
        if (isset($item['seller_id']) && $item['seller_id'] === $sellerId) {
            $manualCount++;
            break; // Only count each order once
        }
    }
}
echo "   Manual count: $manualCount orders\n";

// Test 6: Let's also check what happens if we rebuild the query step by step
echo "6. Step by step query building:\n";
$builder = \App\Models\Order::query();
echo "   Base query count: " . $builder->count() . "\n";

$builder2 = \App\Models\Order::whereNotNull('items');
echo "   With whereNotNull('items'): " . $builder2->count() . "\n";

$builder3 = \App\Models\Order::where('items.seller_id', $sellerId);
echo "   With where('items.seller_id', \$sellerId): " . $builder3->count() . "\n";
