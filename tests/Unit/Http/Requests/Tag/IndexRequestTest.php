<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag;

use Playground\Cms\Resource\Http\Requests\Tag\IndexRequest;
use Tests\Unit\Playground\Cms\Resource\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Cms\Resource\Http\Requests\Tag\IndexRequestTest
 */
class IndexRequestTest extends RequestTestCase
{
    protected string $requestClass = IndexRequest::class;
}
