<?php

namespace App\Http\Controllers\View\Admin;

class NotificationController
{
    public function index()
    {
        return view('admin.notifications.index');
    }

    public function show($id)
    {
        return view('admin.notifications.show', ['notificationId' => $id]);
    }
}
