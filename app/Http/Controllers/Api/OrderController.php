<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Requests\Orders\CreateOrderValidator;
use App\Requests\Orders\UpdateOrderValidator;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends BaseController
{
    public OrderService $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $page = $request->query('page', 1);
        $size = $request->query('size', 10);
        $orders = $this->orderService->getOrders($page , $size);
        return $this->sendResponse($orders, 'Orders retrieved successfully.' , Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderValidator $request)
    {
        //
        if (!empty($request->getErrors())){
            return response()->json($request->getErrors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $order = $this->orderService->createOrder($request->request->all());
        return $this->sendResponse($order);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
        $retrieved_order = $this->orderService->getOrderById($order->id);
        return $this->sendResponse($retrieved_order);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderValidator $request, Order $order)
    {
        //
        if (!empty($request->getErrors())){
            return response()->json($request->getErrors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $order = $this->orderService->updateOrder( $order ,$request->request->all());
        return $this->sendResponse($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
        if ($this->orderService->deleteOrder($order)){
            return $this->sendResponse(null, 'Order deleted successfully.');
        }
        return  $this->sendResponse(null, 'Order can not be deleted.', Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
