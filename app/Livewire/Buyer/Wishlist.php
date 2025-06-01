<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use App\Models\Wishlist as WishlistModel;

class Wishlist extends Component
{
    public $wishlistItems = [];

    public function mount()
    {
        $this->loadWishlist();
    }

    public function render()
    {
        return view('livewire.buyer.wishlist')->layout('layouts.app');
    }

    public function loadWishlist()
    {
        $this->wishlistItems = WishlistModel::getWishlistItems(auth()->id());
    }

    public function addToCart($productId)
    {
        try {
            $result = WishlistModel::moveToCart(auth()->id(), $productId);
            
            if ($result['success']) {
                $this->loadWishlist();
                session()->flash('success', $result['message']);
                // Dispatch event to update cart count in navigation
                $this->dispatch('cart-updated');
                $this->dispatch('wishlist-updated');
            } else {
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error moving to cart: ' . $e->getMessage());
        }
    }

    public function removeFromWishlist($productId)
    {
        try {
            WishlistModel::removeFromWishlist(auth()->id(), $productId);
            $this->loadWishlist();
            session()->flash('success', 'Item removed from wishlist!');
            $this->dispatch('wishlist-updated');
        } catch (\Exception $e) {
            session()->flash('error', 'Error removing item: ' . $e->getMessage());
        }
    }

    public function continueShopping()
    {
        return redirect()->route('buyer.shop');
    }
}