<?php

namespace App\Services;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentService
{
    private ProductService $productService;
    private PaypalService $payPalClientService;
    public function __construct(productService $productService ,PaypalService $payPalClientService ){
        $this->productService = $productService;
        $this->payPalClientService = $payPalClientService;
    }
    public function getPaymentById($id)
    {
        return Payment::with(['user' , 'order'])->find($id);
    }
    public function getPayments($page = 1  , $size = 10)
    {
        $payments = Payment::with(['user' , 'order'])->paginate($size, ['*'], 'page', $page);
        return $payments;
    }
    public function createPayment($data)
    {
        $data['user_id'] = Auth::id();
        $data['payment_method'] = 'paypal';
        $data['transaction_id'] = null;
    $userOrder = Order::where('user_id', $data['user_id'])
            ->orderBy('created_at', 'desc')
            ->first();
        ;
        if($data['payment_method'] == 'paypal'){
             $pay = $this->payPalClientService->pay($userOrder->total);
            $data['transaction_id'] = $pay['id'];
        }

        $data['amount'] = $userOrder['total'];
        $data['status'] = 'successful';
        $userOrder->status = 'confirmed';
        $payment =   $userOrder->payment()->create($data);
        $payment->transaction_id = $data['transaction_id'];
        $payment->save();
        $userOrder->save();


        $payment = Payment::with('order')->find($payment->id);
        return $payment;
    }

}
