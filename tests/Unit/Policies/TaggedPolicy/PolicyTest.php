<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource\Policies\TaggedPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Cms\Resource\Policies\TaggedPolicy;
use Tests\Unit\Playground\Cms\Resource\TestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Policies\TaggedPolicy\PolicyTest
 */
#[CoversClass(TaggedPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new TaggedPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(TaggedPolicy::class, $instance);
    }
}
