<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Cms\Resource\Policies\SnippetPolicy;

use Playground\Cms\Resource\Policies\SnippetPolicy;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \ests\Unit\Playground\Cms\Resource\Policies\SnippetPolicy\PolicyTest
 *
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SnippetPolicy;

        $this->assertInstanceOf(SnippetPolicy::class, $instance);
    }
}

