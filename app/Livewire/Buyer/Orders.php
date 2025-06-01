<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use App\Models\Review;
use App\Models\Cart as CartModel;

class Orders extends Component
{
    use WithPagination;

    // Filter properties
    public $statusFilter = '';
    public $searchTerm = '';

    // Review modal properties
    public $showReviewModal = false;
    public $reviewingProduct = null;
    public $reviewingOrder = null;
    public $rating = 5;
    public $reviewText = '';

    // Status options for buyer
    public $statusOptions = [
        '' => 'All Orders',
        'confirmed' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled'
    ];

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'reviewText' => 'required|string|min:10|max:500'
    ];

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = $this->getFilteredOrders();
        $stats = Order::getBuyerStats(auth()->id());

        return view('livewire.buyer.orders', [
            'orders' => $orders,
            'stats' => $stats
        ])->layout('layouts.app');
    }

    private function getFilteredOrders()
    {
        return Order::getBuyerOrders(
            auth()->id(),
            $this->statusFilter ?: null,
            $this->searchTerm ?: null
        )->paginate(10);
    }

    public function cancelOrder($orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if ($order && $order->user_id == auth()->id() && $order->canBeCancelledByBuyer()) {
                $order->updateStatus('cancelled');
                session()->flash('success', 'Order #' . $order->order_number . ' has been cancelled.');
            } else {
                session()->flash('error', 'Cannot cancel this order.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error cancelling order: ' . $e->getMessage());
        }
    }

    public function reorder($orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if ($order && $order->user_id == auth()->id() && $order->canBeReordered()) {
                // Clear current cart
                CartModel::where('user_id', auth()->id())->delete();
                
                // Add order items to cart
                foreach ($order->items as $item) {
                    CartModel::addToCart(auth()->id(), $item['product_id'], $item['quantity']);
                }
                
                // Redirect to checkout
                return redirect()->route('buyer.checkout');
            } else {
                session()->flash('error', 'Cannot reorder this order.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error reordering: ' . $e->getMessage());
        }
    }

    public function openReviewModal($productId, $orderId)
    {
        $this->reviewingProduct = $productId;
        $this->reviewingOrder = $orderId;
        
        // Check if already reviewed
        $existingReview = Review::where('user_id', auth()->id())
                               ->where('product_id', $productId)
                               ->where('order_id', $orderId)
                               ->first();
        
        if ($existingReview) {
            $this->rating = $existingReview->rating;
            $this->reviewText = $existingReview->review_text;
        } else {
            $this->rating = 5;
            $this->reviewText = '';
        }
        
        $this->showReviewModal = true;
    }

    public function closeReviewModal()
    {
        $this->showReviewModal = false;
        $this->reviewingProduct = null;
        $this->reviewingOrder = null;
        $this->rating = 5;
        $this->reviewText = '';
        $this->resetValidation();
    }

    public function submitReview()
    {
        $this->validate();

        try {
            Review::createOrUpdateReview(
                auth()->id(),
                $this->reviewingProduct,
                $this->reviewingOrder,
                $this->rating,
                $this->reviewText
            );

            session()->flash('success', 'Review submitted successfully!');
            $this->closeReviewModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Error submitting review: ' . $e->getMessage());
        }
    }

    public function clearFilters()
    {
        $this->statusFilter = '';
        $this->searchTerm = '';
        $this->resetPage();
    }
}