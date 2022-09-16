<?php

namespace App\Http\Controllers\Admin;

use App\Model\Lookups\Role;
use App\Model\Lookups\Timeline;
use App\Service\Contracts\ITimelineService;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    private $timelineService;

    private $originalTimeline = [
        Timeline::AWAL_PENDAFTARAN => '',
        Timeline::AKHIR_PENDAFTARAN => '',
        Timeline::AWAL_TAHAP_1 => '',
        Timeline::AKHIR_TAHAP_1 => '',
        Timeline::PENGUMUMAN_TAHAP_1 => '',
        Timeline::AWAL_TAHAP_2 => '',
        Timeline::AKHIR_TAHAP_2 => '',
        Timeline::PENGUMUMAN_TAHAP_2 => '',
        Timeline::AWAL_PENGERJAAN_TAHAP_3 => '',
        Timeline::AKHIR_PENGERJAAN_TAHAP_3 => '',
        Timeline::PRESENTASI_TAHAP_3 => '',
        Timeline::PENGUMUMAN_PEMENANG => '',
        Timeline::SEMINAR => '',
    ];

    public function __construct(ITimelineService $timelineService)
    {
        $this->timelineService = $timelineService;
        $this->middleware(['auth:admin']);
        $this->middleware(['check-role:'.Role::SUPERADMIN])->except(['index']);
        $this->setOriginalTimeline();
    }

    public function index($id = null)
    {
        $viewData = [
            'timelines' => $this->timelineService->GetTimelines()
        ];
        if (!is_null($id)){
            $viewData = array_merge($viewData, [
                'timeline' => $this->timelineService->GetTimelineByID($id)
            ]);
        }
        return view('admin.timeline', $viewData);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $data['DateTime'] = Carbon::createFromFormat('Y-m-d H:i:s', $data['DateTime']);
        $this->timelineService->UpdateTimeline($data);
        return redirect('/admin/timeline');
    }

    public function reset()
    {
        $originalTimeline = collect($this->originalTimeline);
        $originalTimeline->each(function ($item, $key)
        {
            $data = [];
            $data['id'] = $key;
            $data['DateTime'] = $item;
            $this->timelineService->UpdateTimeline($data);
        });
        return redirect('/admin/timeline');
    }

    private function setOriginalTimeline()
    {
        $this->originalTimeline[Timeline::AWAL_PENDAFTARAN] = Carbon::create(2020, 9, 1, 00, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::AKHIR_PENDAFTARAN] = Carbon::create(2020, 10, 8, 23, 59, 59, '+07:00');
        $this->originalTimeline[Timeline::AWAL_TAHAP_1] = Carbon::create(2020, 11, 1, 12, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::AKHIR_TAHAP_1] = Carbon::create(2020, 11, 4, 23, 59, 59, '+07:00');
        $this->originalTimeline[Timeline::PENGUMUMAN_TAHAP_1] = Carbon::create(2020, 11, 10, 12, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::AWAL_TAHAP_2] = Carbon::create(2020, 11, 14, 13, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::AKHIR_TAHAP_2] = Carbon::create(2020, 11, 14, 15, 30, 00, '+07:00');
        $this->originalTimeline[Timeline::PENGUMUMAN_TAHAP_2] = Carbon::create(2020, 11, 15, 12, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::AWAL_PENGERJAAN_TAHAP_3] = Carbon::create(2020, 11, 27, 12, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::AKHIR_PENGERJAAN_TAHAP_3] = Carbon::create(2020, 11, 27, 16, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::PRESENTASI_TAHAP_3] = Carbon::create(2020, 11, 28, 13, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::PENGUMUMAN_PEMENANG] = Carbon::create(2020, 11, 29, 13, 00, 00, '+07:00');
        $this->originalTimeline[Timeline::SEMINAR] = Carbon::create(2020, 11, 26, 13, 00, 00, '+07:00');
    }
}
