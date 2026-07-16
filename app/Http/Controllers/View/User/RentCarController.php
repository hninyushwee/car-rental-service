<?php

namespace App\Http\Controllers\View\User;

use Illuminate\Http\Request;

class RentCarController
{
    public function index()
    {
        return view('user.rent_car');
    }

    public function create()
    {
        return view('user.rent_car_form');
    }
}
