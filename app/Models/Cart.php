<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;
    public $guarded = [];


    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->hasOne(Product::class,"id","product_id");
    }
}
