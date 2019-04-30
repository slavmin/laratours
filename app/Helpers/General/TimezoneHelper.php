<?php

namespace App\Helpers\General;

use Carbon\Carbon;

/**
 * Class Timezone.
 */
class TimezoneHelper
{
    /**
     * @param Carbon $date
     * @param string $format //  $format = 'D M j G:i:s T Y'
     *
     * @return Carbon
     */
    public function convertToLocal(Carbon $date, $format = 'd.m.Y H:i:s') : string
    {
        return $date->setTimezone(auth()->user()->timezone ?? config('app.timezone'))->format($format);
    }

    /**
     * @param $date
     *
     * @return Carbon
     */
    public function convertFromLocal($date) : Carbon
    {
        return Carbon::parse($date, auth()->user()->timezone)->setTimezone('UTC');
    }
}
