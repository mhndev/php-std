<?php
namespace mhndev\phpStd;

use DateTime;
use DateTimeZone;
use mhndev\phpStd\Exceptions\InvalidArgumentException;
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
    public static function toDateTime($time = null)
    {
        if($time instanceof DateTime){
            return $time;
        }

        if(is_string($time)){
            return DateTime::createFromFormat('Y-m-d H:i:s', trim($time));
        }

        if ($time instanceof UTCDateTime){
            $date = static::changeTimeZone($time->toDateTime());
            return $date;
        }

        if(is_int($time)){
            $date = new DateTime();
            $date->setTimestamp($time);

            return $date;
        }

        if(is_null($time)){
            return new DateTime();
        }

        else{
            throw new InvalidArgumentException;
        }

    }


    /**
     * @param DateTime $date
     * @return DateTime
     */
    private static function changeTimeZone(DateTime $date)
    {
        return $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
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

        if( $time instanceof DateTime){
            return new UTCDateTime($time->getTimestamp() * 1000);
        }

        if (is_null($time)) {
            $time = time();
            $time *= 1000;

            return new UTCDateTime($time);
        }


        if (isIntVal($time)) {
            $time *= 1000;

            return new UTCDateTime($time);
        }


        if(is_string($time)){
            new UTCDateTime(static::toDateTime($time)->getTimestamp() * 1000);
        }


        else{
            throw new InvalidArgumentException;
        }

    }
}
