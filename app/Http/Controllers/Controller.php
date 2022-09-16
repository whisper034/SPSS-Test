<?php

namespace App\Http\Controllers;

use App\Service\Contracts\IAuthService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $authService;

    function __construct(IAuthService $authService) {
        $this->authService = $authService;
        $canRegister = $authService->CheckRegistrationPeriod();
        View::share('canRegister', $canRegister);
    }
}
