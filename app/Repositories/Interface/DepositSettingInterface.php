<?php

namespace App\Repositories\Interface;

interface DepositSettingInterface
{
    public function getByServiceKey(string $serviceKey);
}
