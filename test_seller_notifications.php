<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\SellerNotification;
use App\Models\User;
use App\Models\Order;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING SELLER NOTIFICATION SYSTEM ===\n\n";

// Test 1: Check current notifications
echo "1. Testing current notifications...\n";
$totalNotifications = SellerNotification::count();
echo "   Total notifications in database: {$totalNotifications}\n";

// Test 2: Test notification methods for each seller
echo "\n2. Testing notification methods for sellers...\n";
$sellers = User::where('role', 'seller')->get();
foreach ($sellers as $seller) {
    echo "   Seller: {$seller->name} (ID: {$seller->_id})\n";
    
    $unreadCount = SellerNotification::unreadCount($seller->_id);
    echo "     Unread notifications: {$unreadCount}\n";
    
    $recentNotifications = SellerNotification::recent($seller->_id, 3);
    echo "     Recent notifications count: " . $recentNotifications->count() . "\n";
    
    foreach ($recentNotifications as $notification) {
        echo "       - {$notification->message} (Read: " . ($notification->is_read ? 'Yes' : 'No') . ")\n";
    }
    echo "\n";
}

// Test 3: Test notification creation for existing order
echo "3. Testing notification creation...\n";
$order = Order::first();
if ($order) {
    echo "   Using order: {$order->order_number}\n";
    
    // Count notifications before
    $beforeCount = SellerNotification::count();
    echo "   Notifications before: {$beforeCount}\n";
    
    try {
        // Create notification for this order
        SellerNotification::notifyNewOrder($order);
        
        // Count notifications after
        $afterCount = SellerNotification::count();
        echo "   Notifications after: {$afterCount}\n";
        echo "   New notifications created: " . ($afterCount - $beforeCount) . "\n";
        
        // Show the new notification
        $newNotification = SellerNotification::where('order_id', $order->_id)->latest()->first();
        if ($newNotification) {
            echo "   New notification message: {$newNotification->message}\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ Error creating notification: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ⚠ No orders found to test with\n";
}

// Test 4: Test marking notification as read
echo "\n4. Testing mark as read functionality...\n";
$unreadNotification = SellerNotification::where('is_read', false)->first();
if ($unreadNotification) {
    echo "   Found unread notification: {$unreadNotification->message}\n";
    echo "   Read status before: " . ($unreadNotification->is_read ? 'true' : 'false') . "\n";
    
    $unreadNotification->markAsRead();
    $unreadNotification->refresh();
    
    echo "   Read status after: " . ($unreadNotification->is_read ? 'true' : 'false') . "\n";
} else {
    echo "   ⚠ No unread notifications found to test with\n";
}

echo "\n=== SELLER NOTIFICATION SYSTEM TESTING COMPLETE ===\n";
