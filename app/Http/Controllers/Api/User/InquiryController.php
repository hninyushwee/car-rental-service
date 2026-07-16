<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\InquiryRequest;
use App\Models\Inquiry;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 15);
        return $this->successResponse(
            Inquiry::where('user_id', $request->user()->id)->latest()->paginate($perPage)
        );
    }

    public function store(InquiryRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['email'] = $request->user()->email;

        $inquiry = Inquiry::create($validated);

        Notification::create([
            'user_id' => null,
            'type' => 'inquiry',
            'title' => 'New Inquiry',
            'message' => "{$request->user()->name} has submitted a new inquiry: {$inquiry->subject}.",
            'is_read' => false,
            'notifiable_type' => 'App\Models\Inquiry',
            'notifiable_id' => $inquiry->id,
        ]);

        return $this->successResponse($inquiry->load('user'), 'Inquiry submitted successfully', 201);
    }

    public function show(Request $request, Inquiry $inquiry)
    {
        if ($inquiry->user_id !== $request->user()->id) {
            return $this->errorResponse('Unauthorized', 403);
        }
        return $this->successResponse($inquiry);
    }
}
