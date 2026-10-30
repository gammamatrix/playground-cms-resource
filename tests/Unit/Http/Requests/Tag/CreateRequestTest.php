<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag;

use Playground\Cms\Resource\Http\Requests\Tag\CreateRequest;
use Tests\Unit\Playground\Cms\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag\CreateRequestTest
 */
class CreateRequestTest extends RequestTestCase
{
    protected string $requestClass = CreateRequest::class;
}
