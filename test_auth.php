<?php

require_once __DIR__ . '/vendor/autoload.php';

// Initialize Laravel app
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== TESTING AUTHENTICATION ===\n\n";

// Test 1: Create a test user
echo "1. Testing user creation...\n";
try {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => Hash::make('password123'),
        'role' => 'buyer'
    ]);
    echo "   ✓ User created successfully\n";
    echo "   User ID: " . $user->_id . "\n";
} catch (Exception $e) {
    echo "   ✗ User creation failed: " . $e->getMessage() . "\n";
}

// Test 2: Retrieve user and verify password
echo "\n2. Testing password verification...\n";
try {
    $user = User::where('email', 'test@example.com')->first();
    if ($user) {
        echo "   ✓ User found\n";
        if (Hash::check('password123', $user->password)) {
            echo "   ✓ Password verification successful\n";
        } else {
            echo "   ✗ Password verification failed\n";
        }
    } else {
        echo "   ✗ User not found\n";
    }
} catch (Exception $e) {
    echo "   ✗ Retrieval failed: " . $e->getMessage() . "\n";
}

// Test 3: MongoDB connection
echo "\n3. Testing MongoDB connection...\n";
try {
    $connection = DB::connection('mongodb');
    $collections = $connection->listCollections();
    echo "   ✓ MongoDB connection successful\n";
    echo "   Collections found: " . count($collections) . "\n";
} catch (Exception $e) {
    echo "   ✗ MongoDB connection failed: " . $e->getMessage() . "\n";
}
