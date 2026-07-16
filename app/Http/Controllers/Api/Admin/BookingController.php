<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\User\RentCarController;
use App\Mail\BookingInvoiceMail;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Driver;
use App\Models\DrivingLicenseType;
use App\Models\Notification;
use App\Models\Payment;
use App\Repositories\Interface\BookingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function __construct(protected BookingInterface $bookingRepo) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $filters = $request->only(['search', 'status', 'user_id', 'start_date', 'end_date']);

        return $this->successResponse($this->bookingRepo->all($perPage, $filters));
    }

    public function show($booking)
    {
        return $this->successResponse($this->bookingRepo->findById($booking));
    }

    public function update(Request $request, $booking)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,active,completed,cancelled',
        ]);

        $bookingModel = Booking::with('items')->find((int) $booking);
        if (!$bookingModel) {
            return $this->errorResponse('Booking not found.', 404);
        }

        $oldStatus = $bookingModel->status;
        $newStatus = $validated['status'];

        DB::transaction(function () use ($bookingModel, $newStatus, $oldStatus, $validated) {
            // Auto-assign missing drivers when confirming
            if (in_array($newStatus, Booking::activeStatuses()) && !in_array($oldStatus, Booking::activeStatuses())) {
                foreach ($bookingModel->items as $item) {
                    if ($item->has_driver && is_null($item->driver_id)) {
                        $this->autoAssignDriver($item);
                    }
                }
            }

            // Decrease stock when transitioning to active
            if ($newStatus === 'active' && $oldStatus !== 'active') {
                foreach ($bookingModel->items as $item) {
                    if ($item->vehicle_id) {
                        $item->vehicle()->decrement('available_stock', $item->quantity ?? 1);
                    }
                }
            }

            // Increase stock when transitioning away from active
            if ($oldStatus === 'active' && $newStatus !== 'active') {
                foreach ($bookingModel->items as $item) {
                    if ($item->vehicle_id) {
                        $item->vehicle()->increment('available_stock', $item->quantity ?? 1);
                    }
                }
            }

            $bookingModel->update(array_merge(
                $validated,
                $newStatus === 'cancelled' ? ['cancelled_at' => now()] : []
            ));
        });

        if ($newStatus === 'confirmed') {
            Notification::create([
                'user_id' => $bookingModel->user_id,
                'type' => 'booking',
                'title' => 'Booking Confirmed',
                'message' => "Your booking #{$bookingModel->booking_number} has been confirmed.",
                'is_read' => false,
                'notifiable_type' => 'App\Models\Booking',
                'notifiable_id' => $bookingModel->id,
            ]);
            try {
                Mail::to($bookingModel->user->email)->send(new BookingInvoiceMail($bookingModel));
            } catch (\Exception $e) {
                \Log::warning('Failed to send invoice email: ' . $e->getMessage());
            }
        }

        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            Notification::create([
                'user_id' => $bookingModel->user_id,
                'type' => 'booking',
                'title' => 'Booking Cancelled',
                'message' => "Your booking #{$bookingModel->booking_number} has been cancelled.",
                'is_read' => false,
                'notifiable_type' => 'App\Models\Booking',
                'notifiable_id' => $bookingModel->id,
            ]);
        }

        return $this->successResponse($this->bookingRepo->findById((int) $booking), 'Booking updated successfully.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'cancellation_reason' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->load('items');

            // Restore stock if booking was active
            if ($booking->status === 'active') {
                foreach ($booking->items as $item) {
                    if ($item->vehicle_id) {
                        $item->vehicle()->increment('available_stock', $item->quantity ?? 1);
                    }
                }
            }

            $booking->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $request->input('cancellation_reason'),
            ]);

            $booking->promotionUsage()->delete();

            Notification::create([
                'user_id' => $booking->user_id,
                'type' => 'booking',
                'title' => 'Booking Cancelled',
                'message' => "Your booking #{$booking->booking_number} has been cancelled.",
                'is_read' => false,
                'notifiable_type' => 'App\Models\Booking',
                'notifiable_id' => $booking->id,
            ]);
        });

        return $this->successResponse(
            $booking->fresh()->load(['items.vehicle', 'items.driver', 'payments', 'promotionUsage.promotion']),
            'Booking rejected and cancelled.'
        );
    }

    public function availableDrivers(Booking $booking, BookingItem $item)
    {
        if ($item->booking_id !== $booking->id) {
            return $this->errorResponse('Item does not belong to this booking.', 422);
        }

        $startDate = $item->start_date;
        $endDate = $item->end_date;

        if (!$startDate || !$endDate) {
            return $this->errorResponse('Booking item has no date range.', 422);
        }

        $query = Driver::query();

        if ($item->vehicle_id) {
            $query->whereHas('vehicles', fn($q) => $q->where('vehicle_id', $item->vehicle_id));
        }

        // Filter by license type from booking item notes (driver-only bookings)
        if (!$item->vehicle_id && $item->notes) {
            preg_match('/License:\s*(.+)/i', $item->notes, $m);
            if (!empty($m[1])) {
                $licenseType = DrivingLicenseType::where('type', trim($m[1]))->first();
                if ($licenseType) {
                    $query->where('driving_license_type_id', $licenseType->id);
                }
            }
        }

        // Exclude drivers with conflicting bookings in the same date range
        $query->whereDoesntHave('bookingItems', function ($q) use ($startDate, $endDate, $item) {
            $q->where('id', '!=', $item->id)
              ->whereHas('booking', fn($b) => $b->whereIn('status', Booking::blockingStatuses()))
              ->where('start_date', '<=', $endDate)
              ->where('end_date', '>=', $startDate);
        });

        // Exclude drivers already assigned to other items in this same booking
        $query->whereDoesntHave('bookingItems', function ($q) use ($booking, $item) {
            $q->where('booking_id', $booking->id)
              ->where('id', '!=', $item->id)
              ->whereNotNull('driver_id');
        });

        return $this->successResponse($query->latest()->get());
    }

    public function assignDriver(Request $request, Booking $booking, BookingItem $item)
    {
        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
        ]);

        if ($item->booking_id !== $booking->id) {
            return $this->errorResponse('Item does not belong to this booking.', 422);
        }

        $driver = Driver::findOrFail($request->driver_id);

        // Check driver is not already booked for overlapping dates
        $hasConflict = $driver->bookingItems()
            ->whereHas('booking', fn($b) => $b->whereIn('status', Booking::activeStatuses()))
            ->where('start_date', '<=', $item->end_date)
            ->where('end_date', '>=', $item->start_date)
            ->exists();

        if ($hasConflict) {
            return $this->errorResponse('This driver is already assigned to another booking during these dates.', 422);
        }

        // Check driver is not already assigned to another item in this same booking
        $alreadyAssigned = $driver->bookingItems()
            ->where('booking_id', $booking->id)
            ->where('id', '!=', $item->id)
            ->exists();

        if ($alreadyAssigned) {
            return $this->errorResponse('This driver is already assigned to another item in this booking.', 422);
        }

        if ($item->vehicle_id && !$driver->vehicles()->where('vehicle_id', $item->vehicle_id)->exists()) {
            return $this->errorResponse('This driver is not qualified for the assigned vehicle.', 422);
        }

        $item->update(['driver_id' => $driver->id]);

        return $this->successResponse(
            $booking->fresh()->load(['items.vehicle', 'items.driver', 'payments', 'promotionUsage.promotion']),
            'Driver assigned successfully.'
        );
    }

    public function confirm(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return $this->errorResponse('Only pending bookings can be confirmed.', 422);
        }

        $items = $booking->items()->get();

        DB::beginTransaction();
        try {
            foreach ($items as $item) {
                if ($item->has_driver && is_null($item->driver_id)) {
                    $this->autoAssignDriver($item);
                }
            }

            $booking->update(['status' => 'confirmed']);

            Notification::create([
                'user_id' => $booking->user_id,
                'type' => 'booking',
                'title' => 'Booking Confirmed',
                'message' => "Your booking #{$booking->booking_number} has been confirmed.",
                'is_read' => false,
            ]);

            DB::commit();

            try {
                Mail::to($booking->user->email)->send(new BookingInvoiceMail($booking));
            } catch (\Exception $e) {
                \Log::warning('Failed to send invoice email: ' . $e->getMessage());
            }

            return $this->successResponse(
                $booking->fresh()->load(['items.vehicle', 'items.driver', 'payments', 'promotionUsage.promotion']),
                'Booking confirmed successfully.'
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Confirmation failed: ' . $e->getMessage(), 500);
        }
    }

    public function sendInvoice(Request $request, Booking $booking)
    {
        if (!in_array($booking->status, array_merge(Booking::activeStatuses(), [Booking::STATUS_COMPLETED]))) {
            return $this->errorResponse('Invoice can only be sent for confirmed, active, or completed bookings.', 422);
        }

        try {
            Mail::to($booking->user->email)->send(new BookingInvoiceMail($booking));
            return $this->successResponse(null, 'Invoice email sent successfully.');
        } catch (\Exception $e) {
            \Log::error('Failed to send invoice email: ' . $e->getMessage());
            return $this->errorResponse('Failed to send invoice email. Please try again.', 500);
        }
    }

    public function autoAssignDriver(BookingItem $item)
    {
        if (!$item->has_driver || $item->driver_id) {
            return;
        }

        $startDate = $item->start_date;
        $endDate = $item->end_date;

        if (!$startDate || !$endDate) {
            return;
        }

        $query = Driver::query();

        if ($item->vehicle_id) {
            $query->whereHas('vehicles', fn($q) => $q->where('vehicle_id', $item->vehicle_id));
        }

        // Filter by license type from booking item notes (driver-only bookings)
        if (!$item->vehicle_id && $item->notes) {
            preg_match('/License:\s*(.+)/i', $item->notes, $m);
            if (!empty($m[1])) {
                $licenseType = DrivingLicenseType::where('type', trim($m[1]))->first();
                if ($licenseType) {
                    $query->where('driving_license_type_id', $licenseType->id);
                }
            }
        }

        $query->whereDoesntHave('bookingItems', function ($q) use ($startDate, $endDate) {
            $q->whereHas('booking', fn($b) => $b->whereIn('status', ['confirmed', 'active', 'pending']))
              ->where('start_date', '<=', $endDate)
              ->where('end_date', '>=', $startDate);
        });

        // Exclude drivers already assigned to another item in this same booking
        $query->whereDoesntHave('bookingItems', function ($q) use ($item) {
            $q->where('booking_id', $item->booking_id)
              ->where('id', '!=', $item->id)
              ->whereNotNull('driver_id');
        });

        $driver = $query->first();

        if ($driver) {
            $item->update(['driver_id' => $driver->id]);
        }
    }
}
