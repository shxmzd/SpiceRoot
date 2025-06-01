<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerOrderController extends Controller
{
    /**
     * Get orders for the authenticated seller
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can access orders.'
                ], 403);
            }

            // Get query parameters
            $status = $request->query('status');
            $search = $request->query('search');
            $dateFrom = $request->query('date_from');
            $dateTo = $request->query('date_to');
            $limit = $request->query('limit', 12);
            $page = $request->query('page', 1);

            // Get filtered orders for this seller
            $ordersCollection = Order::getSellerOrders($user->_id, $status, $search, $dateFrom, $dateTo);
            
            // Manual pagination
            $offset = ($page - 1) * $limit;
            $totalOrders = $ordersCollection->count();
            $orders = $ordersCollection->skip($offset)->take($limit);

            // Transform orders for API response
            $transformedOrders = $orders->map(function ($order) use ($user) {
                // Get only this seller's items from the order
                $sellerItems = $order->getSellerItems($user->_id);
                $sellerTotal = $order->getSellerTotal($user->_id);

                return [
                    'id' => $order->_id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'status_badge' => $order->status_badge,
                    'customer_name' => $order->delivery_info['full_name'] ?? 'Unknown Customer',
                    'customer_phone' => $order->delivery_info['phone'] ?? '',
                    'delivery_address' => $this->formatDeliveryAddress($order->delivery_info),
                    'seller_items' => $sellerItems->map(function ($item) {
                        return [
                            'product_id' => $item['product_id'],
                            'product_name' => $item['product_name'],
                            'quantity' => $item['quantity'],
                            'price' => $item['price'],
                            'subtotal' => $item['subtotal'],
                            'formatted_price' => 'Rs. ' . number_format($item['price'], 2),
                            'formatted_subtotal' => 'Rs. ' . number_format($item['subtotal'], 2),
                        ];
                    })->values(),
                    'seller_items_count' => $sellerItems->count(),
                    'seller_total' => $sellerTotal,
                    'formatted_seller_total' => 'Rs. ' . number_format($sellerTotal, 2),
                    'payment_status' => $order->payment_status,
                    'can_ship' => $order->canBeShippedBySeller($user->_id),
                    'can_deliver' => $order->canBeDeliveredBySeller($user->_id),
                    'can_cancel' => $order->canBeCancelledBySeller($user->_id),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Seller orders retrieved successfully',
                'data' => [
                    'orders' => $transformedOrders->values(),
                    'pagination' => [
                        'current_page' => (int)$page,
                        'total_pages' => ceil($totalOrders / $limit),
                        'total_orders' => $totalOrders,
                        'per_page' => (int)$limit,
                        'has_next' => ($page * $limit) < $totalOrders,
                        'has_previous' => $page > 1,
                    ],
                    'filters' => [
                        'status' => $status,
                        'search' => $search,
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving seller orders: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order details for seller
     */
    public function show(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can access order details.'
                ], 403);
            }

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if this seller has items in the order
            $sellerItems = $order->getSellerItems($user->_id);
            if ($sellerItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found or access denied'
                ], 404);
            }

            $sellerTotal = $order->getSellerTotal($user->_id);

            // Transform seller's items
            $transformedItems = $sellerItems->map(function ($item) {
                return [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'formatted_price' => 'Rs. ' . number_format($item['price'], 2),
                    'formatted_subtotal' => 'Rs. ' . number_format($item['subtotal'], 2),
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Seller order details retrieved successfully',
                'data' => [
                    'order' => [
                        'id' => $order->_id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'status_badge' => $order->status_badge,
                        'customer_info' => [
                            'name' => $order->delivery_info['full_name'] ?? 'Unknown Customer',
                            'phone' => $order->delivery_info['phone'] ?? '',
                            'email' => $order->user->email ?? '',
                        ],
                        'delivery_info' => $order->delivery_info,
                        'delivery_address' => $this->formatDeliveryAddress($order->delivery_info),
                        'seller_items' => $transformedItems->values(),
                        'seller_items_count' => $sellerItems->count(),
                        'seller_total' => $sellerTotal,
                        'formatted_seller_total' => 'Rs. ' . number_format($sellerTotal, 2),
                        'payment_status' => $order->payment_status,
                        'can_ship' => $order->canBeShippedBySeller($user->_id),
                        'can_deliver' => $order->canBeDeliveredBySeller($user->_id),
                        'can_cancel' => $order->canBeCancelledBySeller($user->_id),
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving seller order details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ship an order
     */
    public function shipOrder(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can ship orders.'
                ], 403);
            }

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$order->canBeShippedBySeller($user->_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot ship this order'
                ], 422);
            }

            $order->updateStatus('shipped');

            return response()->json([
                'success' => true,
                'message' => 'Order marked as shipped successfully',
                'data' => [
                    'order' => [
                        'id' => $order->_id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'status_badge' => $order->status_badge,
                        'updated_at' => $order->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error shipping order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark order as delivered
     */
    public function deliverOrder(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can mark orders as delivered.'
                ], 403);
            }

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$order->canBeDeliveredBySeller($user->_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot mark this order as delivered'
                ], 422);
            }

            $order->updateStatus('delivered');

            return response()->json([
                'success' => true,
                'message' => 'Order marked as delivered successfully',
                'data' => [
                    'order' => [
                        'id' => $order->_id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'status_badge' => $order->status_badge,
                        'updated_at' => $order->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error marking order as delivered: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel an order
     */
    public function cancelOrder(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can cancel orders.'
                ], 403);
            }

            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$order->canBeCancelledBySeller($user->_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel this order'
                ], 422);
            }

            $order->updateStatus('cancelled');

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => [
                    'order' => [
                        'id' => $order->_id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'status_badge' => $order->status_badge,
                        'updated_at' => $order->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error cancelling order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get new orders count for seller
     */
    public function getNewOrdersCount(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'seller') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only sellers can check new orders count.'
                ], 403);
            }

            $newOrdersCount = Order::getNewOrdersCount($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'New orders count retrieved successfully',
                'data' => [
                    'new_orders_count' => $newOrdersCount
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting new orders count: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get seller order status options
     */
    public function statusOptions()
    {
        return response()->json([
            'success' => true,
            'message' => 'Seller status options retrieved successfully',
            'data' => [
                'status_options' => [
                    '' => 'All Orders',
                    'pending' => 'Pending',
                    'confirmed' => 'Confirmed',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled'
                ]
            ]
        ]);
    }

    /**
     * Helper method to format delivery address
     */
    private function formatDeliveryAddress($deliveryInfo)
    {
        if (!$deliveryInfo) return 'No address provided';

        $addressParts = [];
        
        if (!empty($deliveryInfo['address_line_1'])) {
            $addressParts[] = $deliveryInfo['address_line_1'];
        }
        
        if (!empty($deliveryInfo['address_line_2'])) {
            $addressParts[] = $deliveryInfo['address_line_2'];
        }
        
        if (!empty($deliveryInfo['city'])) {
            $addressParts[] = $deliveryInfo['city'];
        }
        
        if (!empty($deliveryInfo['postal_code'])) {
            $addressParts[] = $deliveryInfo['postal_code'];
        }

        return implode(', ', $addressParts);
    }
}