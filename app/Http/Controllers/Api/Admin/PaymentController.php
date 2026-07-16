<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Repositories\Interface\PaymentInterface;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentInterface $paymentRepo) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $filters = $request->only(['search', 'status', 'payment_method', 'year', 'month', 'day']);

        return $this->successResponse($this->paymentRepo->all($perPage, $filters));
    }

    public function store(PaymentRequest $request)
    {
        $payment = $this->paymentRepo->create($request->validated());

        return $this->successResponse($payment->load('user'), 'Payment recorded successfully', 201);
    }

    public function show($payment)
    {
        return $this->successResponse($this->paymentRepo->findById($payment));
    }

    public function update(PaymentRequest $request, $payment)
    {
        $updated = $this->paymentRepo->update($payment, $request->validated());

        if (! $updated) {
            return $this->errorResponse('Payment not found', 404);
        }

        return $this->successResponse($updated->fresh()->load('user'), 'Payment updated successfully');
    }

    public function destroy($payment)
    {
        $deleted = $this->paymentRepo->delete($payment);

        if (! $deleted) {
            return $this->errorResponse('Payment not found', 404);
        }

        return $this->successResponse(null, 'Payment deleted successfully');
    }
}
