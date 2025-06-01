<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING SELLER DASHBOARD ACCESS ===\n\n";

// Find a seller user
$seller = User::where('role', 'seller')->first();

if (!$seller) {
    echo "❌ No seller found in database\n";
    exit(1);
}

echo "✓ Testing with seller: {$seller->name} (ID: {$seller->_id})\n";
echo "✓ Seller role: {$seller->role}\n";
echo "✓ isSeller(): " . ($seller->isSeller() ? 'Yes' : 'No') . "\n\n";

// Test middleware methods
echo "=== TESTING MIDDLEWARE REQUIREMENTS ===\n";
echo "1. Auth check: " . (Auth::check() ? 'Authenticated' : 'Not authenticated') . "\n";

// Manually authenticate the seller for testing
Auth::login($seller);
echo "2. After login: " . (Auth::check() ? 'Authenticated' : 'Not authenticated') . "\n";
echo "3. Current user: " . (Auth::user() ? Auth::user()->name : 'None') . "\n";
echo "4. Current user isSeller(): " . (Auth::user() && Auth::user()->isSeller() ? 'Yes' : 'No') . "\n\n";

// Test Livewire component instantiation
echo "=== TESTING LIVEWIRE COMPONENT ===\n";
try {
    $component = new \App\Livewire\Seller\Dashboard();
    echo "✓ Dashboard component instantiated successfully\n";
    
    // Test mount method
    $component->mount();
    echo "✓ Component mount() method executed\n";
    
    // Check component properties
    echo "✓ Products loaded: " . count($component->products) . "\n";
    echo "✓ Notifications loaded: " . count($component->notifications) . "\n";
    echo "✓ Unread notifications: {$component->unreadNotifications}\n";
    
} catch (Exception $e) {
    echo "❌ Error with Dashboard component: " . $e->getMessage() . "\n";
    echo "   Stack trace: " . $e->getTraceAsString() . "\n";
}

// Test add product functionality
echo "\n=== TESTING ADD PRODUCT FUNCTIONALITY ===\n";
try {
    $component = new \App\Livewire\Seller\Dashboard();
    $component->mount();
    
    // Set test product data
    $component->productName = 'Test Product';
    $component->productDescription = 'Test Description';
    $component->productPrice = 25.99;
    $component->productStock = 10;
    $component->productCategory = 'spices';
    
    echo "✓ Product data set for testing\n";
    
    // Attempt to add product (this should work if everything is configured correctly)
    $component->addProduct();
    echo "✓ addProduct() method executed without errors\n";
    
} catch (Exception $e) {
    echo "❌ Error with addProduct(): " . $e->getMessage() . "\n";
    echo "   File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}

// Test CSRF token
echo "\n=== TESTING CSRF FUNCTIONALITY ===\n";
echo "✓ CSRF token: " . csrf_token() . "\n";
echo "✓ Session started: " . (session()->isStarted() ? 'Yes' : 'No') . "\n";

// Test database connection
echo "\n=== TESTING DATABASE CONNECTION ===\n";
try {
    $connectionName = config('database.default');
    echo "✓ Default database connection: {$connectionName}\n";
    
    $userCount = User::count();
    echo "✓ Users in database: {$userCount}\n";
    
    $productCount = \App\Models\Product::count();
    echo "✓ Products in database: {$productCount}\n";
    
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING COMPLETE ===\n";
