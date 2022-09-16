<?php

namespace App\Service\Modules;

use App\Model\Lookups\Tahap;
use App\Model\Lookups\Timeline;
use App\Service\Contracts\ITimelineService;
use App\Repository\Contracts\ITimelineRepository;
use Carbon\Carbon;

class TimelineService implements ITimelineService
{
    private $timelineRepository;

    public function __construct(ITimelineRepository $timelineRepository) {
        $this->timelineRepository = $timelineRepository;
    }

    public function GetTimelines()
    {
        return $this->timelineRepository->FindAll();
    }

    public function GetTimelineByID($timeline_id)
    {
        return $this->timelineRepository->Find($timeline_id);
    }

    public function UpdateTimeline($data)
    {
        $timeline = $this->timelineRepository->Find($data['id']);
        $timeline->DateTime = $data['DateTime'];

        $this->timelineRepository->InsertUpdate($timeline);
    }

    public function GetTahapDropdown()
    {
        $result = [
            'ddl' => [
                Tahap::TAHAP_1 => 'Tahap 1', 
                Tahap::TAHAP_2 => 'Tahap 2', 
                Tahap::TAHAP_3 => 'Tahap 3',
            ],
            'selected' => null
        ];

        $now = Carbon::now();
        $timelines = $this->timelineRepository->FindAllWhereIn([
            Timeline::PENGUMUMAN_TAHAP_1,
            Timeline::PENGUMUMAN_TAHAP_2,
            Timeline::PENGUMUMAN_PEMENANG,
        ]);

        if ($now->lessThan($timelines[0]->DateTime)){
            $result['selected'] = Tahap::TAHAP_1;
        }
        else if ($now->lessThan($timelines[1]->DateTime)){
            $result['selected'] = Tahap::TAHAP_2;
        }
        else if ($now->lessThan($timelines[2]->DateTime)){
            $result['selected'] = Tahap::TAHAP_3;
        }
        
        return $result;
    }

    public function GetLombaStartAndEndDate($tahap_id)
    {
        $mapLombaStartDateAndEndDate = [
            Tahap::TAHAP_1 => [Timeline::AWAL_TAHAP_1, Timeline::AKHIR_TAHAP_1],
            Tahap::TAHAP_2 => [Timeline::AWAL_TAHAP_2, Timeline::AKHIR_TAHAP_2],
            Tahap::TAHAP_3 => [Timeline::AWAL_PENGERJAAN_TAHAP_3, Timeline::AKHIR_PENGERJAAN_TAHAP_3],
        ];
        return [
            'Start Date' => 
                $this->timelineRepository->Find($mapLombaStartDateAndEndDate[$tahap_id][0])->DateTime,
            'End Date' => 
                $this->timelineRepository->Find($mapLombaStartDateAndEndDate[$tahap_id][1])->DateTime,
        ];
    }
}
