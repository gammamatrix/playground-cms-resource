<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Resource\Http\Controllers\Playground;

use Playground\Test\Models\PlaygroundUser as User;
use Tests\Feature\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Feature\Playground\Cms\Resource\Http\Controllers\Playground\IndexRouteTest
 */
class IndexRouteTest extends TestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    public function test_guest_cannot_render_index_view(): void
    {
        $url = route('playground.cms.resource');

        $response = $this->get($url);

        $response->assertStatus(403);
    }

    public function test_admin_can_render_index_view(): void
    {
        /**
         * @var User $user
         */
        $user = User::factory()->admin()->create();

        $url = route('playground.cms.resource');

        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(200);

        $this->assertAuthenticated();
    }
}
