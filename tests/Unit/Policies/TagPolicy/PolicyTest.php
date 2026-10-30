<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource\Policies\TagPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Resource\Policies\TagPolicy;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Policies\TagPolicy\PolicyTest
 */
#[CoversClass(TagPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new TagPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(TagPolicy::class, $instance);
    }
}
