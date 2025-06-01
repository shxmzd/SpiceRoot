<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Livewire\Seller\Dashboard;
use App\Livewire\Seller\Orders;
use App\Livewire\Seller\OrderDetails;
use App\Livewire\Seller\AddProduct;
use App\Livewire\Seller\ViewProducts;
use App\Models\User;

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== TESTING LIVEWIRE SELLER COMPONENTS ===\n\n";

// Get a seller to test with
$seller = User::where('role', 'seller')->first();
if (!$seller) {
    echo "✗ No seller found in database\n";
    exit(1);
}

echo "Testing with seller: {$seller->name} (ID: {$seller->_id})\n\n";

// Test each Livewire component
$components = [
    'Dashboard' => Dashboard::class,
    'Orders' => Orders::class,
    'AddProduct' => AddProduct::class,
    'ViewProducts' => ViewProducts::class,
];

foreach ($components as $name => $class) {
    echo "Testing {$name} component...\n";
    try {
        // Create component instance
        $component = new $class();
        
        // Check if it has the expected properties/methods
        if (method_exists($component, 'render')) {
            echo "   ✓ Component instantiated successfully\n";
            echo "   ✓ Has render() method\n";
        } else {
            echo "   ✗ Missing render() method\n";
        }
        
        // Check component-specific properties
        if ($name === 'Dashboard') {
            $properties = ['totalOrders', 'newOrders', 'totalSales', 'recentOrders'];
            foreach ($properties as $prop) {
                if (property_exists($component, $prop)) {
                    echo "   ✓ Has {$prop} property\n";
                } else {
                    echo "   ⚠ Missing {$prop} property\n";
                }
            }
        } elseif ($name === 'Orders') {
            $properties = ['orders', 'selectedStatus', 'search', 'dateFrom', 'dateTo'];
            foreach ($properties as $prop) {
                if (property_exists($component, $prop)) {
                    echo "   ✓ Has {$prop} property\n";
                } else {
                    echo "   ⚠ Missing {$prop} property\n";
                }
            }
        } elseif ($name === 'AddProduct') {
            $properties = ['name', 'description', 'price', 'stock_quantity', 'category', 'image'];
            foreach ($properties as $prop) {
                if (property_exists($component, $prop)) {
                    echo "   ✓ Has {$prop} property\n";
                } else {
                    echo "   ⚠ Missing {$prop} property\n";
                }
            }
        } elseif ($name === 'ViewProducts') {
            $properties = ['products', 'search', 'selectedStatus'];
            foreach ($properties as $prop) {
                if (property_exists($component, $prop)) {
                    echo "   ✓ Has {$prop} property\n";
                } else {
                    echo "   ⚠ Missing {$prop} property\n";
                }
            }
        }
        
    } catch (Exception $e) {
        echo "   ✗ Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

// Test OrderDetails component separately (requires parameter)
echo "Testing OrderDetails component...\n";
try {
    $component = new OrderDetails();
    if (method_exists($component, 'render')) {
        echo "   ✓ Component instantiated successfully\n";
        echo "   ✓ Has render() method\n";
    }
    
    $properties = ['orderId', 'order'];
    foreach ($properties as $prop) {
        if (property_exists($component, $prop)) {
            echo "   ✓ Has {$prop} property\n";
        } else {
            echo "   ⚠ Missing {$prop} property\n";
        }
    }
} catch (Exception $e) {
    echo "   ✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== LIVEWIRE COMPONENT TESTING COMPLETE ===\n";
