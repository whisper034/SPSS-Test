<?php

namespace App\Repository\Contracts;

interface ITimelineRepository
{
    public function FindAllWhereIn($timeline_ids);
    public function FindTwoLessThanAndGreaterOrEqualThanAndWhereIn($datetime, $timeline_ids);
}