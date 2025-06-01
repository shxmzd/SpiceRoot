<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class Dashboard extends Component
{
    // Notifications
    public $notificationCount = 0;
    public $recentNotifications = [];
    use WithFileUploads;

    // Form properties
    public $name = '';
    public $category = '';
    public $price = '';
    public $description = '';
    public $image;

    // Product list
    public $products = [];

    // Categories
    public $categories = [
        'Whole Spices',
        'Ground Spices', 
        'Fresh Herbs',
        'Dried Herbs',
        'Seeds',
        'Roots & Rhizomes'
    ];

    // Validation rules
    protected $rules = [
        'name' => 'required|string|max:255',
        'category' => 'required|string',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string|max:1000',
        'image' => 'nullable|image|max:2048', // 2MB max
    ];

    // Real-time validation messages
    protected $messages = [
        'name.required' => 'Product name is required.',
        'category.required' => 'Please select a category.',
        'price.required' => 'Price is required.',
        'price.numeric' => 'Price must be a valid number.',
        'description.required' => 'Product description is required.',
        'image.image' => 'Please upload a valid image file.',
        'image.max' => 'Image size should not exceed 2MB.',
    ];

    public function mount()
    {
        $this->loadProducts();
        $this->loadNotifications();
    }
    public function loadNotifications()
    {
        $sellerId = auth()->id();
        $this->notificationCount = \App\Models\SellerNotification::unreadCount($sellerId);
        $this->recentNotifications = \App\Models\SellerNotification::recent($sellerId, 5);
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = \App\Models\SellerNotification::where('_id', $notificationId)
            ->where('seller_id', auth()->id())
            ->first();
        if ($notification && !$notification->is_read) {
            $notification->markAsRead();
            $this->loadNotifications();
        }
    }

    public function render()
    {
        return view('livewire.seller.dashboard')
            ->layout('layouts.seller');
    }

    public function addProduct()
    {
        $this->validate();

        try {
            $imagePath = null;
            
            // Handle image upload
            if ($this->image) {
                $imagePath = $this->image->store('products', 'public');
            }

            // Create product
            Product::create([
                'name' => $this->name,
                'category' => $this->category,
                'price' => $this->price,
                'description' => $this->description,
                'image' => $imagePath,
                'seller_id' => auth()->id(),
                'status' => 'active'
            ]);

            // Reset form
            $this->resetForm();
            
            // Reload products
            $this->loadProducts();

            // Success message
            session()->flash('success', 'Product added successfully!');

        } catch (\Exception $e) {
            session()->flash('error', 'Error adding product: ' . $e->getMessage());
        }
    }

    public function deleteProduct($productId)
    {
        try {
            $product = Product::where('_id', $productId)
                             ->where('seller_id', auth()->id())
                             ->first();

            if ($product) {
                // Delete image if exists
                if ($product->image && Storage::disk('public')->exists($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $product->delete();
                $this->loadProducts();
                session()->flash('success', 'Product deleted successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->category = '';
        $this->price = '';
        $this->description = '';
        $this->image = null;
    }

    private function loadProducts()
    {
        $this->products = Product::bySeller(auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->get();
    }
}