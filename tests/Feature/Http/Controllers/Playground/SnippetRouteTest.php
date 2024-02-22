<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Resource\Http\Controllers\Playground;

use Tests\Feature\Playground\Cms\Resource\Http\Controllers\SnippetTestCase;

/**
 * \Tests\Feature\Playground\Cms\Resource\Http\Controllers\Playground\SnippetRouteTest
 */
class SnippetRouteTest extends SnippetTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_cms = true;
}
