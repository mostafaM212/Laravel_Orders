<?php

namespace App\Services;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    private ProductService $productService;
    public function __construct(productService $productService){
        $this->productService = $productService;
    }
    public function getOrderById($id)
    {
        return Order::with('user')->find($id);
    }
    public function getOrders($page = 1  , $size = 10)
    {
        $orders = Order::paginate($size, ['*'], 'page', $page);
        return $orders;
    }
    public function createOrder($data)
    {
        $data['user_id'] = Auth::id();
        $data['total_items'] = count($data['products']);
        $order = Order::create($data);
        $totalSumOfOrder = 0;
        foreach ($data['products'] as $product){
            $storedProduct = $this->productService->getProductById($product['id']);
            $productTotal = $storedProduct->price * $product['quantity'];
            $totalSumOfOrder += $productTotal;
            if ($product['quantity'] > $storedProduct->quantity){
                return response()->json([
                    'errors' => [
                        'products' => ["Quantity for product {$storedProduct->name} exceeds available stock."]
                    ]
                ], 422);
            }else{
                $storedProduct->quantity -= $product['quantity'];
                $storedProduct->save();
            }
            $order->products()->attach($storedProduct->id , [
                'quantity' => $product['quantity'],
                'total' => $productTotal
            ]);
        }
        $order->total = $totalSumOfOrder;
        $order->save();
        $order = Order::with('products')->find($order->id);
        return $order;
    }
    public function updateOrder($order,$data)
    {

        $syncData = [];
        foreach ($data['products'] as $product) {
            $storedProduct = $this->productService->getProductById($product['id']);
            $productTotal = $storedProduct->price * $product['quantity'];
            $syncData[$product['id']] = [
                'quantity' => $product['quantity'],
                'total' => $productTotal
            ];
        }
        $order->products()->sync($syncData);

        $order->save();
        $order = Order::with('products')->find($order->id);
        return $order;
    }
    public function deleteOrder(Order $order)
    {
        if ($order->payment()->first() == null){
            $order->delete();
            return true;
        }else{
            return false;
        }

    }
}
