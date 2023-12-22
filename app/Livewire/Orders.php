<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component
{
    /**
     * @var \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private array|\Illuminate\Database\Eloquent\Collection $orders;

    public function mount()
    {
        $this->orders = Order::query()->where('user_id',Auth::id())->get();
    }
    public function render()
    {
        return view('livewire.orders');
    }
}
