<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Cms\Resource\Policies\SnippetPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Resource\Policies\SnippetPolicy;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Policies\SnippetPolicy\PolicyTest
 */
#[CoversClass(SnippetPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SnippetPolicy;

        $this->assertInstanceOf(SnippetPolicy::class, $instance);
    }
}
