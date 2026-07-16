<?php

namespace App\Http\Controllers\View\Admin;

class CustomerController
{
    public function index()
    {
        return view('admin.customers.index');
    }

    public function show(string $id)
    {
        return view('admin.customers.show', ['customerId' => $id]);
    }
}
