<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Livewire\Buyer\Shop;
use App\Livewire\Buyer\Cart;
use App\Livewire\Buyer\Checkout;
use App\Livewire\Buyer\CheckoutSuccess;
use App\Livewire\Buyer\Orders;
use App\Livewire\Buyer\Dashboard;
use App\Livewire\Buyer\ProductDetails;
use App\Livewire\Buyer\Wishlist;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING BUYER LIVEWIRE COMPONENTS ===\n\n";

// Login as a buyer for testing
$buyer = \App\Models\User::where('role', 'buyer')->first();
if (!$buyer) {
    echo "❌ No buyer found in database\n";
    exit(1);
}

// Mock authentication
auth()->login($buyer);
echo "✓ Logged in as buyer: {$buyer->name}\n\n";

// Test 1: Shop Component
echo "1. Testing Shop Component...\n";
try {
    $shop = new Shop();
    $shop->mount();
    echo "   ✓ Shop component instantiated successfully\n";
    echo "   ✓ Categories count: " . count($shop->categories) . "\n";
    echo "   ✓ Price ranges count: " . count($shop->priceRanges) . "\n";
    echo "   ✓ Sort options count: " . count($shop->sortOptions) . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 2: Cart Component
echo "\n2. Testing Cart Component...\n";
try {
    $cart = new Cart();
    $cart->mount();
    echo "   ✓ Cart component instantiated successfully\n";
    echo "   ✓ Cart items loaded: " . count($cart->cartItems) . "\n";
    echo "   ✓ Cart summary available: " . (is_array($cart->cartSummary) ? 'Yes' : 'No') . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 3: Wishlist Component
echo "\n3. Testing Wishlist Component...\n";
try {
    $wishlist = new Wishlist();
    $wishlist->mount();
    echo "   ✓ Wishlist component instantiated successfully\n";
    echo "   ✓ Wishlist items loaded: " . count($wishlist->wishlistItems) . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 4: Dashboard Component
echo "\n4. Testing Dashboard Component...\n";
try {
    $dashboard = new Dashboard();
    $dashboard->mount();
    echo "   ✓ Dashboard component instantiated successfully\n";
    echo "   ✓ Recently viewed products: " . count($dashboard->recentlyViewedProducts) . "\n";
    echo "   ✓ Signature collection items: " . count($dashboard->signatureCollection) . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 5: Orders Component
echo "\n5. Testing Orders Component...\n";
try {
    $orders = new Orders();
    echo "   ✓ Orders component instantiated successfully\n";
    echo "   ✓ Status options count: " . count($orders->statusOptions) . "\n";
    echo "   ✓ Initial status filter: '" . $orders->statusFilter . "'\n";
    echo "   ✓ Show review modal: " . ($orders->showReviewModal ? 'Yes' : 'No') . "\n";
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 6: ProductDetails Component (if product exists)
echo "\n6. Testing ProductDetails Component...\n";
try {
    $product = Product::first();
    if ($product) {
        $productDetails = new ProductDetails();
        $productDetails->mount($product->_id);
        echo "   ✓ ProductDetails component instantiated successfully\n";
        echo "   ✓ Product loaded: {$product->name}\n";
        echo "   ✓ Product ID set: {$productDetails->productId}\n";
    } else {
        echo "   ⚠ No products available for testing\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 7: CheckoutSuccess Component (if order exists)
echo "\n7. Testing CheckoutSuccess Component...\n";
try {
    $order = Order::where('user_id', $buyer->_id)->first();
    if ($order) {
        $checkoutSuccess = new CheckoutSuccess();
        $checkoutSuccess->mount($order->order_number);
        echo "   ✓ CheckoutSuccess component instantiated successfully\n";
        echo "   ✓ Order loaded: {$order->order_number}\n";
    } else {
        echo "   ⚠ No orders available for testing CheckoutSuccess\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

// Test 8: Checkout Component (requires cart items, so we'll just test instantiation)
echo "\n8. Testing Checkout Component (instantiation only)...\n";
try {
    // Add a test item to cart first
    $product = Product::first();
    if ($product) {
        \App\Models\Cart::addToCart($buyer->_id, $product->_id, 1);
        echo "   ✓ Added test item to cart\n";
        
        $checkout = new Checkout();
        $checkout->mount();
        echo "   ✓ Checkout component instantiated successfully\n";
        echo "   ✓ Cart items for checkout: " . count($checkout->cartItems) . "\n";
        echo "   ✓ Email pre-filled: {$checkout->email}\n";
        echo "   ✓ Full name pre-filled: {$checkout->full_name}\n";
        
        // Clean up test cart item
        \App\Models\Cart::where('user_id', $buyer->_id)->delete();
        echo "   ✓ Test cart item cleaned up\n";
    } else {
        echo "   ⚠ No products available for cart testing\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== BUYER LIVEWIRE COMPONENTS TEST COMPLETE ===\n";
