<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 20);
        return $this->successResponse(
            Notification::where('user_id', $request->user()->id)
                ->whereDate('created_at', '>=', now()->subMonths(2))
                ->latest()
                ->paginate($perPage)
        );
    }

    public function markAsRead(Request $request, Notification $notification)
    {
        if ($notification->user_id !== $request->user()->id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        $notification->update(['is_read' => true]);
        return $this->successResponse($notification, 'Notification marked as read');
    }

    public function unreadCount(Request $request)
    {
        $count = Notification::where('user_id', $request->user()->id)
            ->where('is_read', false)
            ->whereDate('created_at', '>=', now()->subMonths(2))
            ->count();
        return $this->successResponse(['count' => $count]);
    }
}
