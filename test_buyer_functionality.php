<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\RecentlyViewed;
use App\Models\Review;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING BUYER FUNCTIONALITY ===\n\n";

// Test 1: Cart model functionality
echo "1. Testing Cart model...\n";
try {
    $cartCount = Cart::count();
    echo "   ✓ Cart entries count: {$cartCount}\n";
    
    if ($cartCount > 0) {
        $firstCart = Cart::first();
        echo "   ✓ First cart entry user_id: {$firstCart->user_id}\n";
        echo "   ✓ First cart entry product_id: {$firstCart->product_id}\n";
        echo "   ✓ First cart entry quantity: {$firstCart->quantity}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n2. Testing Wishlist model...\n";
try {
    $wishlistCount = Wishlist::count();
    echo "   ✓ Wishlist entries count: {$wishlistCount}\n";
    
    if ($wishlistCount > 0) {
        $firstWishlist = Wishlist::first();
        echo "   ✓ First wishlist entry user_id: {$firstWishlist->user_id}\n";
        echo "   ✓ First wishlist entry product_id: {$firstWishlist->product_id}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n3. Testing RecentlyViewed model...\n";
try {
    $recentlyViewedCount = RecentlyViewed::count();
    echo "   ✓ Recently viewed entries count: {$recentlyViewedCount}\n";
    
    if ($recentlyViewedCount > 0) {
        $firstRecentlyViewed = RecentlyViewed::first();
        echo "   ✓ First recently viewed user_id: {$firstRecentlyViewed->user_id}\n";
        echo "   ✓ First recently viewed product_id: {$firstRecentlyViewed->product_id}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n4. Testing Review model...\n";
try {
    $reviewCount = Review::count();
    echo "   ✓ Review count: {$reviewCount}\n";
    
    if ($reviewCount > 0) {
        $firstReview = Review::first();
        echo "   ✓ First review user_id: {$firstReview->user_id}\n";
        echo "   ✓ First review product_id: {$firstReview->product_id}\n";
        echo "   ✓ First review rating: {$firstReview->rating}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n5. Testing buyer user methods...\n";
try {
    $buyer = User::where('role', 'buyer')->first();
    if ($buyer) {
        echo "   ✓ Found buyer: {$buyer->name} (ID: {$buyer->_id})\n";
        echo "   ✓ Is buyer: " . ($buyer->isBuyer() ? 'Yes' : 'No') . "\n";
        echo "   ✓ Is seller: " . ($buyer->isSeller() ? 'Yes' : 'No') . "\n";
        echo "   ✓ Is admin: " . ($buyer->isAdmin() ? 'Yes' : 'No') . "\n";
    } else {
        echo "   ⚠ No buyer found in database\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n6. Testing buyer order functionality...\n";
try {
    $buyer = User::where('role', 'buyer')->first();
    if ($buyer) {
        // Test buyer order methods
        $buyerOrders = Order::where('user_id', $buyer->_id)->get();
        echo "   ✓ Buyer orders count: " . $buyerOrders->count() . "\n";
        
        if ($buyerOrders->isNotEmpty()) {
            $order = $buyerOrders->first();
            echo "   ✓ First order ID: {$order->_id}\n";
            echo "   ✓ Order status: {$order->status}\n";
            echo "   ✓ Order total: LKR {$order->total_amount}\n";
            echo "   ✓ Order items count: " . count($order->items) . "\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n7. Testing buyer cart functionality...\n";
try {
    $buyer = User::where('role', 'buyer')->first();
    if ($buyer) {
        $cartItems = Cart::where('user_id', $buyer->_id)->get();
        echo "   ✓ Cart items for buyer: " . $cartItems->count() . "\n";
        
        if ($cartItems->isNotEmpty()) {
            $totalValue = 0;
            foreach ($cartItems as $item) {
                echo "   ✓ Cart item: Product {$item->product_id}, Qty: {$item->quantity}\n";
                $product = Product::find($item->product_id);
                if ($product) {
                    $totalValue += $product->price * $item->quantity;
                }
            }
            echo "   ✓ Cart total value: LKR {$totalValue}\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n8. Testing buyer wishlist functionality...\n";
try {
    $buyer = User::where('role', 'buyer')->first();
    if ($buyer) {
        $wishlistItems = Wishlist::where('user_id', $buyer->_id)->get();
        echo "   ✓ Wishlist items for buyer: " . $wishlistItems->count() . "\n";
        
        foreach ($wishlistItems as $item) {
            echo "   ✓ Wishlist item: Product {$item->product_id}\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n9. Testing product browsing functionality...\n";
try {
    $allProducts = Product::all();
    echo "   ✓ Total products available: " . $allProducts->count() . "\n";
    
    $availableProducts = Product::where('stock', '>', 0)->get();
    echo "   ✓ Products in stock: " . $availableProducts->count() . "\n";
    
    foreach ($allProducts as $product) {
        echo "   ✓ Product: {$product->name} - Stock: {$product->stock}, Price: LKR {$product->price}\n";
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== BUYER FUNCTIONALITY TEST COMPLETE ===\n";
