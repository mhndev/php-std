<?php
namespace mhndev\phpStd;

use DateTime;
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
    public static function toDateTime($time)
    {
        if($time instanceof DateTime){
            return $time;
        }

        if ($time instanceof UTCDateTime){
            return $time->toDateTime();
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
        if (is_string($time)) {
            $unixTime = (int) preg_replace('/\D+/', '', $time);
            $unixTime *= 1000;

            return new UTCDateTime($unixTime);
        }


        else{
            throw new InvalidArgumentException;
        }

    }
}
