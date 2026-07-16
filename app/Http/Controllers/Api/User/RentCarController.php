<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\BookingItem;
use App\Models\Category;
use App\Models\Driver;
use App\Models\DrivingLicenseType;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Repositories\Interface\DepositSettingInterface;
use App\Repositories\Interface\PromotionInterface;
use App\Repositories\Interface\VehicleInterface;
use Illuminate\Http\Request;

class RentCarController extends Controller
{
    public function __construct(
        protected VehicleInterface $vehicleRepo,
        protected PromotionInterface $promotionRepo,
        protected DepositSettingInterface $depositSettingRepo,
    ) {}

    public function vehicleIndex(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $vehicles = $this->vehicleRepo->getFilteredVehicles(
            filters: $request->only(['category_id', 'location', 'from_date', 'to_date', 'search']),
            sort: $request->input('sort', 'popular'),
        );

        return $this->successResponse([
            'vehicles' => $vehicles,
            'categories' => $categories,
        ]);
    }

    public function vehicleShow(string $id)
    {
        $vehicle = $this->vehicleRepo->getVehicleById($id);
        $vehicle->load(['category', 'brand']);

        $qualifiedDriversCount = Driver::where('status', 'available')
            ->whereHas('vehicles', fn($q) => $q->where('vehicle_id', $vehicle->id))
            ->count();

        $driverLicensePrice = DrivingLicenseType::whereHas('drivers', fn($q) => $q->whereHas('vehicles', fn($v) => $v->where('vehicle_id', $vehicle->id)))
            ->min('price');

        return $this->successResponse(array_merge($vehicle->toArray(), [
            'qualified_drivers_count' => $qualifiedDriversCount,
            'driver_license_type_price' => (float) ($driverLicensePrice ?? 0),
        ]));
    }

    public static function getAvailableQualifiedDrivers(int $vehicleId, string $startDate, string $endDate)
    {
        return Driver::where('status', 'available')
            ->whereHas('vehicles', fn($q) => $q->where('vehicle_id', $vehicleId))
            ->whereDoesntHave('bookingItems', function ($q) use ($startDate, $endDate) {
                $q->whereHas('booking', fn($b) => $b->whereIn('status', ['confirmed', 'active', 'pending']))
                  ->where('start_date', '<=', $endDate)
                  ->where('end_date', '>=', $startDate);
            })
            ->withCount('vehicles')
            ->orderBy('vehicles_count', 'asc');
    }

