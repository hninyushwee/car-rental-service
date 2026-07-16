<?php

namespace App\Http\Controllers\View\Admin;

class PromotionController
{
    public function index()
    {
        return view('admin.promotions.index');
    }

    public function create()
    {
        return view('admin.promotions.create', [
            'promotionId' => null,
            'isEdit' => false,
        ]);
    }

    public function show(string $id)
    {
        return view('admin.promotions.show', ['promotionId' => $id]);
    }

    public function edit(string $id)
    {
        return view('admin.promotions.create', [
            'promotionId' => $id,
            'isEdit' => true,
        ]);
    }
}
