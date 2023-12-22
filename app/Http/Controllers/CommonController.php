<?php

namespace App\Http\Controllers;

use App\Events\OrderPlacedEvent;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommonController extends Controller
{
    public function home()
    {
        return view("home");
    }

    public function shop()
    {
        return view("shop");
    }

    public function cart()
    {
        return view("cart");
    }

    public function order()
    {
        return view("order");
    }
    public function checkout(Request $request)
    {
        $order = Order::query()->create([
            "user_id" => Auth::id(),
            "total_amount" => $this->calculateCheckoutAmount() // will be cross check with payment provider in production, for development just calculating cart amount
        ]);
        // Clear Cart
        Cart::query()->where('user_id', Auth::id())->delete();
        OrderPlacedEvent::dispatch(Auth::user(), $order);
        return view("checkout");
    }

    public function calculateCheckoutAmount()
    {
        $subtotal = 0;
        $items = Cart::query()
            ->where("user_id", Auth::id())
            ->with('product')
            ->get();
        foreach ($items as $item) {
            $subtotal += $item->product->offer_price * $item->quantity;
        }
        return $subtotal;
    }
}
