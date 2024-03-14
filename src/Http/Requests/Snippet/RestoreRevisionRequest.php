<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Cms\Resource\Http\Requests\Snippet;

use Playground\Cms\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Resource\Http\Requests\Snippet\RestoreRevisionRequest
 */
class RestoreRevisionRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
