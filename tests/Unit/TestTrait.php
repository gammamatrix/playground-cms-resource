<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Cms\Resource;

use Playground\ServiceProvider as PlaygroundServiceProvider;
use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Blade\ServiceProvider as PlaygroundBladeServiceProvider;
use Playground\Http\ServiceProvider as PlaygroundHttpServiceProvider;
use Playground\Cms\ServiceProvider as PlaygroundCmsServiceProvider;
use Playground\Login\Blade\ServiceProvider as PlaygroundLoginBladeServiceProvider;
use Playground\Site\Blade\ServiceProvider as PlaygroundSiteBladeServiceProvider;
use Playground\Cms\Resource\ServiceProvider;

/**
 * \Tests\Unit\Playground\Cms\Resource\TestTrait
 *
 */
trait TestTrait
{
    protected function getPackageProviders($app)
    {
        return [
            PlaygroundAuthServiceProvider::class,
            PlaygroundBladeServiceProvider::class,
            PlaygroundHttpServiceProvider::class,
            PlaygroundLoginBladeServiceProvider::class,
            PlaygroundSiteBladeServiceProvider::class,
            PlaygroundCmsServiceProvider::class,
            PlaygroundServiceProvider::class,
            ServiceProvider::class,
        ];
    }
}
