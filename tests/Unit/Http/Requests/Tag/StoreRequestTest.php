<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag;

use Playground\Cms\Resource\Http\Requests\Tag\StoreRequest;
use Tests\Unit\Playground\Cms\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag\StoreRequestTest
 */
class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;
}
