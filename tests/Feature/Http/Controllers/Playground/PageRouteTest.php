<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Cms\Resource\Http\Controllers\Playground;

use Tests\Feature\Playground\Cms\Resource\Http\Controllers\PageTestCase;

/**
 * \Tests\Feature\Playground\Cms\Resource\Http\Controllers\Playground\PageRouteTest
 */
class PageRouteTest extends PageTestCase
{
    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_cms = true;
}
