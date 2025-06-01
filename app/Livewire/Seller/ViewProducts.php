<?php

namespace App\Livewire\Seller;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ViewProducts extends Component
{
    use WithPagination, WithFileUploads;

    // Search and Filter properties
    public $search = '';
    public $selectedCategory = '';

    // Edit Modal properties
    public $showEditModal = false;
    public $editingProduct = null;
    public $editName = '';
    public $editCategory = '';
    public $editPrice = '';
    public $editDescription = '';
    public $editImage = null;
    public $currentImage = '';

    // Categories
    public $categories = [
        'Whole Spices',
        'Ground Spices', 
        'Fresh Herbs',
        'Dried Herbs',
        'Seeds',
        'Roots & Rhizomes'
    ];

    // Validation rules for editing
    protected $rules = [
        'editName' => 'required|string|max:255',
        'editCategory' => 'required|string',
        'editPrice' => 'required|numeric|min:0',
        'editDescription' => 'required|string|max:1000',
        'editImage' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'editName.required' => 'Product name is required.',
        'editCategory.required' => 'Please select a category.',
        'editPrice.required' => 'Price is required.',
        'editPrice.numeric' => 'Price must be a valid number.',
        'editDescription.required' => 'Product description is required.',
        'editImage.image' => 'Please upload a valid image file.',
        'editImage.max' => 'Image size should not exceed 2MB.',
    ];

    // Reset pagination when search/filter changes
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = $this->getFilteredProducts();
        
        return view('livewire.seller.view-products', [
            'products' => $products
        ])->layout('layouts.seller');

    }

    private function getFilteredProducts()
    {
        $query = Product::bySeller(auth()->id());

        // Apply search filter
        if (!empty($this->search)) {
            $query->where('name', 'regex', "/{$this->search}/i");
        }

        // Apply category filter
        if (!empty($this->selectedCategory)) {
            $query->where('category', $this->selectedCategory);
        }

        return $query->orderBy('created_at', 'desc')->paginate(12);
    }

    public function openEditModal($productId)
    {
        $product = Product::where('_id', $productId)
                         ->where('seller_id', auth()->id())
                         ->first();

        if ($product) {
            $this->editingProduct = $product;
            $this->editName = $product->name;
            $this->editCategory = $product->category;
            $this->editPrice = $product->price;
            $this->editDescription = $product->description;
            $this->currentImage = $product->image;
            $this->editImage = null;
            $this->showEditModal = true;
        }
    }

    public function closeEditModal()
    {
        $this->showEditModal = false;
        $this->editingProduct = null;
        $this->resetEditForm();
        $this->resetValidation();
    }

    public function updateProduct()
    {
        $this->validate();

        try {
            $updateData = [
                'name' => $this->editName,
                'category' => $this->editCategory,
                'price' => $this->editPrice,
                'description' => $this->editDescription,
            ];

            // Handle image upload if new image provided
            if ($this->editImage) {
                // Delete old image if exists
                if ($this->currentImage && Storage::disk('public')->exists($this->currentImage)) {
                    Storage::disk('public')->delete($this->currentImage);
                }
                
                $updateData['image'] = $this->editImage->store('products', 'public');
            }

            $this->editingProduct->update($updateData);

            session()->flash('success', 'Product updated successfully!');
            $this->closeEditModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Error updating product: ' . $e->getMessage());
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
                session()->flash('success', 'Product deleted successfully!');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    private function resetEditForm()
    {
        $this->editName = '';
        $this->editCategory = '';
        $this->editPrice = '';
        $this->editDescription = '';
        $this->editImage = null;
        $this->currentImage = '';
    }
}