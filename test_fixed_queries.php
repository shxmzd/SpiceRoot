<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing fixed seller order queries...\n";

$sellerId = '683413ca505b644966084ec3';

// Test the new getSellerOrders method
echo "Testing getSellerOrders method...\n";
$sellerOrders = \App\Models\Order::getSellerOrders($sellerId);
echo "Result: " . $sellerOrders->count() . " orders found\n";

// Test getNewOrdersCount method  
echo "\nTesting getNewOrdersCount method...\n";
$newOrdersCount = \App\Models\Order::getNewOrdersCount($sellerId);
echo "Result: $newOrdersCount new orders\n";

// Test with status filter
echo "\nTesting with status filter (confirmed)...\n";
$confirmedOrders = \App\Models\Order::getSellerOrders($sellerId, 'confirmed');
echo "Result: " . $confirmedOrders->count() . " confirmed orders\n";

// Display details of found orders
if ($sellerOrders->count() > 0) {
    echo "\nOrder details:\n";
    foreach ($sellerOrders as $order) {
        echo "- Order: " . $order->order_number . " (Status: " . $order->status . ")\n";
        foreach ($order->items as $item) {
            if (isset($item['seller_id']) && trim($item['seller_id']) === trim($sellerId)) {
                echo "  * " . $item['product_name'] . " (Qty: " . $item['quantity'] . ")\n";
            }
        }
    }
}

echo "\nTesting completed successfully!\n";
