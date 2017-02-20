<?php
/*
 * This file is part of the mhndev\php-std package.
 *
 * (c) Majid Abdolhosseini <majid@mhndev.com>
 */
namespace mhndev\phpStd\Tests;

use mhndev\phpStd\Str;
use PHPUnit\Framework\TestCase;

/**
 * Class StrTest
 * @package mhndev\phpStd\Tests
 */
class StrTest extends TestCase
{

    function testStartsWith()
    {
        $start = 'start';
        $str = $start.'sampleTestString';
        $this->assertTrue(Str::startsWith($str, $start));
    }


    function testEndsWith()
    {
        $end = 'end';
        $str = 'sampleTestString'. $end;
        $this->assertTrue(Str::endsWith($str, $end));
    }

    function testIsJson()
    {
        $sampleArray = ['name' => 'majid', 'family' => 'abdolhosseini', 'age' => 25];

        $jsonRepresentation = json_encode($sampleArray);

        $condition = Str::isJson($jsonRepresentation) &&
            ! Str::isJson('sampleString') &&
            ! Str::isJson($sampleArray, false) &&
            ! Str::isJson(new \stdClass(), false);


        $this->assertTrue($condition);
    }


    function testCamel()
    {
        $sampleString = 'this_is_sample text';

        $this->assertTrue(Str::camel($sampleString) == 'thisIsSampleText');
    }


    function testRandom()
    {
        $randomString = Str::random('xyz123', 100);

        $this->assertTrue(!strpos($randomString, 'a') && mb_strlen($randomString) == 100);
    }



}
