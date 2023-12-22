<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\On;

class Shop extends Component
{
    public $products = [];

    public function mount(): void
    {
        $this->products = Product::all();
    }

    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.shop');
    }

    public function addToCart($id)
    {
        if (!Auth::id()) {
            return $this->redirect("/login");
        }
        // Validate Product existence
        $product = Product::query()->find($id);
        if (!$product) {
//
            return;
        }
        // validate Quantity
        if ($product->stock_quantity <= 0) {
            // Show errror for item is out of stock
            return;
        }
        $item = Cart::query()->firstOrCreate([
            'user_id' => Auth::id(),
            "product_id" => $id
        ]);
        if (!$item->wasRecentlyCreated) {
            $item->increment('quantity');
        }
        $this->dispatch('ItemAddedEvent');
    }

}
