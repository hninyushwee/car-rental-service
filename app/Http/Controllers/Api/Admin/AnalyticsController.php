<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function bookings()
    {
        $totalBookings = Booking::count();

        $vehicleOnly = Booking::whereHas('items', fn($q) => $q->whereNotNull('vehicle_id'))
            ->whereDoesntHave('items', fn($q) => $q->where('has_driver', true))
            ->count();

        $driverOnly = Booking::whereHas('items', fn($q) => $q->whereNull('vehicle_id')->where('has_driver', true))
            ->whereDoesntHave('items', fn($q) => $q->whereNotNull('vehicle_id'))
            ->count();

        $driverVehicle = Booking::where(function ($q) {
            $q->whereHas('items', fn($sq) => $sq->whereNotNull('vehicle_id')->where('has_driver', true))
              ->orWhere(function ($q2) {
                  $q2->whereHas('items', fn($sq) => $sq->whereNotNull('vehicle_id'))
                     ->whereHas('items', fn($sq) => $sq->whereNull('vehicle_id')->where('has_driver', true));
              });
        })->count();

        $statusCounts = Booking::selectRaw("status, COUNT(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status');

        $months = collect(range(1, now()->month))->map(function ($m) {
            $count = Booking::whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count();
            return [
                'month' => date('M', mktime(0, 0, 0, $m, 1)),
                'count' => $count,
            ];
        });

        $typeTrend = collect(range(1, now()->month))->map(function ($m) {
            $yearMonth = fn($q) => $q->whereYear('created_at', now()->year)->whereMonth('created_at', $m);

            $vehicle = Booking::whereHas('items', fn($q) => $q->whereNotNull('vehicle_id'))
                ->whereDoesntHave('items', fn($q) => $q->where('has_driver', true))
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count();

            $driver = Booking::whereHas('items', fn($q) => $q->whereNull('vehicle_id')->where('has_driver', true))
                ->whereDoesntHave('items', fn($q) => $q->whereNotNull('vehicle_id'))
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count();

            $both = Booking::where(function ($q) use ($m) {
                $q->whereHas('items', fn($sq) => $sq->whereNotNull('vehicle_id')->where('has_driver', true))
                  ->orWhere(function ($q2) use ($m) {
                      $q2->whereHas('items', fn($sq) => $sq->whereNotNull('vehicle_id'))
                         ->whereHas('items', fn($sq) => $sq->whereNull('vehicle_id')->where('has_driver', true));
                  });
            })
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->count();

            return [
                'month' => date('M', mktime(0, 0, 0, $m, 1)),
                'vehicle' => $vehicle,
                'driver' => $driver,
                'both' => $both,
            ];
        });

        $recentBookings = Booking::with([
            'user:id,name,email',
            'items.vehicle:id,model,brand_id',
            'items.vehicle.brand:id,name',
        ])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($b) {
                $firstItem = $b->items->first();
                $vehicle = $firstItem?->vehicle;
                return [
                    'id' => $b->id,
                    'booking_number' => $b->booking_number,
                    'customer' => $b->user?->name ?? 'N/A',
                    'vehicle' => $vehicle ? trim(($vehicle->brand?->name ?? '') . ' ' . $vehicle->model) : 'N/A',
                    'start_date' => $firstItem?->start_date,
                    'status' => $b->status,
                    'total_price' => (float) $b->total_price,
                ];
            });

        return $this->successResponse([
            'total_bookings' => $totalBookings,
            'vehicle_only' => $vehicleOnly,
            'driver_only' => $driverOnly,
            'driver_vehicle' => $driverVehicle,
            'status_counts' => $statusCounts,
            'trend' => $months,
            'type_trend' => $typeTrend,
            'recent_bookings' => $recentBookings,
        ]);
    }

    public function customers()
    {
        $totalCustomers = User::whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['super-admin', 'staff']);
        })->count();

        $months = collect(range(1, now()->month))->map(function ($m) {
            $count = User::whereDoesntHave('roles', function ($q) {
                $q->whereIn('name', ['super-admin', 'staff']);
            })
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
               ->count();
            return [
                'month' => date('M', mktime(0, 0, 0, $m, 1)),
                'count' => $count,
            ];
        });

        $totalInquiries = \App\Models\Inquiry::count();

        $recentCustomers = User::whereDoesntHave('roles', function ($q) {
            $q->whereIn('name', ['super-admin', 'staff']);
        })
            ->withCount(['bookings', 'payments', 'inquiries'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'phone' => $u->phone,
                    'joined' => $u->created_at,
                    'bookings_count' => $u->bookings_count,
                    'payments_count' => $u->payments_count,
                    'inquiries_count' => $u->inquiries_count,
                ];
            });

        return $this->successResponse([
            'total_customers' => $totalCustomers,
            'total_inquiries' => $totalInquiries,
            'trend' => $months,
            'recent_customers' => $recentCustomers,
        ]);
    }
}
