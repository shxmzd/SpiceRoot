<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use App\Models\Order;

class OrderDetails extends Component
{
    public $order;
    public $sellerItems;
    public $sellerTotal;

    public function mount($orderId)
    {
        $this->order = Order::find($orderId);
        
        if (!$this->order) {
            abort(404, 'Order not found');
        }

        // Check if seller has items in this order
        $this->sellerItems = $this->order->getSellerItems(auth()->id());
        
        if ($this->sellerItems->isEmpty()) {
            abort(403, 'You do not have access to this order');
        }

        $this->sellerTotal = $this->order->getSellerTotal(auth()->id());
    }

    public function render()
    {
        return view('livewire.seller.order-details')->layout('layouts.seller');

    }

    public function shipOrder()
    {
        try {
            if ($this->order->canBeShippedBySeller(auth()->id())) {
                $this->order->updateStatus('shipped');
                session()->flash('success', 'Order #' . $this->order->order_number . ' marked as shipped!');
                
                // Refresh order data
                $this->order = $this->order->fresh();
            } else {
                session()->flash('error', 'Cannot ship this order.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function deliverOrder()
    {
        try {
            if ($this->order->canBeDeliveredBySeller(auth()->id())) {
                $this->order->updateStatus('delivered');
                session()->flash('success', 'Order #' . $this->order->order_number . ' marked as delivered!');
                
                // Refresh order data
                $this->order = $this->order->fresh();
            } else {
                session()->flash('error', 'Cannot mark this order as delivered.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function cancelOrder()
    {
        try {
            if ($this->order->canBeCancelledBySeller(auth()->id())) {
                $this->order->updateStatus('cancelled');
                session()->flash('success', 'Order #' . $this->order->order_number . ' has been cancelled.');
                
                // Refresh order data
                $this->order = $this->order->fresh();
            } else {
                session()->flash('error', 'Cannot cancel this order.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error cancelling order: ' . $e->getMessage());
        }
    }

    public function backToOrders()
    {
        return redirect()->route('seller.orders');
    }
}