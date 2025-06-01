<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'rating',
        'review_text'
    ];

    protected $casts = [
        'rating' => 'integer',
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

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Check if user has already reviewed this product for this order
    public static function hasUserReviewed($userId, $productId, $orderId)
    {
        return self::where('user_id', $userId)
                   ->where('product_id', $productId)
                   ->where('order_id', $orderId)
                   ->exists();
    }

    // Get average rating for a product
    public static function getProductAverageRating($productId)
    {
        $average = self::where('product_id', $productId)->avg('rating');
        return $average ? round($average, 1) : 0;
    }

    // Get review count for a product
    public static function getProductReviewCount($productId)
    {
        return self::where('product_id', $productId)->count();
    }

    // Get reviews for a product
    public static function getProductReviews($productId, $limit = null)
    {
        $query = self::where('product_id', $productId)
                     ->with('user')
                     ->orderBy('created_at', 'desc');
        
        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    // Create or update review
    public static function createOrUpdateReview($userId, $productId, $orderId, $rating, $reviewText)
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'product_id' => $productId,
                'order_id' => $orderId
            ],
            [
                'rating' => $rating,
                'review_text' => $reviewText
            ]
        );
    }
}