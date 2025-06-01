<?php

namespace App\Livewire\Buyer;

use Livewire\Component;
use App\Models\Cart as CartModel;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class Checkout extends Component
{
    // Cart data
    public $cartItems = [];
    public $cartSummary = [];

    // Delivery information
    public $full_name = '';
    public $email = '';
    public $phone = '';
    public $street_address = '';
    public $city = '';
    public $postal_code = '';
    public $delivery_notes = '';

    // Stripe
    public $clientSecret = '';
    public $paymentStatus = '';

    // Validation rules
    protected $rules = [
        'full_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:20',
        'street_address' => 'required|string|max:500',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:20',
        'delivery_notes' => 'nullable|string|max:500'
    ];

    protected $messages = [
        'full_name.required' => 'Full name is required.',
        'email.required' => 'Email address is required.',
        'email.email' => 'Please enter a valid email address.',
        'phone.required' => 'Phone number is required.',
        'street_address.required' => 'Street address is required.',
        'city.required' => 'City is required.',
        'postal_code.required' => 'Postal code is required.'
    ];

    public function mount()
    {
        $this->loadCart();
        
        // Check if cart is empty
        if ($this->cartItems->isEmpty()) {
            session()->flash('error', 'Your cart is empty.');
            return redirect()->route('buyer.cart');
        }

        // Pre-fill user data
        $user = auth()->user();
        $this->email = $user->email;
        $this->full_name = $user->name;

        $this->createPaymentIntent();
    }

    public function render()
    {
        return view('livewire.buyer.checkout')->layout('layouts.app');
    }

    public function loadCart()
    {
        $this->cartItems = CartModel::getCartItems(auth()->id());
        $this->cartSummary = CartModel::getCartTotal(auth()->id());
    }

    public function createPaymentIntent()
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $this->cartSummary['total'] * 100, // Convert to cents
                'currency' => 'usd', // Change to USD for testing (LKR has limited support)
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'user_id' => auth()->id(),
                    'order_type' => 'spice_purchase'
                ]
            ]);

            $this->clientSecret = $paymentIntent->client_secret;
        } catch (\Exception $e) {
            session()->flash('error', 'Error setting up payment: ' . $e->getMessage());
        }
    }

        public function processPayment($paymentIntentId = null)
    {
        $this->validate();

        try {
            // Create delivery info array
            $deliveryInfo = [
                'full_name' => $this->full_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'street_address' => $this->street_address,
                'city' => $this->city,
                'postal_code' => $this->postal_code,
                'delivery_notes' => $this->delivery_notes
            ];

            // Create order
            $order = Order::createFromCart(auth()->id(), $deliveryInfo, $paymentIntentId);

            if ($order) {
                // Notify all sellers in the order
                \App\Models\SellerNotification::notifyNewOrder($order);

                // Clear cart after successful order creation
                CartModel::where('user_id', auth()->id())->delete();

                // Update order status to completed
                $order->updatePaymentStatus('completed', $paymentIntentId);

                // Redirect to success page
                return redirect()->route('buyer.checkout.success', ['order' => $order->order_number]);
            } else {
                session()->flash('error', 'Error creating order. Please try again.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error processing payment: ' . $e->getMessage());
        }
    }

    public function backToCart()
    {
        return redirect()->route('buyer.cart');
    }
}