    public function checkVehicleDriverAvailability(Request $request, string $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $quantity = (int) $request->input('quantity', 1);
        $count = self::getAvailableQualifiedDrivers((int) $id, $request->start_date, $request->end_date)->count();
        $pendingSlots = BookingItem::whereNull('driver_id')
            ->where('has_driver', true)
            ->where('vehicle_id', (int) $id)
            ->where('start_date', '<=', $request->end_date)
            ->where('end_date', '>=', $request->start_date)
            ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))
            ->sum('quantity');
        $available = max(0, $count - $pendingSlots);

        return $this->successResponse([
            'available' => $available >= $quantity,
            'available_count' => $available,
            'required' => $quantity,
        ]);
    }

    public function promotions()
    {
        $promotions = $this->promotionRepo->getActivePromotions();

        return $this->successResponse($promotions);
    }

    public function deposit(Request $request)
    {
        $serviceKey = $request->query('service', 'car_rental');
        $deposit = $this->depositSettingRepo->getByServiceKey($serviceKey);

        return $this->successResponse([
            'deposit' => $deposit,
        ]);
    }

    public function checkAvailability(Request $request, string $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $vehicle = \App\Models\Vehicle::find($id);
        if (!$vehicle) {
            return $this->errorResponse('Vehicle not found.', 404);
        }

        $bookedQty = \App\Models\BookingItem::where('vehicle_id', $id)
            ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed', 'active']))
            ->where('start_date', '<', $request->input('end_date'))
            ->where('end_date', '>', $request->input('start_date'))
            ->sum('quantity');

        $remaining = $vehicle->available_stock - $bookedQty;

        return $this->successResponse([
            'available' => $remaining > 0,
            'available_quantity' => max(0, $remaining),
            'booked_quantity' => $bookedQty,
            'total_stock' => $vehicle->available_stock,
        ]);
    }

    public function driverIndex(Request $request)
    {
        $perPage = $request->query('per_page', 12);

        $query = Driver::with(['primaryVehicle', 'drivingLicenseType'])
            ->where('status', 'available');

        if ($request->filled('location')) {
            $query->where('address', 'like', '%' . $request->input('location') . '%');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('license_type_id')) {
            $query->where('driving_license_type_id', $request->input('license_type_id'));
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = $request->input('from_date');
            $to = $request->input('to_date');
            $query->whereDoesntHave('bookingItems', function ($q) use ($from, $to) {
                $q->whereHas('booking', fn($b) => $b->whereIn('status', ['pending', 'confirmed', 'active']))
                  ->where('start_date', '<=', $to)
                  ->where('end_date', '>=', $from);
            });
        }

        $drivers = $query->latest()->paginate((int)$perPage);

        return $this->successResponse($drivers);
    }

    public function licenseTypeIndex()
    {
        $types = DrivingLicenseType::withCount(['drivers' => function ($q) {
            $q->where('status', 'available');
        }])->latest()->get();

        return $this->successResponse($types);
    }

    public function licenseTypeShow(DrivingLicenseType $drivingLicenseType)
    {
        $drivingLicenseType->loadCount(['drivers' => function ($q) {
            $q->where('status', 'available');
        }]);

        return $this->successResponse($drivingLicenseType);
    }

    public function checkLicenseTypeDriverAvailability(Request $request, DrivingLicenseType $drivingLicenseType)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $quantity = (int)($request->input('quantity') ?? 1);

        $totalAvailable = $drivingLicenseType->drivers()->where('status', 'available')->count();

        // Drivers occupied by confirmed/active/pending bookings
        $occupied = BookingItem::whereNotNull('driver_id')
            ->whereHas('booking', fn($q) => $q->whereIn('status', ['confirmed', 'active', 'pending']))
            ->whereHas('driver.drivingLicenseType', fn($q) => $q->where('id', $drivingLicenseType->id))
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->distinct('driver_id')
            ->count('driver_id');

        // Pending/confirmed driver-only bookings claiming a driver of this type (not yet assigned)
        $pendingClaim = BookingItem::whereNull('driver_id')
            ->where('has_driver', true)
            ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->where('notes', 'like', '%License: ' . str_replace(['%', '_'], ['\\%', '\\_'], $drivingLicenseType->type) . '%')
            ->sum('quantity');

        // Pending/confirmed vehicle+driver items that will consume a driver of this license type
        $vehicleDriverPending = BookingItem::whereNull('driver_id')
            ->where('has_driver', true)
            ->whereNotNull('vehicle_id')
            ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->whereHas('vehicle.drivers.drivingLicenseType', fn($q) => $q->where('id', $drivingLicenseType->id))
            ->sum('quantity');

        $remaining = max(0, $totalAvailable - $occupied - $pendingClaim - $vehicleDriverPending);

        return $this->successResponse([
            'available' => $remaining >= $quantity,
            'available_count' => $remaining,
            'total_drivers' => $totalAvailable,
        ]);
    }

    public function driverShow(Driver $driver)
    {
        if ($driver->status !== 'available') {
            return $this->errorResponse('Driver is not available.', 404);
        }

        return $this->successResponse($driver->load('primaryVehicle'));
    }

    public function checkDriverAvailability(Request $request, Driver $driver)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($driver->status !== 'available') {
            return $this->successResponse(['available' => false]);
        }

        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $conflicting = $driver->bookingItems()
            ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed', 'active']))
            ->where('start_date', '<=', $end)
            ->where('end_date', '>=', $start)
            ->exists();

        return $this->successResponse([
            'available' => !$conflicting,
        ]);
    }

    public function checkPromoUsage(Request $request, string $code)
    {
        $user = $request->user();

        $promotion = Promotion::where('code', $code)->first();
        if (!$promotion) {
            return $this->errorResponse('Promotion code not found.', 404);
        }

        $used = PromotionUsage::where('promotion_id', $promotion->id)
            ->where('user_id', $user->id)
            ->exists();

        return $this->successResponse([
            'used' => $used,
            'code' => $code,
        ]);
    }
}
