<?php

/*
 * This file is part of Laravel TestBench.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\TestBench\Traits;

use Mockery;

/**
 * This is the helper test case trait.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
trait HelperTestCaseTrait
{
    /**
     * Setup the test case.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->start();
    }

    /**
     * Run extra setup code.
     *
     * @return void
     */
    protected function start()
    {
        // call more setup methods
    }

    /**
     * Tear down the test case.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->finish();

        parent::tearDown();

        if ($container = Mockery::getContainer()) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        Mockery::close();
    }

    /**
     * Run extra tear down code.
     *
     * @return void
     */
    protected function finish()
    {
        // call more tear down methods
    }

    /**
     * Assert that the element exists in the array.
     *
     * @param mixed  $needle
     * @param array  $haystack
     * @param string $msg
     *
     * @return void
     */
    public static function assertInArray($needle, $haystack, $msg = '')
    {
        if ($msg === '') {
            $msg = "Expected the array to contain the element '$needle'.";
        }

        static::assertTrue(in_array($needle, $haystack, true), $msg);
    }

    /**
     * Assert that the specified method exists on the class.
     *
     * @param string $method
     * @param string $class
     * @param string $msg
     *
     * @return void
     */
    public static function assertMethodExists($method, $class, $msg = '')
    {
        if ($msg === '') {
            $msg = "Expected the class '$class' to have method '$method'.";
        }

        static::assertTrue(method_exists($class, $method), $msg);
    }
}
