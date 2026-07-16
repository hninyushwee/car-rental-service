<?php

namespace App\Http\Controllers\View\Admin;

class DepositSettingController
{
    public function index()
    {
        return view('admin.deposit_settings.index');
    }

    public function create()
    {
        return view('admin.deposit_settings.create', [
            'depositSettingId' => null,
            'isEdit' => false,
        ]);
    }

    public function edit(string $id)
    {
        return view('admin.deposit_settings.create', [
            'depositSettingId' => $id,
            'isEdit' => true,
        ]);
    }
}
