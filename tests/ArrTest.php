<?php
/*
 * This file is part of the mhndev\php-std package.
 *
 * (c) Majid Abdolhosseini <majid@mhndev.com>
 */
namespace mhndev\phpStd\Tests;

use mhndev\phpStd\Arr;
use PHPUnit\Framework\TestCase;

/**
 * Class ArrTest
 * @package mhndev\phpStd\Tests
 */
class ArrTest extends TestCase
{


    function testAccessible()
    {
        $array = [1,2,3,4];

        $this->assertTrue(Arr::accessible($array));
    }
}
