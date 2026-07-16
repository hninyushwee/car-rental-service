<?php

namespace App\Http\Controllers\View\Admin;

class InquiryController
{
    public function index()
    {
        return view('admin.inquiries.index');
    }

    public function show(string $id)
    {
        return view('admin.inquiries.show', ['inquiryId' => $id]);
    }
}
