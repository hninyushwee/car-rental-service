<?php

namespace App\Http\Controllers\View\Admin;

class StaffController
{
    public function index()
    {
        return view('admin.staff.index');
    }

    public function create()
    {
        return view('admin.staff.form', [
            'staffId' => null,
            'isEdit' => false,
        ]);
    }

    public function edit(string $id)
    {
        return view('admin.staff.form', [
            'staffId' => $id,
            'isEdit' => true,
        ]);
    }
}
