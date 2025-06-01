<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Get orders for the authenticated buyer
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access orders.'
                ], 403);
            }

            // Get query parameters
            $status = $request->query('status');
            $search = $request->query('search');
            $dateFrom = $request->query('date_from');
            $dateTo = $request->query('date_to');
            $limit = $request->query('limit', 10);
            $page = $request->query('page', 1);

            // Get filtered orders
            $ordersQuery = Order::getBuyerOrders($user->_id, $status, $search, $dateFrom, $dateTo);
            
            // Manual pagination since we're using a custom query
            $offset = ($page - 1) * $limit;
            $allOrders = $ordersQuery->get();
            $totalOrders = $allOrders->count();
            $orders = $allOrders->skip($offset)->take($limit);

            // Transform orders for API response
            $transformedOrders = $orders->map(function ($order) {
                return [
                    'id' => $order->_id,
                    'order_number' => $order->order_number,
                    'status' => $order->status,
                    'status_badge' => $order->status_badge,
                    'items_count' => count($order->items),
                    'subtotal' => $order->subtotal,
                    'shipping' => $order->shipping,
                    'total' => $order->total,
                    'formatted_total' => 'Rs. ' . number_format($order->total, 2),
                    'currency' => $order->currency,
                    'payment_status' => $order->payment_status,
                    'delivery_info' => $order->delivery_info,
                    'can_cancel' => $order->canBeCancelledByBuyer(),
                    'can_reorder' => $order->canBeReordered(),
                    'can_rate' => $order->canBeRated(),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully',
                'data' => [
                    'orders' => $transformedOrders,
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
                'message' => 'Error retrieving orders: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order details by order number
     */
    public function show(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access order details.'
                ], 403);
            }

            $order = Order::getBuyerOrderByNumber($user->_id, $orderNumber);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            // Get order steps for tracking
            $orderSteps = $order->getOrderSteps();

            // Transform order items
            $transformedItems = collect($order->items)->map(function ($item) {
                return [
                    'product_id' => $item['product_id'],
                    'product_name' => $item['product_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                    'formatted_price' => 'Rs. ' . number_format($item['price'], 2),
                    'formatted_subtotal' => 'Rs. ' . number_format($item['subtotal'], 2),
                    'seller_id' => $item['seller_id'],
                    'seller_name' => $item['seller_name'],
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Order details retrieved successfully',
                'data' => [
                    'order' => [
                        'id' => $order->_id,
                        'order_number' => $order->order_number,
                        'status' => $order->status,
                        'status_badge' => $order->status_badge,
                        'items' => $transformedItems,
                        'items_count' => count($order->items),
                        'subtotal' => $order->subtotal,
                        'shipping' => $order->shipping,
                        'total' => $order->total,
                        'formatted_subtotal' => 'Rs. ' . number_format($order->subtotal, 2),
                        'formatted_shipping' => 'Rs. ' . number_format($order->shipping, 2),
                        'formatted_total' => 'Rs. ' . number_format($order->total, 2),
                        'currency' => $order->currency,
                        'payment_status' => $order->payment_status,
                        'delivery_info' => $order->delivery_info,
                        'order_steps' => $orderSteps,
                        'can_cancel' => $order->canBeCancelledByBuyer(),
                        'can_reorder' => $order->canBeReordered(),
                        'can_rate' => $order->canBeRated(),
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving order details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel an order
     */
    public function cancel(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can cancel orders.'
                ], 403);
            }

            $order = Order::getBuyerOrderByNumber($user->_id, $orderNumber);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$order->canBeCancelledByBuyer()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This order cannot be cancelled'
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
     * Reorder - add order items to cart
     */
    public function reorder(Request $request, $orderNumber)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can reorder.'
                ], 403);
            }

            $order = Order::getBuyerOrderByNumber($user->_id, $orderNumber);

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found'
                ], 404);
            }

            if (!$order->canBeReordered()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This order cannot be reordered'
                ], 422);
            }

            // Optional: Clear current cart before reordering
            $clearCart = $request->query('clear_cart', true);
            if ($clearCart) {
                Cart::where('user_id', $user->_id)->delete();
            }

            // Add order items to cart
            $addedItems = [];
            $skippedItems = [];

            foreach ($order->items as $item) {
                // Check if product still exists and is active
                $product = \App\Models\Product::where('_id', $item['product_id'])
                                             ->where('status', 'active')
                                             ->first();

                if ($product) {
                    $cartItem = Cart::addToCart($user->_id, $item['product_id'], $item['quantity']);
                    if ($cartItem) {
                        $addedItems[] = [
                            'product_name' => $item['product_name'],
                            'quantity' => $item['quantity']
                        ];
                    }
                } else {
                    $skippedItems[] = [
                        'product_name' => $item['product_name'],
                        'reason' => 'Product no longer available'
                    ];
                }
            }

            // Get updated cart summary
            $cartSummary = Cart::getCartSummary($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'Items added to cart successfully',
                'data' => [
                    'added_items' => $addedItems,
                    'skipped_items' => $skippedItems,
                    'cart_summary' => [
                        'item_count' => $cartSummary['item_count'],
                        'total' => $cartSummary['total'],
                        'formatted_total' => $cartSummary['formatted_total'],
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error reordering: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get buyer order statistics
     */
    public function stats(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access order stats.'
                ], 403);
            }

            $stats = Order::getBuyerStats($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'Order statistics retrieved successfully',
                'data' => [
                    'stats' => [
                        'total_orders' => $stats['total_orders'],
                        'processing_orders' => $stats['processing_orders'],
                        'delivered_orders' => $stats['delivered_orders'],
                        'total_spent' => $stats['total_spent'],
                        'formatted_total_spent' => 'Rs. ' . number_format($stats['total_spent'], 2),
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving order stats: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order status options for filtering
     */
    public function statusOptions()
    {
        return response()->json([
            'success' => true,
            'message' => 'Status options retrieved successfully',
            'data' => [
                'status_options' => [
                    '' => 'All Orders',
                    'pending' => 'Pending',
                    'confirmed' => 'Processing',
                    'shipped' => 'Shipped',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled'
                ]
            ]
        ]);
    }

    /**
     * Get new orders count (for mobile app badge)
     */
    public function getNewOrdersCount(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can check new orders count.'
                ], 403);
            }

            $newOrdersCount = Order::getNewOrdersCountForBuyer($user->_id);

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
}