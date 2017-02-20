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

}
