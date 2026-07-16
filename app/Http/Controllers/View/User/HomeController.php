<?php

namespace App\Http\Controllers\View\User;

use App\Models\Driver;
use App\Models\DrivingLicenseType;
use App\Models\Vehicle;

class HomeController
{
    public function index()
    {
        $vehicles = Vehicle::with(['category', 'brand'])
            ->where('available_stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        $drivingLicenseTypes = DrivingLicenseType::withCount(['drivers' => fn($q) => $q->where('status', 'available')])
            ->get();

        return view('user.home', compact('vehicles', 'drivingLicenseTypes'));
    }

    public function about()
    {
        return view('user.about');
    }

    public function contact()
    {
        return view('user.contact');
    }
}
