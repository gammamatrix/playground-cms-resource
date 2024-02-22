<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Cms\Resource\Policies\PagePolicy;

use Playground\Cms\Resource\Policies\PagePolicy;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \ests\Unit\Playground\Cms\Resource\Policies\PagePolicy\PolicyTest
 *
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new PagePolicy;

        $this->assertInstanceOf(PagePolicy::class, $instance);
    }
}

