<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mongodb';

    // === BUYER STATS ===
    /**
     * Get statistics for a buyer's orders (total, processing, delivered, total spent)
     * @param string|int $buyerId
     * @return array
     */
    public static function getBuyerStats($buyerId)
    {
        $orders = self::where('user_id', $buyerId)->get();
        $totalOrders = $orders->count();
        $processingOrders = $orders->whereIn('status', ['pending', 'confirmed', 'shipped'])->count();
        $deliveredOrders = $orders->where('status', 'delivered')->count();
        $totalSpent = $orders->whereIn('status', ['confirmed', 'shipped', 'delivered'])
            ->sum('total');
        return [
            'total_orders' => $totalOrders,
            'processing_orders' => $processingOrders,
            'delivered_orders' => $deliveredOrders,
            'total_spent' => $totalSpent,
        ];
    }

    // === BUYER METHODS ===
    // Get orders for a specific buyer (user)
    public static function getBuyerOrders($buyerId, $status = null, $search = null, $dateFrom = null, $dateTo = null)
    {
        $query = self::where('user_id', $buyerId);
        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'regex', "/{$search}/i")
                  ->orWhere('delivery_info.full_name', 'regex', "/{$search}/i");
            });
        }
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }
        return $query->orderBy('created_at', 'desc');
    }

    // Get a single order for a buyer by order number (for order details page)
    public static function getBuyerOrderByNumber($buyerId, $orderNumber)
    {
        return self::where('user_id', $buyerId)
            ->where('order_number', $orderNumber)
            ->first();
    }

    // Get count of new (pending) orders for a buyer
    public static function getNewOrdersCountForBuyer($buyerId)
    {
        return self::where('user_id', $buyerId)
            ->where('status', 'pending')
            ->count();
    }

    // Get all items for this buyer in this order (for future multi-user orders)
    public function getBuyerItems($buyerId)
    {
        // For now, all items belong to the buyer (since user_id is order owner)
        return collect($this->items);
    }

    // Get buyer's total for this order
    public function getBuyerTotal($buyerId)
    {
        return $this->getBuyerItems($buyerId)->sum('subtotal');
    }
    protected $collection = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'items',
        'subtotal',
        'shipping',
        'total',
        'currency',
        'delivery_info',
        'payment_status',
        'payment_intent_id',
        'stripe_payment_id',
        'status'
    ];

    protected $casts = [
        'items' => 'array',
        'delivery_info' => 'array',
        'subtotal' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . strtoupper(uniqid());
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    // Create order from cart
    public static function createFromCart($userId, $deliveryInfo, $paymentIntentId = null)
    {
        $cartItems = \App\Models\Cart::getCartItems($userId);
        $cartSummary = \App\Models\Cart::getCartTotal($userId);

        if ($cartItems->isEmpty()) {
            return null;
        }

        // Prepare order items
        $orderItems = [];
        foreach ($cartItems as $cartItem) {
            if ($cartItem->product) {
                $orderItems[] = [
                    'product_id' => trim((string)$cartItem->product->_id),
                    'product_name' => trim($cartItem->product->name),
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price_at_time,
                    'subtotal' => $cartItem->subtotal,
                    'seller_id' => trim((string)$cartItem->product->seller_id),
                    'seller_name' => trim($cartItem->product->seller->name ?? 'Unknown')
                ];
            }
        }

        // Create order
        $order = self::create([
            'user_id' => $userId,
            'order_number' => self::generateOrderNumber(),
            'items' => $orderItems,
            'subtotal' => $cartSummary['subtotal'],
            'shipping' => $cartSummary['shipping'],
            'total' => $cartSummary['total'],
            'currency' => 'LKR',
            'delivery_info' => $deliveryInfo,
            'payment_status' => 'pending',
            'payment_intent_id' => $paymentIntentId,
            'status' => 'pending'
        ]);

        return $order;
    }

    // Update payment status
    public function updatePaymentStatus($status, $stripePaymentId = null)
    {
        $updateData = ['payment_status' => $status];
        
        if ($stripePaymentId) {
            $updateData['stripe_payment_id'] = $stripePaymentId;
        }

        if ($status === 'completed') {
            $updateData['status'] = 'confirmed';
        } elseif ($status === 'failed') {
            $updateData['status'] = 'cancelled';
        }

        return $this->update($updateData);
    }

    // Get orders for a specific seller
    public static function getSellerOrders($sellerId, $status = null, $search = null, $dateFrom = null, $dateTo = null)
    {
        // Start with base query (without seller filtering due to MongoDB array query issues)
        $query = self::query();

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        // Search by customer name or order number
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'regex', "/{$search}/i")
                  ->orWhere('delivery_info.full_name', 'regex', "/{$search}/i");
            });
        }

        // Date range filter
        if ($dateFrom) {
            $query->where('created_at', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->where('created_at', '<=', $dateTo);
        }

        // Get results and filter by seller_id in PHP (workaround for MongoDB array query issues)
        $orders = $query->orderBy('created_at', 'desc')->get();
        
        // Filter orders that contain items for this seller
        $filteredOrders = $orders->filter(function($order) use ($sellerId) {
            foreach ($order->items as $item) {
                if (isset($item['seller_id']) && trim($item['seller_id']) === trim($sellerId)) {
                    return true;
                }
            }
            return false;
        });

        // Return as a collection that can be paginated later if needed
        return collect($filteredOrders->values());
    }

    // Get seller's items from this order
    public function getSellerItems($sellerId)
    {
        return collect($this->items)->where('seller_id', $sellerId);
    }

    // Get seller's total for this order
    public function getSellerTotal($sellerId)
    {
        return $this->getSellerItems($sellerId)->sum('subtotal');
    }

    // Check if seller can cancel order
    public function canBeCancelledBySeller($sellerId)
    {
        // Can only cancel if order status is pending and contains seller's items
        return $this->status === 'pending' && 
               collect($this->items)->where('seller_id', $sellerId)->isNotEmpty();
    }

    // Check if seller can ship order
    public function canBeShippedBySeller($sellerId)
    {
        return in_array($this->status, ['pending', 'confirmed']) && 
               collect($this->items)->where('seller_id', $sellerId)->isNotEmpty();
    }

    // Check if seller can mark as delivered
    public function canBeDeliveredBySeller($sellerId)
    {
        return $this->status === 'shipped' && 
               collect($this->items)->where('seller_id', $sellerId)->isNotEmpty();
    }

    // Update order status
    public function updateStatus($newStatus)
    {
        return $this->update(['status' => $newStatus]);
    }

    // Get count of new orders for seller
    public static function getNewOrdersCount($sellerId)
    {
        // Get all pending orders and filter by seller_id in PHP (workaround for MongoDB array query issues)
        $orders = self::where('status', 'pending')->get();
        
        $count = 0;
        foreach ($orders as $order) {
            foreach ($order->items as $item) {
                if (isset($item['seller_id']) && trim($item['seller_id']) === trim($sellerId)) {
                    $count++;
                    break; // Only count each order once
                }
            }
        }
        
        return $count;
    }

    // Get formatted status with color
    public function getStatusBadgeAttribute()
    {
        $statusColors = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800'
        ];

        $color = $statusColors[$this->status] ?? 'bg-gray-100 text-gray-800';
        
        return [
            'text' => ucfirst($this->status),
            'class' => $color
        ];
    }
}
