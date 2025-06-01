<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use App\Models\Cart as CartModel;

class Cart extends Component
{
    public $cartItems = [];
    public $cartSummary = [];

    public function mount()
    {
        $this->loadCart();
    }

    public function render()
    {
        return view('livewire.buyer.cart')->layout('layouts.app');
    }

    public function loadCart()
    {
        $this->cartItems = CartModel::getCartItems(auth()->id());
        $this->cartSummary = CartModel::getCartTotal(auth()->id());
    }

    public function updateQuantity($cartItemId, $newQuantity)
    {
        try {
            $cartItem = CartModel::where('user_id', auth()->id())
                                 ->where('_id', $cartItemId)
                                 ->first();

            if ($cartItem) {
                if ($newQuantity <= 0) {
                    $this->removeItem($cartItemId);
                } else {
                    $cartItem->updateQuantity($newQuantity);
                    $this->loadCart();
                    session()->flash('success', 'Quantity updated successfully!');
                }
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating quantity: ' . $e->getMessage());
        }
    }

    public function removeItem($cartItemId)
    {
        try {
            CartModel::removeFromCart(auth()->id(), $cartItemId);
            $this->loadCart();
            session()->flash('success', 'Item removed from cart!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error removing item: ' . $e->getMessage());
        }
    }

    public function proceedToCheckout()
    {
        if ($this->cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }
        
        return redirect()->route('buyer.checkout');
    }

    public function continueShopping()
    {
        return redirect()->route('buyer.shop');
    }
}