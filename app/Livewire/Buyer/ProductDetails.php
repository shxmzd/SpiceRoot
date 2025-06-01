<?php

namespace App\Livewire\Buyer;

use Livewire\Component;

use App\Models\Product;
use App\Models\RecentlyViewed;

class ProductDetails extends Component
{
    public $product;
    public $productId;


    public function mount($id)
    {
        $this->productId = $id;
        $this->product = Product::with('seller')->where('_id', $id)->where('status', 'active')->first();
        
        if (!$this->product) {
            abort(404, 'Product not found');
        }

        // Track this product as viewed
        RecentlyViewed::trackView(auth()->id(), $this->product->_id);
    }

    public function render()
    {
        $reviews = \App\Models\Review::getProductReviews($this->product->_id);
        $averageRating = \App\Models\Review::getProductAverageRating($this->product->_id);
        return view('livewire.buyer.product-details', [
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ])->layout('layouts.app');
    }

    public function addToCart()
    {
        try {
            $cartItem = \App\Models\Cart::addToCart(auth()->id(), $this->product->_id, 1);
            
            if ($cartItem) {
                session()->flash('success', 'Product added to cart successfully!');
            } else {
                session()->flash('error', 'Error adding product to cart.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding to cart: ' . $e->getMessage());
        }
    }

    public function addToWishlist()
    {
        try {
            $result = \App\Models\Wishlist::addToWishlist(auth()->id(), $this->product->_id);
            
            if ($result['success']) {
                session()->flash('success', $result['message']);
                $this->dispatch('wishlist-updated');
            } else {
                session()->flash('info', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding to wishlist: ' . $e->getMessage());
        }
    }
}