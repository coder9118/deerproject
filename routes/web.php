<?php

use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Route;

Route::get("/", [CommonController::class, "home"])->name('home');
Route::middleware(['auth'])->group(function (){
    Route::get("shop", [CommonController::class,'shop'])->name('shop');
    Route::get("order", [CommonController::class,'order'])->name('order');
    Route::get("cart",[CommonController::class,"cart"] )->name('cart');
    Route::get("checkout", [CommonController::class, "checkout"])->name('checkout');
    Route::view('profile', 'profile')->name('profile');
});

require __DIR__ . '/auth.php';
