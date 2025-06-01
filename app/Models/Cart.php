<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Cart extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cart';

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'price_at_time'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_at_time' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Static method to add product to cart
    public static function addToCart($userId, $productId, $quantity = 1)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return false;
        }

        // Check if item already exists in cart
        $existingCartItem = self::where('user_id', $userId)
                               ->where('product_id', $productId)
                               ->first();

        if ($existingCartItem) {
            // Update quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
            return $existingCartItem;
        } else {
            // Create new cart item
            return self::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price_at_time' => $product->price
            ]);
        }
    }

    // Get cart items for a user
    public static function getCartItems($userId)
    {
        return self::where('user_id', $userId)
                   ->with('product.seller')
                   ->get();
    }

    // Get cart count for a user
    public static function getCartCount($userId)
    {
        return self::where('user_id', $userId)->sum('quantity');
    }

    // Calculate subtotal for this cart item
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price_at_time;
    }

    // Calculate total cart value for a user
    public static function getCartTotal($userId)
    {
        $cartItems = self::getCartItems($userId);
        $subtotal = $cartItems->sum('subtotal');
        $shipping = 500; // Fixed shipping
        
        return [
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'item_count' => $cartItems->sum('quantity')
        ];
    }

    // Remove item from cart
    public static function removeFromCart($userId, $cartItemId)
    {
        return self::where('user_id', $userId)
                   ->where('_id', $cartItemId)
                   ->delete();
    }

    // Update quantity
    public function updateQuantity($newQuantity)
    {
        if ($newQuantity <= 0) {
            return $this->delete();
        }
        
        $this->quantity = $newQuantity;
        return $this->save();
    }

    // Get comprehensive cart summary for a user
    public static function getCartSummary($userId)
    {
        $cartItems = self::getCartItems($userId);
        $itemCount = $cartItems->sum('quantity');
        $subtotal = $cartItems->sum('subtotal');
        $shipping = $itemCount > 0 ? 500 : 0; // Free shipping for empty cart
        
        return [
            'items' => $cartItems,
            'item_count' => $itemCount,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'is_empty' => $itemCount === 0,
            'formatted_subtotal' => 'LKR ' . number_format($subtotal, 2),
            'formatted_shipping' => 'LKR ' . number_format($shipping, 2),
            'formatted_total' => 'LKR ' . number_format($subtotal + $shipping, 2)
        ];
    }
}