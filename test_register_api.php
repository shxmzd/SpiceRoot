<?php

// Test the new register API endpoint
// Run this file with: php test_register_api.php

require_once 'vendor/autoload.php';

// Define test data
$testUsers = [
    [
        'name' => 'Test Buyer',
        'email' => 'testbuyer' . time() . '@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'buyer',
        'device_name' => 'test_device'
    ],
    [
        'name' => 'Test Seller',
        'email' => 'testseller' . time() . '@example.com', 
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => 'seller',
        'device_name' => 'test_device'
    ]
];

echo "🧪 Testing Register API Endpoint\n";
echo "================================\n\n";

// Get the base URL (adjust if needed)
$baseUrl = 'http://127.0.0.1:8000/api'; // Adjust to your Laravel app URL

foreach ($testUsers as $index => $userData) {
    echo "Test " . ($index + 1) . ": Registering " . $userData['role'] . " user\n";
    echo "Email: " . $userData['email'] . "\n";
    
    // Test register endpoint
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/register');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($userData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    if ($curlError) {
        echo "❌ CURL Error: $curlError\n\n";
        continue;
    }
    
    $responseData = json_decode($response, true);
    
    if ($httpCode === 201 && isset($responseData['success']) && $responseData['success']) {
        echo "✅ Registration successful!\n";
        echo "   User ID: " . $responseData['data']['user']['id'] . "\n";
        echo "   User Role: " . $responseData['data']['user']['role'] . "\n";
        echo "   Token received: " . (isset($responseData['data']['token']) ? 'Yes' : 'No') . "\n";
        
        // Test login with the same credentials to verify
        echo "   Testing login with new credentials...\n";
        
        $loginData = [
            'email' => $userData['email'],
            'password' => $userData['password'],
            'device_name' => 'test_login'
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($loginData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $loginResponse = curl_exec($ch);
        $loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        $loginResponseData = json_decode($loginResponse, true);
        
        if ($loginHttpCode === 200 && isset($loginResponseData['success']) && $loginResponseData['success']) {
            echo "   ✅ Login test passed - credentials work correctly\n";
        } else {
            echo "   ❌ Login test failed - registration may have issues\n";
            echo "   Login Response: " . json_encode($loginResponseData, JSON_PRETTY_PRINT) . "\n";
        }
        
    } else {
        echo "❌ Registration failed (HTTP $httpCode)\n";
        echo "   Response: " . json_encode($responseData, JSON_PRETTY_PRINT) . "\n";
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
}

echo "🔍 Testing existing login endpoint to ensure no disruption\n";
echo "========================================================\n";

// Test with existing user if any exists (this will fail if no users exist, which is expected)
$existingUserTest = [
    'email' => 'admin@example.com', // Replace with an actual existing user email
    'password' => 'password',
    'device_name' => 'test_existing'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($existingUserTest));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$responseData = json_decode($response, true);

echo "Login endpoint test (with example credentials):\n";
echo "HTTP Code: $httpCode\n";
echo "Response structure looks correct: " . (isset($responseData['success']) ? 'Yes' : 'No') . "\n";

if ($httpCode === 401) {
    echo "✅ Expected behavior - returns 401 for invalid credentials\n";
} elseif ($httpCode === 200 && $responseData['success']) {
    echo "✅ Existing login functionality working correctly\n";
} else {
    echo "⚠️  Unexpected response - please check your existing login endpoint\n";
}

echo "\n✅ Test completed!\n";
echo "\nNOTE: The register endpoint is now available at: $baseUrl/register\n";
echo "Required fields: name, email, password, password_confirmation, role (buyer|seller)\n";
echo "Optional fields: device_name, terms\n";
