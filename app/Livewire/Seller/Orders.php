<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;

class Orders extends Component
{
    // Livewire pagination property
    public $page = 1;
    use WithPagination;

    // Filter properties
    public $statusFilter = '';
    public $searchTerm = '';
    public $dateFrom = '';
    public $dateTo = '';

    // Status options
    public $statusOptions = [
        '' => 'All Orders',
        'pending' => 'Pending',
        'confirmed' => 'Confirmed', 
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled'
    ];

    // Reset pagination when filters change
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function render()
    {
        $orders = $this->getFilteredOrders();
        $newOrdersCount = Order::getNewOrdersCount(auth()->id());

        return view('livewire.seller.orders', [
            'orders' => $orders,
            'newOrdersCount' => $newOrdersCount
        ])->layout('layouts.seller');

    }

    private function getFilteredOrders()
    {
        $sellerId = auth()->id();
        $ordersCollection = Order::getSellerOrders(
            $sellerId,
            $this->statusFilter ?: null,
            $this->searchTerm ?: null,
            $this->dateFrom ?: null,
            $this->dateTo ?: null
        );

        // Manual pagination since we're working with a collection
        $perPage = 12;
        $currentPage = $this->page;
        $total = $ordersCollection->count();
        
        // Calculate offset and slice the collection
        $offset = ($currentPage - 1) * $perPage;
        $items = $ordersCollection->slice($offset, $perPage)->values();
        
        // Create a paginator manually
        $paginator = new \Illuminate\Pagination\LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => request()->url(),
                'pageName' => 'page',
            ]
        );
        
        return $paginator;
    }

    public function shipOrder($orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if ($order && $order->canBeShippedBySeller(auth()->id())) {
                $order->updateStatus('shipped');
                session()->flash('success', 'Order #' . $order->order_number . ' marked as shipped!');
            } else {
                session()->flash('error', 'Cannot ship this order.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function deliverOrder($orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if ($order && $order->canBeDeliveredBySeller(auth()->id())) {
                $order->updateStatus('delivered');
                session()->flash('success', 'Order #' . $order->order_number . ' marked as delivered!');
            } else {
                session()->flash('error', 'Cannot mark this order as delivered.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function cancelOrder($orderId)
    {
        try {
            $order = Order::find($orderId);
            
            if ($order && $order->canBeCancelledBySeller(auth()->id())) {
                $order->updateStatus('cancelled');
                session()->flash('success', 'Order #' . $order->order_number . ' has been cancelled.');
            } else {
                session()->flash('error', 'Cannot cancel this order.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error cancelling order: ' . $e->getMessage());
        }
    }

    public function clearFilters()
    {
        $this->statusFilter = '';
        $this->searchTerm = '';
        $this->dateFrom = '';
        $this->dateTo = '';
        $this->resetPage();
    }
}