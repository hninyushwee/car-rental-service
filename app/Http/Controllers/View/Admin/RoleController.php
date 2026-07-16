<?php

namespace App\Http\Controllers\View\Admin;

class RoleController
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function create()
    {
        return view('admin.roles.create', [
            'roleId' => null,
            'isEdit' => false,
        ]);
    }

    public function edit(string $id)
    {
        return view('admin.roles.create', [
            'roleId' => $id,
            'isEdit' => true,
        ]);
    }
}
