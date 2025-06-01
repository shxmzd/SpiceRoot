<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get cart items for the authenticated buyer
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can access cart.'
                ], 403);
            }

            $cartSummary = Cart::getCartSummary($user->_id);

            // Transform cart items for API response
            $transformedItems = $cartSummary['items']->map(function ($cartItem) {
                $product = $cartItem->product;
                $seller = $product ? $product->seller : null;

                return [
                    'cart_item_id' => $cartItem->_id,
                    'quantity' => $cartItem->quantity,
                    'price_at_time' => $cartItem->price_at_time,
                    'subtotal' => $cartItem->subtotal,
                    'formatted_subtotal' => 'Rs. ' . number_format($cartItem->subtotal, 2),
                    'product' => $product ? [
                        'id' => $product->_id,
                        'name' => $product->name,
                        'category' => $product->category,
                        'current_price' => $product->price,
                        'description' => $product->description,
                        'image' => $product->image ? \Storage::url($product->image) : null,
                        'seller' => $seller ? [
                            'id' => $seller->_id,
                            'name' => $seller->name,
                        ] : null,
                    ] : null,
                    'created_at' => $cartItem->created_at,
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'cart_items' => $transformedItems,
                    'summary' => [
                        'item_count' => $cartSummary['item_count'],
                        'subtotal' => $cartSummary['subtotal'],
                        'shipping' => $cartSummary['shipping'],
                        'total' => $cartSummary['total'],
                        'is_empty' => $cartSummary['is_empty'],
                        'formatted_subtotal' => $cartSummary['formatted_subtotal'],
                        'formatted_shipping' => $cartSummary['formatted_shipping'],
                        'formatted_total' => $cartSummary['formatted_total'],
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add product to cart
     */
    public function addToCart(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can add items to cart.'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'product_id' => 'required|string',
                'quantity' => 'nullable|integer|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $productId = $request->product_id;
            $quantity = $request->quantity ?? 1;

            // Check if product exists and is active
            $product = Product::where('_id', $productId)
                             ->where('status', 'active')
                             ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found or not available'
                ], 404);
            }

            // Check if user is trying to add their own product
            if ($product->seller_id === $user->_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot add your own product to cart'
                ], 422);
            }

            // Add to cart
            $cartItem = Cart::addToCart($user->_id, $productId, $quantity);

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to cart'
                ], 500);
            }

            // Get updated cart summary
            $cartSummary = Cart::getCartSummary($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'data' => [
                    'cart_item' => [
                        'cart_item_id' => $cartItem->_id,
                        'quantity' => $cartItem->quantity,
                        'price_at_time' => $cartItem->price_at_time,
                        'subtotal' => $cartItem->subtotal,
                    ],
                    'cart_summary' => [
                        'item_count' => $cartSummary['item_count'],
                        'total' => $cartSummary['total'],
                        'formatted_total' => $cartSummary['formatted_total'],
                    ]
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request, $cartItemId)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can update cart.'
                ], 403);
            }

            $validator = Validator::make($request->all(), [
                'quantity' => 'required|integer|min:1|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $cartItem = Cart::where('user_id', $user->_id)
                           ->where('_id', $cartItemId)
                           ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $newQuantity = $request->quantity;
            $cartItem->updateQuantity($newQuantity);

            // Get updated cart summary
            $cartSummary = Cart::getCartSummary($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'Cart quantity updated successfully',
                'data' => [
                    'cart_item' => [
                        'cart_item_id' => $cartItem->_id,
                        'quantity' => $cartItem->quantity,
                        'subtotal' => $cartItem->subtotal,
                        'formatted_subtotal' => 'Rs. ' . number_format($cartItem->subtotal, 2),
                    ],
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
                'message' => 'Error updating quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeFromCart(Request $request, $cartItemId)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can modify cart.'
                ], 403);
            }

            $cartItem = Cart::where('user_id', $user->_id)
                           ->where('_id', $cartItemId)
                           ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $removed = Cart::removeFromCart($user->_id, $cartItemId);

            if (!$removed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to remove item from cart'
                ], 500);
            }

            // Get updated cart summary
            $cartSummary = Cart::getCartSummary($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully',
                'data' => [
                    'cart_summary' => [
                        'item_count' => $cartSummary['item_count'],
                        'total' => $cartSummary['total'],
                        'formatted_total' => $cartSummary['formatted_total'],
                        'is_empty' => $cartSummary['is_empty'],
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error removing from cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clearCart(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can clear cart.'
                ], 403);
            }

            // Remove all cart items for this user
            Cart::where('user_id', $user->_id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully',
                'data' => [
                    'cart_summary' => [
                        'item_count' => 0,
                        'total' => 0,
                        'formatted_total' => 'Rs. 0.00',
                        'is_empty' => true,
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error clearing cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart count (for mobile app badge)
     */
    public function getCartCount(Request $request)
    {
        try {
            $user = $request->user();
            
            if ($user->role !== 'buyer') {
                return response()->json([
                    'success' => false,
                    'message' => 'Access denied. Only buyers can check cart count.'
                ], 403);
            }

            $cartCount = Cart::getCartCount($user->_id);

            return response()->json([
                'success' => true,
                'message' => 'Cart count retrieved successfully',
                'data' => [
                    'cart_count' => $cartCount
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting cart count: ' . $e->getMessage()
            ], 500);
        }
    }
}