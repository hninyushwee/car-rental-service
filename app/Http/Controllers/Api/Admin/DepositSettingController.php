<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\DepositSetting;
use Illuminate\Http\Request;

class DepositSettingController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $query = DepositSetting::query();

        if ($request->filled('search')) {
            $query->where('service_key', 'like', '%' . $request->search . '%');
        }

        return $this->successResponse($query->paginate($perPage));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_key' => 'required|string|unique:deposit_settings,service_key',
            'amount' => 'required|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $setting = DepositSetting::create($validated);

        return $this->successResponse($setting, 'Deposit setting created successfully', 201);
    }

    public function show(DepositSetting $depositSetting)
    {
        return $this->successResponse($depositSetting);
    }

    public function update(Request $request, DepositSetting $depositSetting)
    {
        $validated = $request->validate([
            'service_key' => 'sometimes|string|unique:deposit_settings,service_key,' . $depositSetting->id,
            'amount' => 'sometimes|numeric|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        $depositSetting->update($validated);

        return $this->successResponse($depositSetting->fresh(), 'Deposit setting updated successfully');
    }

    public function destroy(DepositSetting $depositSetting)
    {
        $depositSetting->delete();

        return $this->successResponse(null, 'Deposit setting deleted successfully');
    }
}
