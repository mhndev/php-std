<?php
namespace mhndev\phpStd;

use DateTime;
use MongoDB\BSON\UTCDateTime;

/**
 * Class DateUtil
 */
class DateUtil
{

    /**
     * @param $time
     * @return DateTime
     */
    public static function toDateTime($time)
    {
        if ($time instanceof UTCDateTime){
            return $time->toDateTime();
        }

    }


    /**
     * @param $time
     * @return int|UTCDateTime
     */
    public static function toIsoDate($time)
    {
        if ($time instanceof UTCDateTime) {

            return $time;
        }
        if (is_null($time)) {
            $time = time();
            $time *= 1000;

            return new UTCDateTime($time);
        }
        if (is_string($time)){
            $unixTime = (int) preg_replace('/\D+/', '', $time);
            $unixTime *= 1000;

            return new UTCDateTime($unixTime);
        }

    }
}
