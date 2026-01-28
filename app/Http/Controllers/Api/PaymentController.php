<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;

use App\Requests\Payments\CreatePaymentsValidator;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends BaseController
{
    public PaymentService $paymentService;
    public function __construct(PaymentService $paymentService){
        $this->paymentService = $paymentService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $page = $request->query('page', 1);
        $size = $request->query('size', 10);
        $payments = $this->paymentService->getPayments($page , $size);
        return $this->sendResponse($payments );
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePaymentsValidator $request)
    {
        //
        if (!empty($request->getErrors())){
            return response()->json($request->getErrors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $data = $this->paymentService->createPayment($request->request->all());
        return $this->sendResponse($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
//        $retrieved = $this->paymentService->getPaymentById($payment->id);
        return $this->sendResponse('asdasdsa');
    }


}
