<?php
/*
 * This file is part of the mhndev\php-std package.
 *
 * (c) Majid Abdolhosseini <majid@mhndev.com>
 */
namespace mhndev\phpStd\Tests;

use DateTime;
use mhndev\phpStd\DateUtil;
use MongoDB\BSON\UTCDateTime;
use PHPUnit\Framework\TestCase;

/**
 * Class DateUtilTest
 * @package mhndev\phpStd\Tests
 */
class DateUtilTest extends TestCase
{


    function testTimestampToDateTime()
    {
        $dateTime = new DateTime();
        $timestamp  = $dateTime->getTimestamp();

        $result = DateUtil::toDateTime($timestamp);

        $this->assertInstanceOf(DateTime::class, $result);
        $this->assertEquals($timestamp, $result->getTimestamp());
    }


    function testNullToDateTime()
    {
        $date = DateUtil::toDateTime(null);

        $this->assertInstanceOf(DateTime::class, $date);
    }


    function testDateTimeToIsoDate()
    {
        if(class_exists(UTCDateTime::class)){
            $dateTime = new DateTime();

            $result = DateUtil::toIsoDate($dateTime);

            $this->assertInstanceOf(UTCDateTime::class, $result);
            $this->assertEquals($result->toDateTime()->getTimestamp(), $dateTime->getTimestamp());
        }

    }

}
