<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class AddProduct extends Component
{
    use WithFileUploads;

    // Form properties
    public $name = '';
    public $category = '';
    public $price = '';
    public $description = '';
    public $image;

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

    // Real-time validation
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.seller.add-product')
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

            // Success message
            session()->flash('success', 'Product added successfully!');

            // Reset form
            $this->resetForm();

        } catch (\Exception $e) {
            session()->flash('error', 'Error adding product: ' . $e->getMessage());
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

    // Helper method for formatted price in preview
    public function getFormattedPriceProperty()
    {
        return $this->price ? 'Rs. ' . number_format($this->price, 2) : 'Rs. 0.00';
    }
}