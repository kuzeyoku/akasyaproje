<?php

namespace App\Http\Controllers;

use App\Services\MaintenanceService;

class MaintenanceController extends Controller
{
    public function index()
    {
        $date = MaintenanceService::endDate();

        return view('common.maintenance', compact('date'));
    }
}
