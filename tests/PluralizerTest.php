<?php
/*
 * This file is part of the mhndev\php-std package.
 *
 * (c) Majid Abdolhosseini <majid@mhndev.com>
 */
namespace mhndev\phpStd\Tests;

use mhndev\phpStd\Pluralizer;
use PHPUnit\Framework\TestCase;

/**
 * Class PluralizerTest
 * @package mhndev\phpStd\Tests
 */
class PluralizerTest extends TestCase
{

    function testPlural()
    {
        $namePlural = Pluralizer::plural('name');
        $personPlural = Pluralizer::plural('person');
        $colonyPlural = Pluralizer::plural('colony');

        $condition = ($namePlural == 'names') && ($personPlural == 'people') && ($colonyPlural == 'colonies');

        $this->assertTrue($condition);
    }


    function testSingular()
    {
        $namesSingular = Pluralizer::singular('names');
        $peopleSingular = Pluralizer::singular('people');
        $coloniesSingular = Pluralizer::singular('colonies');

        $condition = ($namesSingular == 'name') && ($peopleSingular == 'person') && ($coloniesSingular == 'colony');

        $this->assertTrue($condition);
    }


}
