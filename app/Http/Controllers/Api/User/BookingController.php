<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Driver;
use App\Models\DrivingLicenseType;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\PromotionUsage;
use App\Models\User;
use App\Models\Vehicle;
use App\Repositories\Interface\BookingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function __construct(protected BookingInterface $bookingRepo) {}

    public function index(Request $request)
    {
        $query = Booking::with(['items.vehicle.brand', 'items.driver'])
            ->where('user_id', $request->user()->id)
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = (int) $request->query('per_page', 15);
        return $this->successResponse($query->paginate($perPage));
    }

    public function store(BookingRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        $booking = $this->bookingRepo->create($data);

        Notification::create([
            'user_id' => null,
            'type' => 'booking',
            'title' => 'New Booking',
            'message' => "{$request->user()->name} has placed a new booking #{$booking->booking_number}.",
            'is_read' => false,
            'notifiable_type' => 'App\Models\Booking',
            'notifiable_id' => $booking->id,
        ]);

        return $this->successResponse($booking->load(['user', 'items']), 'Booking created successfully', 201);
    }

    public function show(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $booking->load(['user', 'items.vehicle.brand', 'items.driver', 'payments', 'promotionUsage.promotion']);

        // Fallback: load payments with legacy payable_type (App\Models\Booking)
        if ($booking->payments->isEmpty()) {
            $legacyPayments = Payment::where('payable_type', 'App\Models\Booking')
                ->where('payable_id', $booking->id)
                ->get();
            if ($legacyPayments->isNotEmpty()) {
                $booking->setRelation('payments', $legacyPayments);
            }
        }

        // Resolve driver data for items where driver_id is null (legacy bookings)
        foreach ($booking->items as $item) {
            if (!$item->vehicle && $item->driver_daily_rate > 0 && !$item->driver && $item->notes) {
                preg_match('/Hired driver:\s*(.+)/i', $item->notes, $m);
                if (!empty($m[1])) {
                    $driver = Driver::withTrashed()->where('name', trim($m[1]))->first();
                    if ($driver) {
                        $item->setRelation('driver', $driver);
                    }
                }
            }
        }

        return $this->successResponse($booking);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|json',
            'payment_method' => 'required|in:kpay,wavepay,bank_transfer,card',
            'transaction_ref' => 'required|string|max:255|unique:payments,transaction_ref',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cartItems = json_decode($request->input('items'), true);
        if (!is_array($cartItems) || empty($cartItems)) {
            return $this->errorResponse('Cart is empty.', 422);
        }

        $user = $request->user();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('payments', 'public');
        }

        // Check promo code usage once (all items share the same promo)
        $firstPromoCode = null;
        foreach ($cartItems as $item) {
            if (!empty($item['promo_code'])) {
                $firstPromoCode = $item['promo_code'];
                break;
            }
        }
        if ($firstPromoCode) {
            $promotion = Promotion::where('code', $firstPromoCode)->first();
            if ($promotion) {
                $used = PromotionUsage::where('promotion_id', $promotion->id)
                    ->where('user_id', $user->id)
                    ->exists();
                if ($used) {
                    return $this->errorResponse("Promotion code '{$firstPromoCode}' has already been used by your account.", 422);
                }
            }
        }

        DB::beginTransaction();
        try {
            $totalSubtotal = 0;
            $totalDiscount = 0;
            $totalCarDeposit = 0;
            $totalDriverDeposit = 0;
            $totalPrice = 0;

            foreach ($cartItems as $item) {
                $isDriverOnly = ($item['type'] ?? null) === 'driver';

                if ($isDriverOnly) {
                    $days = max(1, (int)($item['days'] ?? 1));
                    $driverRate = (float)($item['price_per_day'] ?? 0);
                    $qty = (int)($item['quantity'] ?? 1);
                    $subtotal = $driverRate * $days * $qty;
                    $promoDiscount = (float)($item['promo_discount'] ?? 0);
                    $finalTotal = (float)($item['final_total'] ?? $subtotal);

                    // Validate driver availability for this license type
                    $licenseTypeName = $item['license_type'] ?? '';
                    $itemStartDate = $item['start_date'] ?? null;
                    $itemEndDate = $item['end_date'] ?? null;
                    if ($licenseTypeName && $itemStartDate && $itemEndDate) {
                        $licenseType = DrivingLicenseType::where('type', $licenseTypeName)->first();
                        if ($licenseType) {
                            $totalAvailable = $licenseType->drivers()->where('status', 'available')->count();
                            $occupied = BookingItem::whereNotNull('driver_id')
                                ->whereHas('booking', fn($q) => $q->whereIn('status', ['confirmed', 'active', 'pending']))
                                ->whereHas('driver.drivingLicenseType', fn($q) => $q->where('id', $licenseType->id))
                                ->where('start_date', '<=', $itemEndDate)
                                ->where('end_date', '>=', $itemStartDate)
                                ->distinct('driver_id')
                                ->count('driver_id');
                            $pendingClaim = BookingItem::whereNull('driver_id')
                                ->where('has_driver', true)
                                ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))
                                ->where('start_date', '<=', $itemEndDate)
                                ->where('end_date', '>=', $itemStartDate)
                                ->where('notes', 'like', '%License: ' . str_replace(['%', '_'], ['\\%', '\\_'], $licenseTypeName) . '%')
                                ->sum('quantity');
                            $vehicleDriverPending = BookingItem::whereNull('driver_id')
                                ->where('has_driver', true)
                                ->whereNotNull('vehicle_id')
                                ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))
                                ->where('start_date', '<=', $itemEndDate)
                                ->where('end_date', '>=', $itemStartDate)
                                ->whereHas('vehicle.drivers.drivingLicenseType', fn($q) => $q->where('id', $licenseType->id))
                                ->sum('quantity');
                            if ($totalAvailable - $occupied - $pendingClaim - $vehicleDriverPending < $qty) {
                                DB::rollBack();
                                return $this->errorResponse('No drivers available for license type ' . $licenseTypeName . ' during the selected dates.', 422);
                            }
                        }
                    }

                    $totalSubtotal += $subtotal;
                    $totalDiscount += $promoDiscount;
                    $totalPrice += $finalTotal;
                    $totalDriverDeposit += (float)($item['deposit_amount'] ?? 0);
                } else {
                    $vehicle = Vehicle::lockForUpdate()->find($item['id']);
                    if (!$vehicle) {
                        DB::rollBack();
                        return $this->errorResponse("Vehicle #{$item['id']} not found.", 404);
                    }

                    $quantity = (int)($item['quantity'] ?? 1);
                    if ($quantity < 1 || $quantity > $vehicle->available_stock) {
                        DB::rollBack();
                        return $this->errorResponse("Quantity for vehicle #{$item['id']} must be between 1 and {$vehicle->available_stock}.", 422);
                    }

                    $hasDriver = !empty($item['has_driver']);

                    if ($hasDriver) {
                        $itemStartDate = $item['start_date'] ?? null;
                        $itemEndDate = $item['end_date'] ?? null;
                        if (!$itemStartDate || !$itemEndDate) {
                            DB::rollBack();
                            return $this->errorResponse("Start and end dates are required when including a driver.", 422);
                        }
                        $qualifiedCount = \App\Http\Controllers\Api\User\RentCarController::getAvailableQualifiedDrivers($vehicle->id, $itemStartDate, $itemEndDate)->count();
                        $pendingSlots = BookingItem::whereNull('driver_id')
                            ->where('has_driver', true)
                            ->where('vehicle_id', $vehicle->id)
                            ->where('start_date', '<=', $itemEndDate)
                            ->where('end_date', '>=', $itemStartDate)
                            ->whereHas('booking', fn($q) => $q->whereIn('status', ['pending', 'confirmed']))
                            ->sum('quantity');
                        $availableDrivers = max(0, $qualifiedCount - $pendingSlots);

                        if ($availableDrivers < $quantity) {
                            DB::rollBack();
                            return $this->errorResponse("No qualified drivers are available for this vehicle during the selected dates.", 422);
                        }
                    }

                    $days = max(1, (int)($item['days'] ?? 1));
                    $pricePerDay = (float)($item['price_per_day'] ?? 0);
                    $driverRate = (float)($item['driver_price_per_day'] ?? 0);
                    $subtotal = ($pricePerDay + $driverRate) * $days * $quantity;
                    $promoDiscount = (float)($item['promo_discount'] ?? 0);
                    $finalTotal = (float)($item['final_total'] ?? $subtotal);

                    $totalSubtotal += $subtotal;
                    $totalDiscount += $promoDiscount;
                    $totalPrice += $finalTotal;
                    $totalCarDeposit += (float)($item['deposit_amount'] ?? 0);
                }
            }

            $booking = Booking::create([
                'user_id' => $user->id,
                'booking_number' => 'SKY-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . sprintf('%04d', random_int(0, 9999)),
                'status' => 'pending',
                'subtotal_price' => $totalSubtotal,
                'discount_amount' => $totalDiscount,
                'car_deposit_snapshot' => $totalCarDeposit,
                'driver_deposit_snapshot' => $totalDriverDeposit,
                'total_price' => $totalPrice,
            ]);

            // Create booking items
            foreach ($cartItems as $item) {
                $isDriverOnly = ($item['type'] ?? null) === 'driver';

                if ($isDriverOnly) {
                    $days = max(1, (int)($item['days'] ?? 1));
                    $driverRate = (float)($item['price_per_day'] ?? 0);
                    $licenseType = $item['license_type'] ?? '';
                    $qty = (int)($item['quantity'] ?? 1);

                    for ($i = 0; $i < $qty; $i++) {
                        BookingItem::create([
                            'booking_id' => $booking->id,
                            'vehicle_id' => null,
                            'driver_id' => null,
                            'has_driver' => true,
                            'quantity' => 1,
                            'start_date' => $item['start_date'] ?? null,
                            'end_date' => $item['end_date'] ?? null,
                            'pickup_location' => $item['pickup_location'] ?? null,
                            'dropoff_location' => $item['dropoff_location'] ?? null,
                            'vehicle_daily_rate' => 0,
                            'driver_daily_rate' => $driverRate,
                            'notes' => ($item['notes'] ?? '') . ($licenseType ? ' | License: ' . $licenseType : ''),
                        ]);
                    }
                } else {
                    $hasDriver = !empty($item['has_driver']);
                    $days = max(1, (int)($item['days'] ?? 1));
                    $pricePerDay = (float)($item['price_per_day'] ?? 0);
                    $driverRate = (float)($item['driver_price_per_day'] ?? 0);
                    $quantity = (int)($item['quantity'] ?? 1);

                    $vehicle = Vehicle::find($item['id']);

                    if ($hasDriver && $quantity > 1) {
                        for ($i = 0; $i < $quantity; $i++) {
                            BookingItem::create([
                                'booking_id' => $booking->id,
                                'vehicle_id' => $vehicle->id,
                                'driver_id' => null,
                                'has_driver' => true,
                                'quantity' => 1,
                                'start_date' => $item['start_date'] ?? null,
                                'end_date' => $item['end_date'] ?? null,
                                'pickup_location' => $item['pickup_location'] ?? null,
                                'dropoff_location' => $item['dropoff_location'] ?? null,
                                'vehicle_daily_rate' => $pricePerDay,
                                'driver_daily_rate' => $driverRate,
                                'notes' => $item['notes'] ?? null,
                            ]);
                        }
                    } else {
                        BookingItem::create([
                            'booking_id' => $booking->id,
                            'vehicle_id' => $vehicle->id,
                            'driver_id' => null,
                            'has_driver' => $hasDriver,
                            'quantity' => $quantity,
                            'start_date' => $item['start_date'] ?? null,
                            'end_date' => $item['end_date'] ?? null,
                            'pickup_location' => $item['pickup_location'] ?? null,
                            'dropoff_location' => $item['dropoff_location'] ?? null,
                            'vehicle_daily_rate' => $pricePerDay,
                            'driver_daily_rate' => $driverRate,
                            'notes' => $item['notes'] ?? null,
                        ]);
                    }
                }
            }

            // One payment for total deposit
            Payment::create([
                'user_id' => $user->id,
                'payable_type' => $booking->getMorphClass(),
                'payable_id' => $booking->id,
                'payment_method' => $request->input('payment_method'),
                'transaction_ref' => $request->input('transaction_ref'),
                'image' => $imagePath,
                'status' => 'pending',
                'amount' => $totalCarDeposit + $totalDriverDeposit,
            ]);

            // One promotion usage if a promo was applied
            if ($firstPromoCode) {
                $promotion = Promotion::where('code', $firstPromoCode)->first();
                if ($promotion) {
                    PromotionUsage::create([
                        'promotion_id' => $promotion->id,
                        'user_id' => $user->id,
                        'booking_id' => $booking->id,
                        'discount_applied' => $totalDiscount,
                        'used_at' => now(),
                    ]);
                }
            }

            DB::commit();

            // Notify admins and staff
            Notification::create([
                'user_id' => null,
                'type' => 'booking',
                'title' => 'New Booking',
                'message' => "{$user->name} has placed a new booking #{$booking->booking_number}.",
                'is_read' => false,
                'notifiable_type' => 'App\Models\Booking',
                'notifiable_id' => $booking->id,
            ]);
            Notification::create([
                'user_id' => null,
                'type' => 'payment',
                'title' => 'New Payment Received',
                'message' => "{$user->name} has made a payment of MMK " . number_format($totalCarDeposit + $totalDriverDeposit) . " for booking #{$booking->booking_number}.",
                'is_read' => false,
                'notifiable_type' => 'App\Models\Payment',
                'notifiable_id' => $booking->id,
            ]);

            return $this->successResponse(
                $booking->load(['items.vehicle', 'payments']),
                'Checkout successful',
                201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            if ($e instanceof \Illuminate\Database\QueryException && str_contains($e->getMessage(), 'payments_transaction_ref_unique')) {
                return $this->errorResponse('This transaction reference has already been used. Please check your payment details and try again.', 422);
            }
            return $this->errorResponse('Checkout failed. Please try again.', 500);
        }
    }

    public function cancel(Request $request, Booking $booking)
    {
        if ($booking->user_id !== $request->user()->id) {
            return $this->errorResponse('Unauthorized', 403);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return $this->errorResponse('This booking cannot be cancelled.', 422);
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        });

        return $this->successResponse($booking->fresh()->load(['items.vehicle', 'items.driver']), 'Booking cancelled successfully.');
    }

    public function cancelItem(Request $request, Booking $booking, BookingItem $item)
    {
        // Per-item cancellation is no longer supported — items no longer carry
        // individual status, deposit fields, or quantity in this schema.
        return $this->errorResponse('Per-item cancellation is not available. Please cancel the entire booking instead.', 422);
    }
}
