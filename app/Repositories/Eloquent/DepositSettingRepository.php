<?php

namespace App\Repositories\Eloquent;

use App\Models\DepositSetting;
use App\Repositories\Interface\DepositSettingInterface;

class DepositSettingRepository implements DepositSettingInterface
{
    public function getByServiceKey(string $serviceKey)
    {
        return DepositSetting::where('service_key', $serviceKey)->where('is_active', true)->first();
    }
}
