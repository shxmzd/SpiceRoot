<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Fixing corrupted seller_id data in orders...\n";

// Get all orders
$orders = \App\Models\Order::all();
echo "Found " . $orders->count() . " orders to check\n";

$fixedCount = 0;

foreach ($orders as $order) {
    $hasCorruption = false;
    $cleanedItems = [];
    
    foreach ($order->items as $item) {
        $cleanedItem = $item;
        
        // Clean seller_id if it contains newlines or whitespace
        if (isset($item['seller_id'])) {
            $cleanedSellerId = trim($item['seller_id']);
            if ($cleanedSellerId !== $item['seller_id']) {
                echo "Fixing seller_id in order " . $order->order_number . ": '" . $item['seller_id'] . "' -> '" . $cleanedSellerId . "'\n";
                $cleanedItem['seller_id'] = $cleanedSellerId;
                $hasCorruption = true;
            }
        }
        
        // Clean other string fields too
        if (isset($item['seller_name'])) {
            $cleanedSellerName = trim($item['seller_name']);
            if ($cleanedSellerName !== $item['seller_name']) {
                echo "Fixing seller_name in order " . $order->order_number . ": '" . $item['seller_name'] . "' -> '" . $cleanedSellerName . "'\n";
                $cleanedItem['seller_name'] = $cleanedSellerName;
                $hasCorruption = true;
            }
        }
        
        if (isset($item['product_name'])) {
            $cleanedProductName = trim($item['product_name']);
            if ($cleanedProductName !== $item['product_name']) {
                echo "Fixing product_name in order " . $order->order_number . ": '" . $item['product_name'] . "' -> '" . $cleanedProductName . "'\n";
                $cleanedItem['product_name'] = $cleanedProductName;
                $hasCorruption = true;
            }
        }
        
        $cleanedItems[] = $cleanedItem;
    }
    
    // Update the order if we found corruption
    if ($hasCorruption) {
        $order->update(['items' => $cleanedItems]);
        $fixedCount++;
        echo "Updated order " . $order->order_number . "\n";
    }
}

echo "Fixed $fixedCount orders with corrupted data\n";
echo "Done!\n";
