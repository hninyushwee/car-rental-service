<?php

namespace App\Http\Controllers\View\Admin;

class PaymentController
{
    public function index()
    {
        return view('admin.payments.index');
    }

    public function show(string $id)
    {
        return view('admin.payments.show', ['paymentId' => $id]);
    }
}
