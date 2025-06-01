<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Wishlist extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'wishlist';

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    protected $casts = [
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

    // Static method to add product to wishlist
    public static function addToWishlist($userId, $productId)
    {
        // Check if item already exists in wishlist
        $existingWishlistItem = self::where('user_id', $userId)
                                   ->where('product_id', $productId)
                                   ->first();

        if ($existingWishlistItem) {
            return ['success' => false, 'message' => 'Item already added to wishlist!'];
        }

        $product = Product::find($productId);
        
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        // Create new wishlist item
        $wishlistItem = self::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return ['success' => true, 'message' => 'Product added to wishlist!', 'item' => $wishlistItem];
    }

    // Get wishlist items for a user
    public static function getWishlistItems($userId)
    {
        return self::where('user_id', $userId)
                   ->with('product.seller')
                   ->orderBy('created_at', 'desc')
                   ->get();
    }

    // Get wishlist count for a user
    public static function getWishlistCount($userId)
    {
        return self::where('user_id', $userId)->count();
    }

    // Check if product is in user's wishlist
    public static function isInWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->exists();
    }

    // Remove item from wishlist
    public static function removeFromWishlist($userId, $productId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->delete();
    }

    // Get array of product IDs in user's wishlist (for checking heart status)
    public static function getUserWishlistProductIds($userId)
    {
        return self::where('user_id', $userId)
                   ->pluck('product_id')
                   ->toArray();
    }

    // Move item from wishlist to cart
    public static function moveToCart($userId, $productId)
    {
        // Add to cart
        $cartResult = \App\Models\Cart::addToCart($userId, $productId, 1);
        
        if ($cartResult) {
            // Remove from wishlist
            self::removeFromWishlist($userId, $productId);
            return ['success' => true, 'message' => 'Product moved to cart!'];
        }

        return ['success' => false, 'message' => 'Error moving product to cart.'];
    }
}