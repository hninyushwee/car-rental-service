<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Repositories\Interface\InquiryInterface;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct(protected InquiryInterface $inquiryRepo) {}

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        $filters = $request->only(['status']);

        return $this->successResponse($this->inquiryRepo->all($perPage, $filters));
    }

    public function store(Request $request)
    {
        $inquiry = $this->inquiryRepo->create($request->all());

        return $this->successResponse($inquiry->load('user'), 'Inquiry submitted successfully', 201);
    }

    public function show($inquiry)
    {
        return $this->successResponse($this->inquiryRepo->findById($inquiry));
    }

    public function update(Request $request, $inquiry)
    {
        $updated = $this->inquiryRepo->update($inquiry, $request->all());

        if (! $updated) {
            return $this->errorResponse('Inquiry not found', 404);
        }

        $fresh = $updated->fresh();
        if ($request->filled('admin_response') && $fresh->user_id) {
            Notification::create([
                'user_id' => $fresh->user_id,
                'type' => 'inquiry',
                'title' => "Reply: {$fresh->subject}",
                'message' => $request->admin_response,
                'is_read' => false,
                'notifiable_type' => 'App\Models\Inquiry',
                'notifiable_id' => $fresh->id,
            ]);
        }

        if ($request->status === 'resolved' && $fresh->user_id && !$request->filled('admin_response')) {
            Notification::create([
                'user_id' => $fresh->user_id,
                'type' => 'inquiry',
                'title' => 'Inquiry Resolved',
                'message' => "Your inquiry \"{$fresh->subject}\" has been marked as resolved.",
                'is_read' => false,
                'notifiable_type' => 'App\Models\Inquiry',
                'notifiable_id' => $fresh->id,
            ]);
        }

        return $this->successResponse($fresh, 'Inquiry updated successfully');
    }

    public function destroy($inquiry)
    {
        $deleted = $this->inquiryRepo->delete($inquiry);

        if (! $deleted) {
            return $this->errorResponse('Inquiry not found', 404);
        }

        return $this->successResponse(null, 'Inquiry deleted successfully');
    }
}
