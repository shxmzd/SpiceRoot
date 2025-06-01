<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class RecentlyViewed extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'recently_viewed';

    protected $fillable = [
        'user_id',
        'product_id',
        'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
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

    // Static method to track a viewed product
    public static function trackView($userId, $productId)
    {
        // Remove existing entry if it exists (to update timestamp)
        self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();

        // Create new entry
        self::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'viewed_at' => now()
        ]);

        // Keep only the latest 6 viewed products per user
        $recentViews = self::where('user_id', $userId)
                          ->orderBy('viewed_at', 'desc')
                          ->skip(6)
                          ->get();

        // Delete older entries
        foreach ($recentViews as $view) {
            $view->delete();
        }
    }

    // Get recently viewed products for a user
    public static function getRecentlyViewedProducts($userId, $limit = 6)
    {
        return self::where('user_id', $userId)
                   ->with('product.seller')
                   ->orderBy('viewed_at', 'desc')
                   ->limit($limit)
                   ->get()
                   ->pluck('product')
                   ->filter(); // Remove null products
    }

    // Get recently viewed items (alias method for buyer functionality)
    public static function getRecentlyViewed($userId, $limit = 6)
    {
        return self::getRecentlyViewedProducts($userId, $limit);
    }
}