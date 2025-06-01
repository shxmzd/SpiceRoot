<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing different MongoDB query approaches...\n";

$sellerId = '683413ca505b644966084ec3';

// Test 1: Direct MongoDB connection
echo "Test 1: Using raw MongoDB connection...\n";
try {
    $collection = \App\Models\Order::getCollection();
    $result = $collection->find(['items' => ['$elemMatch' => ['seller_id' => $sellerId]]]);
    $count = 0;
    foreach ($result as $doc) {
        $count++;
    }
    echo "Raw MongoDB result: $count orders\n";
} catch (Exception $e) {
    echo "Raw MongoDB error: " . $e->getMessage() . "\n";
}

// Test 2: Laravel MongoDB with different syntax
echo "\nTest 2: Using Laravel MongoDB with different syntax...\n";

// Try whereIn
echo "whereIn test...\n";
$result2 = \App\Models\Order::whereIn('items.seller_id', [$sellerId])->count();
echo "whereIn result: $result2 orders\n";

// Try aggregation
echo "aggregation test...\n";
try {
    $result3 = \App\Models\Order::raw(function($collection) use ($sellerId) {
        return $collection->aggregate([
            ['$match' => ['items.seller_id' => $sellerId]]
        ]);
    });
    echo "aggregation result: " . count($result3->toArray()) . " orders\n";
} catch (Exception $e) {
    echo "aggregation error: " . $e->getMessage() . "\n";
}

// Test 3: Check what the actual stored values look like in MongoDB
echo "\nTest 3: Raw document inspection...\n";
$order = \App\Models\Order::first();
if ($order) {
    echo "Raw MongoDB document structure:\n";
    $rawDoc = $order->getRawAttributes();
    echo "Items structure: " . json_encode($rawDoc['items'] ?? 'not found', JSON_PRETTY_PRINT) . "\n";
}
