<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag;

use Playground\Cms\Resource\Http\Requests\Tag\DestroyRequest;
use Tests\Unit\Playground\Cms\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag\DestroyRequestTest
 */
class DestroyRequestTest extends RequestTestCase
{
    protected string $requestClass = DestroyRequest::class;
}
