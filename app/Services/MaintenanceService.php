<?php

namespace App\Services;

use App\Enums\StatusEnum;
use Carbon\Carbon;

class MaintenanceService
{
    public static function isActive()
    {
        return SettingService::get('maintenance', 'status', 'aaaaa') === StatusEnum::Active->value;
    }

    public static function endDate()
    {
        return Carbon::parse(SettingService::get('maintenance', 'end_date'))->format('d.m.Y' ?? null);
    }
}
