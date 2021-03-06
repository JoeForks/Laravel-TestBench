<?php

/*
 * This file is part of Laravel TestBench.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Tests\TestBench;

use GrahamCampbell\TestBench\AbstractTestCase as AbstractTestBenchTestCase;

/**
 * This is the helpers test class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class HelpersTest extends AbstractTestBenchTestCase
{
    public function testInArray()
    {
        $this->assertInArray('foo', ['foo']);
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     */
    public function testNotInArray()
    {
        $this->assertInArray('foo', ['bar']);
    }

    public function testMethodDoesExist()
    {
        $this->assertMethodExists('getBar', 'GrahamCampbell\Tests\TestBench\FooStub');
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     */
    public function testMethodDoesNotExist()
    {
        $this->assertMethodExists('getFoo', 'GrahamCampbell\Tests\TestBench\FooStub');
    }
}
