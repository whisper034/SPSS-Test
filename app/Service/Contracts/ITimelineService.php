<?php

namespace App\Service\Contracts;

interface ITimelineService
{
    public function GetTimelines();
    public function GetTimelineByID($timeline_id);
    public function UpdateTimeline($data);
    public function GetTahapDropdown();
    public function GetLombaStartAndEndDate($tahap_id);
}