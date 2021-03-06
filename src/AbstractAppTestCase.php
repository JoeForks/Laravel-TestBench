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
use ReflectionClass;
use RuntimeException;

/**
 * This is the abstract app test case class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class AbstractAppTestCase extends TestCase
{
    use HelperTestCaseTrait, LaravelTestCaseTrait;

    /**
     * Get the base path.
     *
     * @return string
     */
    protected function getBasePath()
    {
        $class = new ReflectionClass($this);

        $parents = [];

        // get an array of all the parent classes
        while ($parent = $class->getParentClass()) {
            $parents[] = $parent->getName();
            $class = $parent;
        }

        // we want to select the penultimate class from the list of parents
        // this is because the class directly extending this must be the
        // abstract test case the user has used in their app
        $pos = count($parents) - 5;

        if ($pos < 0) {
            throw new RuntimeException('The base path could not be automatically determined.');
        }

        // get the reflection class for the selected class
        $selected = new ReflectionClass($parents[$pos]);

        // get the filepath of the selected class
        $path = $selected->getFileName();

        // return the filepath one up from the folder the selected class is saved in
        return realpath(dirname($path).'/../');
    }

    /**
     * Get application timezone.
     *
     * @param \Illuminate\Foundation\Contracts\Application $app
     *
     * @return string
     */
    protected function getApplicationTimezone($app)
    {
        return $app['config']['app.timezone'];
    }

    /**
     * Get application aliases.
     *
     * @param \Illuminate\Foundation\Contracts\Application $app
     *
     * @return array
     */
    protected function getApplicationAliases($app)
    {
        return $app['config']['app.aliases'];
    }

    /**
     * Get application providers.
     *
     * @param \Illuminate\Foundation\Contracts\Application $app
     *
     * @return array
     */
    protected function getApplicationProviders($app)
    {
        return $app['config']['app.providers'];
    }

    /**
     * Setup the application environment.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
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
