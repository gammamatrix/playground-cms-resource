<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Cms\Resource\Http\Requests\FormRequest;

use Playground\Cms\Resource\Http\Requests\FormRequest;
use Playground\Test\Models\PlaygroundUser as User;
use Playground\Test\Models\User as DefaultLaravelUser;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Http\Requests\FormRequest\InstanceTest
 */
class InstanceTest extends TestCase
{
    protected bool $load_migrations_playground = true;

    public function test_FormRequest_authorize_without_user(): void
    {
        $instance = new FormRequest;

        $this->assertFalse($instance->authorize());
    }

    public function test_RULES_is_empty_by_default(): void
    {
        $instance = new FormRequest;

        $this->assertIsArray($instance->rules());
        $this->assertEmpty($instance->rules());
    }

    public function test_userHasAdminPrivileges_without_user(): void
    {
        $instance = new FormRequest;

        $this->assertFalse($instance->userHasAdminPrivileges());
    }

    public function test_userHasAdminPrivileges_with_admin(): void
    {
        /**
         * @var User $user
         */
        $user = User::factory()->admin()->make();

        $instance = new FormRequest;

        $this->assertTrue($instance->userHasAdminPrivileges($user));
    }

    public function test_userHasAdminPrivileges_with_default_laravel_user(): void
    {
        /**
         * @var DefaultLaravelUser $user
         */
        $user = DefaultLaravelUser::factory()->admin()->make();

        $instance = new FormRequest;

        /**
         * NOTE: all users will be an admin since there is no difference
         * between a regular user.
         */
        $this->assertTrue($instance->userHasAdminPrivileges($user));
    }
}
