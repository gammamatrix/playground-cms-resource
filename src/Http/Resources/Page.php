<?php
/**
 * Playground
 */
declare(strict_types=1);
namespace Playground\Cms\Resource\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Playground\Cms\Models\Page as PageModel;
use Playground\Cms\Resource\Http\Requests\FormRequest;

/**
 * \Playground\Cms\Resource\Http\Resources\Page
 */
class Page extends JsonResource
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request&FormRequest $request
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        /**
         * @var ?PageModel $page
         */
        $page = $request->route('page');

        return [
            'meta' => [
                'id' => $page?->id,
                'rules' => $request->rules(),
                'session_user_id' => $request->user()?->id,
                'timestamp' => Carbon::now()->toJson(),
                'validated' => $request->validated(),
            ],
        ];
    }
}
