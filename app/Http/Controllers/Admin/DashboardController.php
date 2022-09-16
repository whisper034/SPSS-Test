<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Service\Contracts\IAdminService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $adminService;

    public function __construct(IAdminService $adminService) {
        $this->adminService = $adminService;
        $this->middleware(['auth:admin']);
    }

    public function index()
    {
        $dashboardInformation = $this->adminService->GetDashboardInformation();
        $viewData = [
            'statistics' => $dashboardInformation['Statistics'],
            'reminders' => $dashboardInformation['Reminder']
        ];
        return view('admin.dashboard', $viewData);
    }
}
