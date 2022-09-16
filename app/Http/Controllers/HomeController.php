<?php

namespace App\Http\Controllers;

use App\Model\Lookups\Timeline;
use App\Service\Contracts\IAuthService;
use App\Service\Contracts\ITimelineService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $timelineService;

    private $authService;

    private $viewData = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ITimelineService $timelineService, IAuthService $authService)
    {
        $this->timelineService= $timelineService;
        $this->authService = $authService;
        $this->viewData = collect([]);
        parent::__construct($authService);
    }

    public function index()
    {
        return view('index', $this->viewData);
    }

    public function seminar()
    {
        $timeline = $this->timelineService->GetTimelineByID(Timeline::SEMINAR);
        $this->viewData->put('countdown', $timeline->DateTime->valueOf());
        return view('seminar', $this->viewData);
    }

    public function lomba()
    {
        $timeline = $this->timelineService->GetTimelineByID(Timeline::AKHIR_PENDAFTARAN);
        $this->viewData->put('countdown', $timeline->DateTime->valueOf());
        return view('lomba', $this->viewData);
    }

    public function about()
    {
        return view('about', $this->viewData);
    }
}
