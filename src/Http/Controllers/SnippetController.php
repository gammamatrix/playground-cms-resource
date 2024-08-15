<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Playground\Cms\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;
use Playground\Cms\Resource\Http\Requests;
use Playground\Cms\Resource\Http\Resources;

/**
 * \Playground\Cms\Resource\Http\Controllers\SnippetController
 */
class SnippetController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Snippet',
        'model_label_plural' => 'Snippets',
        'model_route' => 'playground.cms.resource.snippets',
        'model_slug' => 'snippet',
        'model_slug_plural' => 'snippets',
        'module_label' => 'CMS',
        'module_label_plural' => 'CMS',
        'module_route' => 'playground.cms.resource',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-resource:snippet',
        'table' => 'cms_snippets',
        'view' => 'playground-cms-resource::snippet',
    ];

    /**
     * Create the Snippet resource in storage.
     *
     * @route GET /resource/cms/snippets/create playground.cms.resource.snippets.create
     */
    public function create(
        Requests\Snippet\CreateRequest $request
    ): JsonResponse|View|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => null,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $snippet,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $snippet->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Edit the Snippet resource in storage.
     *
     * @route GET /resource/cms/snippets/edit/{snippet} playground.cms.resource.snippets.edit
     */
    public function edit(
        Snippet $snippet,
        Requests\Snippet\EditRequest $request
    ): JsonResponse|View|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $snippet->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $snippet,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Snippet resource from storage.
     *
     * @route DELETE /resource/cms/snippets/{snippet} playground.cms.resource.snippets.destroy
     */
    public function destroy(
        Snippet $snippet,
        Requests\Snippet\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        if (empty($validated['force'])) {
            $snippet->delete();
        } else {
            $snippet->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route($this->packageInfo['model_route']));
    }

    /**
     * Lock the Snippet resource in storage.
     *
     * @route PUT /resource/cms/snippets/{snippet} playground.cms.resource.snippets.lock
     */
    public function lock(
        Snippet $snippet,
        Requests\Snippet\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->locked = true;

        $snippet->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['snippet' => $snippet->id]));
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /resource/cms/snippets playground.cms.resource.snippets
     */
    public function index(
        Requests\Snippet\IndexRequest $request
    ): JsonResponse|View|Resources\SnippetCollection {

        $user = $request->user();

        $validated = $request->validated();

        $query = Snippet::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {

            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new Resources\SnippetCollection($paginator))->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'columns' => $request->getPaginationColumns(),
            'dates' => $request->getPaginationDates(),
            'flags' => $request->getPaginationFlags(),
            'ids' => $request->getPaginationIds(),
            'rules' => $request->rules(),
            'sortable' => $request->getSortable(),
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/index', $this->packageInfo['view']), $data);
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /resource/cms/snippets/restore/{snippet} playground.cms.resource.snippets.restore
     */
    public function restore(
        Snippet $snippet,
        Requests\Snippet\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->restore();

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['snippet' => $snippet->id]));
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /resource/cms/snippets/revision/{snippet_revision} playground.cms.resource.snippets.revision.restore
     */
    public function restoreRevision(
        SnippetRevision $snippet_revision,
        Requests\Snippet\RestoreRevisionRequest $request
    ): JsonResponse|RedirectResponse|Resources\Snippet {
        $validated = $request->validated();

        /**
         * @var Snippet $snippet
         */
        $snippet = Snippet::where(
            'id',
            $snippet_revision->snippet_id
        )->firstOrFail();

        $this->saveRevision($snippet);

        $user = $request->user();

        foreach ($snippet->getFillable() as $column) {
            $snippet->setAttribute(
                $column,
                $snippet_revision->getAttributeValue($column)
            );
        }

        $snippet->save();

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['snippet' => $snippet->id]));
    }

    /**
     * Display the Snippet revision.
     *
     * @route GET /resource/cms/snippets/revision/{snippet_revision} playground.cms.resource.snippets.revision
     */
    public function revision(
        SnippetRevision $snippet_revision,
        Requests\Snippet\ShowRevisionRequest $request
    ): JsonResponse|View|Resources\SnippetRevision {

        if ($request->expectsJson()) {
            return (new Resources\SnippetRevision($snippet_revision))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
            'input' => $request->input(),
        ];

        $data = [
            'data' => $snippet_revision,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/revision', $this->packageInfo['view']), $data);
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /resource/cms/snippets/{snippet}/revisions playground.cms.resource.snippets.revisions
     */
    public function revisions(
        Snippet $snippet,
        Requests\Snippet\RevisionsRequest $request
    ): JsonResponse|View|Resources\SnippetRevisionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = $snippet->revisions();

        $query->sort($validated['sort'] ?? null);

        if (! empty($validated['filter']) && is_array($validated['filter'])) {
            $query->filterTrash($validated['filter']['trash'] ?? null);

            $query->filterIds(
                $request->getPaginationIds(),
                $validated
            );

            $query->filterFlags(
                $request->getPaginationFlags(),
                $validated
            );

            $query->filterDates(
                $request->getPaginationDates(),
                $validated
            );

            $query->filterColumns(
                $request->getPaginationColumns(),
                $validated
            );
        }

        $perPage = ! empty($validated['perPage']) && is_int($validated['perPage']) ? $validated['perPage'] : null;
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new Resources\SnippetRevisionCollection($paginator))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $meta = [
            'session_user_id' => $user?->id,
            'columns' => $request->getPaginationColumns(),
            'dates' => $request->getPaginationDates(),
            'flags' => $request->getPaginationFlags(),
            'ids' => $request->getPaginationIds(),
            'rules' => $request->rules(),
            'sortable' => $request->getSortable(),
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $data = [
            'paginator' => $paginator,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/revisions', $this->packageInfo['view']), $data);
    }

    /**
     * Save a revision of a Snippet.
     */
    public function saveRevision(Snippet $snippet): SnippetRevision
    {
        $revision = new SnippetRevision($snippet->toArray());

        $revision->created_by_id = $snippet->created_by_id;
        $revision->modified_by_id = $snippet->modified_by_id;
        $revision->owned_by_id = $snippet->owned_by_id;
        $revision->snippet_id = $snippet->id;

        $r = SnippetRevision::where('snippet_id', $snippet->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $snippet->revision = $r;

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Snippet resource.
     *
     * @route GET /resource/cms/snippets/{snippet} playground.cms.resource.snippets.show
     */
    public function show(
        Snippet $snippet,
        Requests\Snippet\ShowRequest $request
    ): JsonResponse|View|Resources\Snippet {

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
            'input' => $request->input(),
        ];

        $data = [
            'data' => $snippet,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Snippet resource in storage.
     *
     * @route POST /resource/cms/snippets playground.cms.resource.snippets.post
     */
    public function store(
        Requests\Snippet\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        if ($user?->id) {
            $snippet->created_by_id = $user->id;
        }

        $snippet->save();

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['snippet' => $snippet->id]));
    }

    /**
     * Unlock the Snippet resource in storage.
     *
     * @route DELETE /resource/cms/snippets/lock/{snippet} playground.cms.resource.snippets.unlock
     */
    public function unlock(
        Snippet $snippet,
        Requests\Snippet\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Snippet {

        $validated = $request->validated();

        $user = $request->user();

        $snippet->locked = false;

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->save();

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['snippet' => $snippet->id]));
    }

    /**
     * Update the Snippet resource in storage.
     *
     * @route PATCH /resource/cms/snippets/{snippet} playground.cms.resource.snippets.patch
     */
    public function update(
        Snippet $snippet,
        Requests\Snippet\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Snippet {

        $this->saveRevision($snippet);

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $snippet->modified_by_id = $user->id;
        }

        $snippet->update($validated);

        if ($request->expectsJson()) {
            return (new Resources\Snippet($snippet))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route(sprintf(
            '%1$s.show',
            $this->packageInfo['model_route']
        ), ['snippet' => $snippet->id]));
    }
}
