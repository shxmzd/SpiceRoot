<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Shop extends Component
{
    use WithPagination;

    // Search and Filter properties
    public $search = '';
    public $selectedCategory = '';
    public $selectedPriceRange = '';
    public $sortBy = '';

    // Categories
    public $categories = [
        'Whole Spices',
        'Ground Spices', 
        'Fresh Herbs',
        'Dried Herbs',
        'Seeds',
        'Roots & Rhizomes'
    ];

    // Price ranges
    public $priceRanges = [
        'under-500' => 'Under Rs. 500',
        '500-1000' => 'Rs. 500 - 1000',
        '1000-2000' => 'Rs. 1000 - 2000',
        'over-2000' => 'Over Rs. 2000'
    ];

    // Sort options
    public $sortOptions = [
        'newest' => 'Newest First',
        'price-low-high' => 'Price: Low to High',
        'price-high-low' => 'Price: High to Low',
        'name-asc' => 'Name: A to Z',
        'name-desc' => 'Name: Z to A'
    ];

    // Reset pagination when filters change
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function updatingSelectedPriceRange()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = $this->getFilteredProducts();
        foreach ($products as $product) {
            // Use string cast for MongoDB _id and format to 1 decimal place for consistency
            $product->average_rating = number_format(\App\Models\Review::getProductAverageRating((string)$product->_id), 1);
        }
        return view('livewire.buyer.shop', [
            'products' => $products
        ])->layout('layouts.app');
    }

    private function getFilteredProducts()
    {
        $query = Product::where('status', 'active');

        // Apply search filter
        if (!empty($this->search)) {
            $query->where('name', 'regex', "/{$this->search}/i");
        }

        // Apply category filter
        if (!empty($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }

        // Apply price range filter
        if (!empty($this->selectedPriceRange)) {
            switch ($this->selectedPriceRange) {
                case 'under-500':
                    $query->where('price', '<', 500);
                    break;
                case '500-1000':
                    $query->where('price', '>=', 500)->where('price', '<=', 1000);
                    break;
                case '1000-2000':
                    $query->where('price', '>=', 1000)->where('price', '<=', 2000);
                    break;
                case 'over-2000':
                    $query->where('price', '>', 2000);
                    break;
            }
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'price-low-high':
                $query->orderBy('price', 'asc');
                break;
            case 'price-high-low':
                $query->orderBy('price', 'desc');
                break;
            case 'name-asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name-desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->with('seller')->paginate(12);
    }


    public function addToCart($productId)
    {
        try {
            $cartItem = \App\Models\Cart::addToCart(auth()->id(), $productId, 1);
            
            if ($cartItem) {
                session()->flash('success', 'Product added to cart successfully!');
                // Dispatch browser event to update cart count in navigation
                $this->dispatch('cart-updated');
            } else {
                session()->flash('error', 'Product not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding to cart: ' . $e->getMessage());
        }
    }

    public $userWishlistProductIds = [];

    public function mount()
    {
        $this->loadUserWishlistIds();
    }

    private function loadUserWishlistIds()
    {
        $this->userWishlistProductIds = \App\Models\Wishlist::getUserWishlistProductIds(auth()->id());
    }

    public function addToWishlist($productId)
    {
        try {
            $result = \App\Models\Wishlist::addToWishlist(auth()->id(), $productId);
            
            if ($result['success']) {
                $this->loadUserWishlistIds();
                session()->flash('success', $result['message']);
                $this->dispatch('wishlist-updated');
            } else {
                session()->flash('info', $result['message']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding to wishlist: ' . $e->getMessage());
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedCategory = '';
        $this->selectedPriceRange = '';
        $this->sortBy = '';
        $this->resetPage();
    }
}