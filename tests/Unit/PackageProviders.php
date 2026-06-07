<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource;

use Playground\ServiceProvider;

/**
 * \Tests\Unit\Playground\Cms\Resource\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\Test\ServiceProvider::class,
            ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Blade\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Login\Blade\ServiceProvider::class,
            \Playground\Site\Blade\ServiceProvider::class,
            \Playground\Cms\ServiceProvider::class,
            \Playground\Cms\Resource\ServiceProvider::class,
        ];
    }
}
