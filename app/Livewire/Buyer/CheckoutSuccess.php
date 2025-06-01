<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use App\Models\Order;

class CheckoutSuccess extends Component
{
    public $order;

    public function mount($order)
    {
        $this->order = Order::where('order_number', $order)
                           ->where('user_id', auth()->id())
                           ->first();

        if (!$this->order) {
            abort(404, 'Order not found');
        }
    }

    public function render()
    {
        return view('livewire.buyer.checkout-success')->layout('layouts.app');
    }

    public function continueShopping()
    {
        return redirect()->route('buyer.shop');
    }

    public function viewDashboard()
    {
        return redirect()->route('buyer.dashboard');
    }
}