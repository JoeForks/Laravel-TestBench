<?php

/*
 * This file is part of Laravel TestBench.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\TestBench;

use GrahamCampbell\TestBench\Traits\HelperTestCaseTrait;
use GrahamCampbell\TestBench\Traits\LaravelTestCaseTrait;
use Orchestra\Testbench\TestCase;

/**
 * This is the abstract package test case class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class AbstractPackageTestCase extends TestCase
{
    use HelperTestCaseTrait, LaravelTestCaseTrait;

    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.driver', 'array');

        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('mail.drive', 'log');

        $app['config']->set('session.driver', 'array');

        $this->additionalSetup($app);
    }

    /**
     * Additional application environment setup.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function additionalSetup($app)
    {
        //
    }

    /**
     * Get the package service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getPackageProviders($app)
    {
        $provider = $this->getServiceProviderClass($app);

        if ($provider) {
            return array_merge($this->getRequiredServiceProviders($app), [$provider]);
        }

        return $this->getRequiredServiceProviders($app);
    }

    /**
     * Get the required service providers.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string[]
     */
    protected function getRequiredServiceProviders($app)
    {
        return [];
    }

    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        // this may be overwritten, and must be overwritten
        // if used with the service provider test case trait
    }
}
