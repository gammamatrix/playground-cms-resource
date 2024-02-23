<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Cms\Resource\Http\Requests\FormRequest;

use Illuminate\Support\Facades\Auth;
// use Playground\Http\Requests\StoreRequest;
// use Playground\Test\MockingTrait;
use Playground\Cms\Resource\Http\Requests\FormRequest;
use Playground\Test\Models\PlaygroundUser as User;
use Tests\Feature\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Feature\Playground\Cms\Resource\Http\Requests\FormRequest\InstanceTest
 */
class InstanceTest extends TestCase
{
    // use MockingTrait;

    protected bool $load_migrations_playground = true;

    // /**
    //  * @param array<string, mixed> $input
    //  */
    // public function getStoreRequest(
    //     array $input = [],
    //     string $uri = '/testing',
    //     string $method = 'POST',
    // ): StoreRequest {
    //     /**
    //      * @var StoreRequest
    //      */
    //     $instance = $this->mockRequest(
    //         StoreRequest::class,
    //         $uri,
    //         $method,
    //         $input
    //     );

    //     return $instance;
    // }

    public function test_FormRequest_authorize_with_admin(): void
    {
        /**
         * @var User $user
         */
        $user = User::factory()->admin()->create();

        Auth::setUser($user);

        // $instance = $this->getStoreRequest();
        $instance = new FormRequest;
        $instance->setUserResolver(function () use ($user) {
            return $user;
        });
        $this->assertTrue($instance->authorize());
    }
}
