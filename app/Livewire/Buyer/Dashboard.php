<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use App\Models\RecentlyViewed;
use App\Models\Cart as CartModel;
use App\Models\Wishlist as WishlistModel;

class Dashboard extends Component
{
    public $recentlyViewedProducts = [];
   
    // Signature collection categories with sample data
    public $signatureCollection = [
        [
            'name' => 'Whole Spices',
            'image' => 'categories/whole-spices.jpg',
            'description' => 'Premium whole spices for authentic flavors',
            'category' => 'Whole Spices'
        ],
        [
            'name' => 'Ground Spices', 
            'image' => 'categories/ground-spices.jpg',
            'description' => 'Freshly ground spices for convenience',
            'category' => 'Ground Spices'
        ],
        [
            'name' => 'Fresh Herbs',
            'image' => 'categories/fresh-herbs.jpg', 
            'description' => 'Garden-fresh herbs for vibrant dishes',
            'category' => 'Fresh Herbs'
        ],
        [
            'name' => 'Dried Herbs',
            'image' => 'categories/dried-herbs.jpg',
            'description' => 'Carefully dried herbs with concentrated flavors',
            'category' => 'Dried Herbs'
        ],
        [
            'name' => 'Seeds',
            'image' => 'categories/seeds.jpg',
            'description' => 'Aromatic seeds for seasoning and garnishing',
            'category' => 'Seeds'
        ],
        [
            'name' => 'Roots & Rhizomes',
            'image' => 'categories/roots-rhizomes.jpg',
            'description' => 'Traditional roots for medicinal and culinary use',
            'category' => 'Roots & Rhizomes'
        ]
    ];

    public function mount()
    {
        $this->loadRecentlyViewedProducts();
    }

    public function render()
    {
        return view('livewire.buyer.dashboard')->layout('layouts.app');
    }

    public function loadRecentlyViewedProducts()
    {
        $this->recentlyViewedProducts = RecentlyViewed::getRecentlyViewedProducts(auth()->id(), 6);
    }

    public function discoverNow()
    {
        // Placeholder for discover functionality
        return redirect()->route('buyer.shop');
    }

    public function exploreCategory($category)
    {
        // Redirect to shop with category filter
        return redirect()->route('buyer.shop', ['category' => $category]);
    }

    public function addToCart($productId)
    {
        try {
            $result = CartModel::addToCart(auth()->id(), $productId, 1);
            
            if ($result['success']) {
                session()->flash('success', $result['message']);
                // Dispatch event to update cart count in navigation
                $this->dispatch('cart-updated');
            } else {
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add item to cart. Please try again.');
        }
    }

    public function addToWishlist($productId)
    {
        try {
            $result = WishlistModel::addToWishlist(auth()->id(), $productId);
            
            if ($result['success']) {
                session()->flash('success', $result['message']);
                // Dispatch event to update wishlist count in navigation
                $this->dispatch('wishlist-updated');
            } else {
                session()->flash('error', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add item to wishlist. Please try again.');
        }
    }
}