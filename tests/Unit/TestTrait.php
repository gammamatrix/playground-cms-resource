<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Cms\Resource;

use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Blade\ServiceProvider as PlaygroundBladeServiceProvider;
use Playground\Cms\Resource\ServiceProvider;
use Playground\Cms\ServiceProvider as PlaygroundCmsServiceProvider;
use Playground\Http\ServiceProvider as PlaygroundHttpServiceProvider;
use Playground\Login\Blade\ServiceProvider as PlaygroundLoginBladeServiceProvider;
use Playground\ServiceProvider as PlaygroundServiceProvider;
use Playground\Site\Blade\ServiceProvider as PlaygroundSiteBladeServiceProvider;

/**
 * \Tests\Unit\Playground\Cms\Resource\TestTrait
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
