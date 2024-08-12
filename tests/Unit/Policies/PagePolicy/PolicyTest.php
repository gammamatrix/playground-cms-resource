<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Cms\Resource\Policies\PagePolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Resource\Policies\PagePolicy;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Policies\PagePolicy\PolicyTest
 */
#[CoversClass(PagePolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new PagePolicy;

        $this->assertInstanceOf(PagePolicy::class, $instance);
    }
}
