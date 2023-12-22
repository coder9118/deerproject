<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    public $items;
    public $subtotal = 0;
    public $shipping = 10.50;
    public $total = 0;

    public function mount(): void
    {
        $this->fetchCartItem();
    }
    public function render()
    {
        return view('livewire.cart');
    }
    public function decrease($product_id): void
    {
        \App\Models\Cart::query()
            ->where("user_id", Auth::id())
            ->where("product_id", $product_id)
            ->decrement('quantity');
        $this->fetchCartItem();
    }

    public function increase($product_id,$quantity): void
    {
        // Validate for available product
        if(!$this->checkForAvailability($product_id,$quantity)){
            // display error

            return;
        }
        \App\Models\Cart::query()
            ->where("user_id", Auth::id())
            ->where("product_id", $product_id)
            ->increment('quantity');
        $this->fetchCartItem();
    }

    public function remove($product_id): void
    {
        \App\Models\Cart::query()
            ->where("user_id", Auth::id())
            ->where("product_id", $product_id)
            ->first()->delete();
        $this->fetchCartItem();
        $this->dispatch('ItemAddedEvent');
    }
    private function fetchCartItem(): void
    {
        $this->items = \App\Models\Cart::query()
            ->where("user_id", Auth::id())
            ->with('product')
            ->get();
        foreach ($this->items as $item) {
            $this->subtotal += $item->product->offer_price * $item->quantity;
        }
        $this->total += $this->shipping + $this->subtotal;
    }

    private function checkForAvailability($product_id, $quantity): bool
    {
        $product = Product::find($product_id);
        return $product->stock_quantity >= $quantity + 1;
    }
}
