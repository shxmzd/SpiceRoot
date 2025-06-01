<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class SellerNotification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'seller_notifications';

    protected $fillable = [
        'seller_id',
        'order_id',
        'order_number',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function notifyNewOrder($order)
    {
        // Notify each seller in the order
        $sellerIds = collect($order->items)->pluck('seller_id')->unique();
        foreach ($sellerIds as $sellerId) {
            $sellerItems = collect($order->items)->where('seller_id', $sellerId);
            $productNames = $sellerItems->pluck('product_name')->implode(', ');
            self::create([
                'seller_id' => $sellerId,
                'order_id' => $order->_id,
                'order_number' => $order->order_number,
                'message' => 'New order received for: ' . $productNames,
                'is_read' => false,
            ]);
        }
    }

    public static function unreadCount($sellerId)
    {
        return self::where('seller_id', $sellerId)->where('is_read', false)->count();
    }

    public static function recent($sellerId, $limit = 5)
    {
        return self::where('seller_id', $sellerId)->orderBy('created_at', 'desc')->limit($limit)->get();
    }

    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }
}
