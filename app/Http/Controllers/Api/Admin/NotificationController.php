<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search = $request->query('search');
        $isRead = $request->query('is_read');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $query = Notification::with('user:id,name')
            ->whereDate('created_at', '>=', now()->subMonths(2))
            ->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        if ($isRead === 'read') {
            $query->where('is_read', true);
        } elseif ($isRead === 'unread') {
            $query->where('is_read', false);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $result = $query->paginate($perPage);
        $result->getCollection()->loadMorph('notifiable', [
            'App\Models\Booking' => ['user:id,name'],
            'App\Models\Payment' => ['user:id,name'],
            'App\Models\Inquiry' => ['user:id,name'],
            'App\Models\Promotion' => [],
        ]);

        $this->applyInquiryData($result->getCollection());

        return $this->successResponse($result);
    }

    public function latest()
    {
        $notifications = Notification::with('user:id,name')
            ->whereDate('created_at', '>=', now()->subMonths(2))
            ->latest()
            ->limit(5)
            ->get();

        $notifications->loadMorph('notifiable', [
            'App\Models\Booking' => ['user:id,name'],
            'App\Models\Payment' => ['user:id,name'],
            'App\Models\Inquiry' => ['user:id,name'],
            'App\Models\Promotion' => [],
        ]);

        $this->applyInquiryData($notifications);

        return $this->successResponse($notifications);
    }

    public function unreadCount()
    {
        $count = Notification::where('is_read', false)
            ->whereDate('created_at', '>=', now()->subMonths(2))
            ->count();
        return $this->successResponse(['count' => $count]);
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        $notification->loadMorph('notifiable', [
            'App\Models\Booking' => ['user:id,name'],
            'App\Models\Payment' => ['user:id,name'],
            'App\Models\Inquiry' => ['user:id,name'],
            'App\Models\Promotion' => [],
        ]);

        $this->applyInquiryData(collect([$notification]));

        $data = $notification->toArray();

        if ($notification->notifiable_type === 'App\Models\Inquiry' && $notification->notifiable_id) {
            $inquiry = Inquiry::with('user')->find($notification->notifiable_id);
            $data['inquiry'] = $inquiry ? $inquiry->toArray() : null;
        }

        return $this->successResponse($data);
    }

    public function markAsRead(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return $this->successResponse($notification, 'Notification marked as read');
    }

    private function applyInquiryData($notifications)
    {
        foreach ($notifications as $n) {
            if ($n->notifiable_type === 'App\Models\Inquiry' && $n->notifiable) {
                $n->title = $n->notifiable->subject;
                $n->message = $n->notifiable->message;
            }
        }
    }
}
