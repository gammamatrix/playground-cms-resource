<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Cms\Resource\Http\Requests\Snippet;

use Playground\Cms\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Resource\Http\Requests\Snippet\LockRequest
 */
class LockRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}
