<?php

namespace App\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    private int $total;

    public function mount(): void
    {
        $this->total = Cart::query()->where("user_id", Auth::id())->count();
    }
    #[On('ItemAddedEvent')]
    public function itemAdded(): void
    {
        $this->total = Cart::query()->where("user_id", Auth::id())->count();
    }
    public function render()
    {
        return view('livewire.cart-counter');
    }
}
