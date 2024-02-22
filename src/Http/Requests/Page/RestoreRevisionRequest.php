<?php
/**
 * Playground
 */
namespace Playground\Cms\Resource\Http\Requests\Page;

use Playground\Cms\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Resource\Http\Requests\Page\RestoreRevisionRequest
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
