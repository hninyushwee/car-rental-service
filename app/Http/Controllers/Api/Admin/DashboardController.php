<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Driver;
use App\Models\Payment;
use App\Models\Vehicle;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $totalVehicles = Vehicle::count();
        $totalDrivers = Driver::count();
        $activeBookings = Booking::where('status', 'active')->count();
        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $statusCounts = Booking::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $months = collect(range(1, now()->month))->map(function ($m) {
            $revenue = Payment::where('status', 'paid')
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('amount');
            return [
                'month' => date('M', mktime(0, 0, 0, $m, 1)),
                'revenue' => (float) $revenue,
            ];
        });

        $recentBookings = Booking::with([
            'user:id,name,email',
            'items.vehicle:id,model,brand_id',
            'items.vehicle.brand:id,name',
        ])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($booking) {
                $firstItem = $booking->items->first();
                $vehicle = $firstItem?->vehicle;
                return [
                    'id' => $booking->id,
                    'booking_number' => $booking->booking_number,
                    'customer' => $booking->user?->name ?? 'N/A',
                    'vehicle' => $vehicle ? trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model) : 'N/A',
                    'start_date' => $firstItem?->start_date,
                    'status' => $booking->status,
                    'total_price' => (float) $booking->total_price,
                ];
            });

        $topVehicles = Vehicle::select('vehicles.id', 'vehicles.model', 'vehicles.images')
            ->selectRaw('COUNT(booking_items.id) as booking_count')
            ->leftJoin('booking_items', 'vehicles.id', '=', 'booking_items.vehicle_id')
            ->whereNotNull('booking_items.vehicle_id')
            ->groupBy('vehicles.id', 'vehicles.model', 'vehicles.images')
            ->orderByDesc('booking_count')
            ->take(5)
            ->get()
            ->map(function ($v) {
                return [
                    'id' => $v->id,
                    'model' => $v->model,
                    'image' => $v->images[0] ?? null,
                    'booking_count' => (int) $v->booking_count,
                ];
            });

        $drivingLicenseTypes = \App\Models\DrivingLicenseType::withCount('drivers')
            ->get()
            ->map(function ($t) {
                return [
                    'id' => $t->id,
                    'type' => $t->type,
                    'driver_count' => (int) $t->drivers_count,
                ];
            });

        return $this->successResponse([
            'stats' => [
                'total_vehicles' => $totalVehicles,
                'total_drivers' => $totalDrivers,
                'active_bookings' => $activeBookings,
                'monthly_revenue' => $monthlyRevenue,
            ],
            'revenue_trend' => $months,
            'status_counts' => $statusCounts,
            'recent_bookings' => $recentBookings,
            'top_vehicles' => $topVehicles,
            'driving_license_types' => $drivingLicenseTypes,
        ]);
    }
}
