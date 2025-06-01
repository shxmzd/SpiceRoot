<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Examining seller_id data format...\n";

// Get first order
$order = \App\Models\Order::first();
if ($order) {
    echo "Order: " . $order->order_number . "\n";
    
    foreach ($order->items as $index => $item) {
        echo "\nItem $index:\n";
        echo "  seller_id: " . var_export($item['seller_id'], true) . "\n";
        echo "  seller_id length: " . strlen($item['seller_id']) . "\n";
        echo "  seller_id bytes: ";
        for ($i = 0; $i < strlen($item['seller_id']); $i++) {
            echo ord($item['seller_id'][$i]) . " ";
        }
        echo "\n";
        echo "  Expected: 683413ca505b644966084ec3\n";
        echo "  Length should be: " . strlen('683413ca505b644966084ec3') . "\n";
        
        // Test exact match
        if ($item['seller_id'] === '683413ca505b644966084ec3') {
            echo "  EXACT MATCH: YES\n";
        } else {
            echo "  EXACT MATCH: NO\n";
        }
        
        // Try query with this exact value
        echo "  Testing query with this exact seller_id...\n";
        $results = \App\Models\Order::where('items', 'elemMatch', ['seller_id' => $item['seller_id']])->count();
        echo "  Query result: $results orders\n";
    }
}
