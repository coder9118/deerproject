<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = Http::get("https://fakestoreapi.com/products")->json();
        foreach ($data as $p){
            Product::query()->create([
               "title" => $p["title"],
                "description" => $p["description"],
                "image"=>$p["image"],
                "category"=>$p["category"],
                "price"=>$p["price"],
                "offer_price" => $p["price"] + random_int(10,100),
                "stock_quantity"=>random_int(3,100),
            ]);
        }
    }
}
