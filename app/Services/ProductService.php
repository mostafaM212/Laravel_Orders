<?php

namespace App\Services;

use App\Events\NewProductEvent;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class ProductService
{
    public function getProductById($id)
    {
        return Product::with('user')->find($id);
    }
    public function getProducts($page = 1  , $size = 10)
    {
        $products = Product::paginate($size, ['*'], 'page', $page);
        return $products;
    }
    public function createProduct($data)
    {
        $data['user_id'] = Auth::id();
        $product = Product::create($data);
        return $product;
    }
    public function updateProduct($id,$data)
    {

        $product = $this->getProductById($id);
        $product->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        $product->save();
        return $product;
    }
    public function deleteProduct($id)
    {
        $product = $this->getProductById($id);
        return $product->delete();
    }
}
