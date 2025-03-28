<?php

namespace App\Http\Controllers\Management;

use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
    	$payments = $this->paymentService->getAllPayments();
    	return $payments;
    }























    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required|integer',
            'amount' => 'required|numeric',
            'price_per_day' => 'required|numeric',
            'payment_method' => 'required|string',
            'status' => 'required|string|in:pending,completed,failed',
        ]);

        $payment = $this->paymentService->createPayment($validatedData);

        return response()->json($payment, 201);
    }





























    public function show($id)
    {
        $payment = $this->paymentService->getPaymentById($id);

        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'amount' => 'sometimes|numeric',
            'price_per_day' => 'sometimes|numeric',
            'payment_method' => 'sometimes|string',
            'status' => 'sometimes|string|in:pending,completed,failed',
        ]);

        $payment = $this->paymentService->updatePayment($id, $validatedData);

        return response()->json($payment);
    }






















    

    public function destroy($id)
    {
        $this->paymentService->deletePayment($id);

        return response()->json(['message' => 'Payment deleted successfully.'], 200);
    }
}
