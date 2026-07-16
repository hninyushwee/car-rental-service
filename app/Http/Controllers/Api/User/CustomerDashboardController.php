<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerDashboardRequest;
use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Promotion;
use App\Repositories\Interface\BookingInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerDashboardController extends Controller
{
    public function __construct(protected BookingInterface $bookingRepo) {}

    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->can('access-customer-dashboard')) {
            return $this->errorResponse('Unauthorized', 403);
        }

        $query = Booking::where('user_id', $user->id);
        $now = now();

        $stats = [
            'total'     => (clone $query)->count(),
            'active'    => (clone $query)->whereIn('status', Booking::activeStatuses())->count(),
            'completed' => (clone $query)->where('status', Booking::STATUS_COMPLETED)->count(),
            'cancelled' => (clone $query)->where('status', Booking::STATUS_CANCELLED)->count(),
        ];

        $recentBookings = (clone $query)
            ->with(['items.vehicle', 'items.driver'])
            ->latest()
            ->take(5)
            ->get();

        $upcomingBookings = (clone $query)
            ->with(['items.vehicle', 'items.driver'])
            ->whereNotIn('status', Booking::closedStatuses())
            ->whereHas('items', function ($q) use ($now) {
                $q->whereDate('start_date', '>=', $now);
            })
            ->latest()
            ->take(3)
            ->get();

        $unreadNotifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->count();

        $totalSpent = Payment::where('user_id', $user->id)
            ->where('status', 'paid')
            ->sum('amount');

        $activePromotions = Promotion::where('status', 'active')
            ->whereDate('start_date', '<=', $now)
            ->whereDate('end_date', '>=', $now)
            ->orderBy('end_date')
            ->get(['id', 'code', 'description', 'discount_type', 'discount_value', 'min_spend', 'max_discount', 'end_date']);

        $recentTransactions = Payment::where('user_id', $user->id)
            ->with('payable')
            ->latest()
            ->take(5)
            ->get();

        return $this->successResponse([
            'stats'               => $stats,
            'recent_bookings'     => $recentBookings,
            'upcoming_bookings'   => $upcomingBookings,
            'unread_notifications' => $unreadNotifications,
            'total_spent'         => $totalSpent,
            'active_promotions'   => $activePromotions,
            'recent_transactions' => $recentTransactions,
        ]);
    }

    public function indexView(Request $request)
    {
        $data = $this->index($request)->getData();

        return view('user.dashboard', [
            'dashboardData' => $data->data,
        ]);
    }

    public function store(CustomerDashboardRequest $request)
    {
        $user = $request->user();

        if (!$user->can('create-bookings')) {
            return $this->errorResponse('You do not have permission to create bookings.', 403);
        }

        $data = $request->validated();

        if (!empty($data['items'])) {
            $hasDriver = collect($data['items'])->pluck('driver_id')->filter()->isNotEmpty();
            if ($hasDriver && !$user->can('request-drivers')) {
                return $this->errorResponse('You do not have permission to request a driver.', 403);
            }
        }

        $booking = DB::transaction(function () use ($user, $data) {
            $booking = $this->bookingRepo->create([
                'user_id'         => $user->id,
                'booking_number'  => 'SKY-' . substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 4) . '-' . sprintf('%04d', random_int(0, 9999)),
                'rental_type'     => $data['rental_type'] ?? 'daily',
                'start_date'      => $data['pickup_date'],
                'end_date'        => $data['return_date'],
                'pickup_location' => $data['pickup_location'] ?? null,
                'dropoff_location' => $data['return_location'] ?? null,
                'status'          => 'pending',
                'subtotal_price'  => $data['total_amount'],
                'total_price'     => $data['total_amount'],
                'notes'           => $data['notes'] ?? null,
            ]);

            if (!empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    BookingItem::create([
                        'booking_id'        => $booking->id,
                        'vehicle_id'        => $item['vehicle_id'] ?? null,
                        'driver_id'         => $item['driver_id'] ?? null,
                        'quantity'          => $item['days'] ?? 1,
                        'vehicle_daily_rate' => $item['subtotal'] ?? 0,
                    ]);
                }
            }

            return $booking;
        });

        return $this->successResponse(
            $booking->load(['items.vehicle', 'items.driver']),
            'Booking created successfully',
            201
        );
    }
}
