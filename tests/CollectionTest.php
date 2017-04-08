<?php
/*
 * This file is part of the mhndev\php-std package.
 *
 * (c) Majid Abdolhosseini <majid@mhndev.com>
 */
namespace mhndev\phpStd\Tests;

use mhndev\phpStd\Collection;
use PHPUnit\Framework\TestCase;

/**
 * Class CollectionTest
 * @package mhndev\phpStd\Tests
 */
class CollectionTest extends TestCase
{

    function testFirst()
    {
        $myNumbers = new Collection();
        $myNumbers->add(1);
        $myNumbers->add(2);
        $myNumbers->add(3);

        $this->assertEquals(1, $myNumbers->first());
    }

    function testDel()
    {
        $names = new Collection();
        $names->add('jane');
        $names->add('john');
        $names->add('mike');

        $names->del(1);

        $this->assertEquals(2, $names->count());
        $this->assertEquals($names->get(1), 'mike');
    }


    function testAdd()
    {
        $names = new Collection([
            'mike', 'tommy', 'anne'
        ]);

        $names->add('david');

        $this->assertEquals(4, $names->count());
        $this->assertEquals($names->get(3), 'david');

    }


    function testMerge()
    {
        $names = new Collection([
            'mike', 'tommy', 'anne'
        ]);

        $second_array = ['jane', 'johny', 'dave', 'mary'];

        $newCollection = $names->merge($second_array);

        $this->assertEquals(7, $newCollection->count());
        $this->assertEquals('jane', $newCollection->get(3));
    }


    function testDelByValue()
    {
        $names = new Collection([
            'mike', 'tommy', 'anne'
        ]);

        $names->delByValue('tommy');

        $this->assertEquals(2, $names->count());
        $this->assertEquals($names->get(1), 'anne');

    }


    function testCount()
    {
        $names = new Collection([
            'mike', 'tommy', 'anne'
        ]);


        $this->assertEquals(3, $names->count());
    }


}
