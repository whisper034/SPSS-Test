<?php

namespace App\Repository\Repositories;

use App\Repository\Contracts\ITimelineRepository;
use App\Repository\Base\BaseRepository;
use App\Model\DB\Timeline;

class TimelineRepository extends BaseRepository implements ITimelineRepository
{
    public function __construct() {
        parent::__construct(new Timeline());
    }

    public function FindAllWhereIn($timeline_ids)
    {
        return Timeline::whereIn('id', $timeline_ids)->get();
    }

    public function FindTwoLessThanAndGreaterOrEqualThanAndWhereIn($datetime, $timeline_ids)
    {
        $lesserDate = Timeline::whereIn('id', $timeline_ids)
                              ->where('DateTime', '<', $datetime)
                              ->orderByDesc('DateTime')
                              ->first();
        $greaterDate = Timeline::whereIn('id', $timeline_ids)
                               ->where('DateTime', '>=', $datetime)
                               ->orderBy('DateTime')
                               ->first();
        return collect(['lesser' => $lesserDate, 'greater' => $greaterDate]);
    }
}
