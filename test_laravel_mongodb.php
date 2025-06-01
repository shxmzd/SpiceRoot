<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing Laravel MongoDB specific syntax...\n";

$sellerId = '683413ca505b644966084ec3';

// Test different Laravel MongoDB query syntaxes
echo "Testing various MongoDB query syntaxes for Laravel...\n";

// Test 1: Standard where with array syntax
echo "1. where('items.seller_id', \$sellerId):\n";
$result1 = \App\Models\Order::where('items.seller_id', $sellerId)->count();
echo "   Result: $result1 orders\n";

// Test 2: elemMatch with string keys
echo "2. where('items', 'elemMatch', ['seller_id' => \$sellerId]):\n";
$result2 = \App\Models\Order::where('items', 'elemMatch', ['seller_id' => $sellerId])->count();
echo "   Result: $result2 orders\n";

// Test 3: whereHas might not work but let's see
echo "3. whereJsonContains (if supported):\n";
try {
    $result3 = \App\Models\Order::whereJsonContains('items', ['seller_id' => $sellerId])->count();
    echo "   Result: $result3 orders\n";
} catch (Exception $e) {
    echo "   Error: " . $e->getMessage() . "\n";
}

// Test 4: Raw where with MongoDB operators
echo "4. where('items.seller_id', 'exists', true):\n";
$result4 = \App\Models\Order::where('items.seller_id', 'exists', true)->count();
echo "   Result: $result4 orders\n";

// Test 5: Let's see if the problem is with the field name
echo "5. Check all distinct seller_ids in items:\n";
$orders = \App\Models\Order::all();
$sellerIds = [];
foreach ($orders as $order) {
    foreach ($order->items as $item) {
        if (isset($item['seller_id'])) {
            $sellerIds[] = "'" . $item['seller_id'] . "'";
        }
    }
}
echo "   Found seller_ids: " . implode(', ', array_unique($sellerIds)) . "\n";

// Test 6: Check if any orders exist at all
echo "6. Total orders count: " . \App\Models\Order::count() . "\n";

// Test 7: Let's try a simple query to see if basic MongoDB queries work
echo "7. Test basic query - orders with status 'confirmed':\n";
$result7 = \App\Models\Order::where('status', 'confirmed')->count();
echo "   Result: $result7 orders\n";
