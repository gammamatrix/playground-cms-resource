<?php
/**
 * Playground
 */
namespace Playground\Cms\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;
use Playground\Cms\Resource\Http\Requests\Snippet\CreateRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\DestroyRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\EditRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\IndexRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\LockRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\RestoreRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\RestoreRevisionRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\RevisionsRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\ShowRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\ShowRevisionRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\StoreRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\UnlockRequest;
use Playground\Cms\Resource\Http\Requests\Snippet\UpdateRequest;
use Playground\Cms\Resource\Http\Resources\Snippet as SnippetResource;
use Playground\Cms\Resource\Http\Resources\SnippetCollection;
use Playground\Cms\Resource\Http\Resources\SnippetRevision as SnippetRevisionResource;
use Playground\Cms\Resource\Http\Resources\SnippetRevisionCollection;

/**
 * \Playground\Cms\Resource\Http\Controllers\SnippetController
 */
class SnippetController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Snippet',
        'model_label_plural' => 'Snippets',
        'model_route' => 'playground.cms.resource.snippets',
        'model_slug' => 'snippet',
        'model_slug_plural' => 'snippets',
        'module_label' => 'CMS',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.cms.resource',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-resource:snippet',
        'table' => 'cms_snippets',
        'view' => 'playground-cms-resource::snippet',
    ];

    /**
     * CREATE the Snippet resource in storage.
     *
     * @route GET /resource/cms/snippets/create playground.cms.resource.snippets.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {

        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

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

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $snippet->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view($this->getViewPath('snippet', 'form'), $data);
    }

    /**
     * Edit the Snippet resource in storage.
     *
     * @route GET /resource/cms/snippets/snippets/edit playground.cms.resource.snippets.edit
     */
    public function edit(
        Snippet $snippet,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

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

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $snippet->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-cms-resource::snippet/form',
            $data
        );
    }

    /**
     * Remove the Snippet resource from storage.
     *
     * @route DELETE /resource/cms/snippets/{snippet} playground.cms.resource.snippets.destroy
     */
    public function destroy(
        Snippet $snippet,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

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

        return redirect(route('playground.cms.resource.snippets'));
    }

    /**
     * Lock the Snippet resource in storage.
     *
     * @route PUT /resource/cms/snippets/{snippet} playground.cms.resource.snippets.lock
     */
    public function lock(
        Snippet $snippet,
        LockRequest $request
    ): JsonResponse|RedirectResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet->setAttribute('locked', true);

        $snippet->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];
        // dump($request);

        if ($request->expectsJson()) {
            return (new SnippetResource($snippet))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.snippets.show', ['snippet' => $snippet->id]));
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /resource/cms/snippets playground.cms.resource.snippets
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|SnippetCollection {
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
        $paginator = $query->paginate( $perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new SnippetCollection($paginator))->response($request);
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

        return view(
            'playground-cms-resource::snippet/index',
            $data
        );
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /resource/cms/snippets/restore/{snippet} playground.cms.resource.snippets.restore
     */
    public function restore(
        Snippet $snippet,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet->restore();

        if ($request->expectsJson()) {
            return (new SnippetResource($snippet))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.snippets.show', ['snippet' => $snippet->id]));
    }

    /**
     * Restore the Snippet resource from the trash.
     *
     * @route PUT /resource/cms/snippets/revision/{snippet_revision} playground.cms.resource.snippets.revision.restore
     */
    public function restoreRevision(
        SnippetRevision $snippet_revision,
        RestoreRevisionRequest $request
    ): JsonResponse|RedirectResponse|SnippetResource {
        $validated = $request->validated();

        /**
         * @var Snippet $snippet
         */
        $snippet = Snippet::where(
            'id',
            $snippet_revision->getAttributeValue('snippet_id')
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
            return (new SnippetResource($snippet))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.snippets.show', ['snippet' => $snippet->id]));
    }

    /**
     * Display the Snippet revision.
     *
     * @route GET /resource/cms/snippets/revision/{snippet_revision} playground.cms.resource.snippets.revision
     */
    public function revision(
        SnippetRevision $snippet_revision,
        ShowRevisionRequest $request
    ): JsonResponse|View|SnippetRevisionResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new SnippetRevisionResource($snippet_revision))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $snippet_revision,
            'meta' => $meta,
        ];

        return view(
            'playground-cms-resource::snippet/revision',
            $data
        );
    }

    /**
     * Display a listing of Snippet resources.
     *
     * @route GET /resource/cms/snippets/{snippet}/revisions playground.cms.resource.snippets.revisions
     */
    public function revisions(
        Snippet $snippet,
        RevisionsRequest $request
    ): JsonResponse|View|SnippetRevisionCollection {
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
            return (new SnippetRevisionCollection($paginator))->response($request);
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

        return view(
            'playground-cms-resource::snippet/revisions',
            $data
        );
    }

    /**
     * Save a revision of a Snippet.
     */
    public function saveRevision(Snippet $snippet): SnippetRevision
    {
        $revision = new SnippetRevision($snippet->toArray());

        $revision->setAttribute('created_by_id', $snippet->getAttributeValue('created_by_id'));
        $revision->setAttribute('modified_by_id', $snippet->getAttributeValue('modified_by_id'));
        $revision->setAttribute('owned_by_id', $snippet->getAttributeValue('owned_by_id'));
        $revision->setAttribute('snippet_id', $snippet->getAttributeValue('id'));

        $r = SnippetRevision::where('snippet_id', $snippet->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->setAttribute('revision', $r);
        $snippet->setAttribute('revision', $r);

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
        ShowRequest $request
    ): JsonResponse|View|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $snippet->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new SnippetResource($snippet))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $snippet,
            'meta' => $meta,
        ];

        return view(
            'playground-cms-resource::snippet/detail',
            $data
        );
    }

    /**
     * Store a newly created API Snippet resource in storage.
     *
     * @route POST /resource/cms playground.cms.resource.snippets.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet = new Snippet($validated);

        $snippet->save();

        if ($request->expectsJson()) {
            return (new SnippetResource($snippet))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.snippets.show', ['snippet' => $snippet->id]));
    }

    /**
     * Unlock the Snippet resource in storage.
     *
     * @route DELETE /resource/cms/snippets/lock/{snippet} playground.cms.resource.snippets.unlock
     */
    public function unlock(
        Snippet $snippet,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $snippet->setAttribute('locked', false);

        $snippet->save();

        if ($request->expectsJson()) {
            return (new SnippetResource($snippet))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.snippets.show', ['snippet' => $snippet->id]));
    }

    /**
     * Update the Snippet resource in storage.
     *
     * @route PATCH /resource/cms/snippets/{snippet} playground.cms.resource.snippets.patch
     */
    public function update(
        Snippet $snippet,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|SnippetResource {
        $validated = $request->validated();

        $user = $request->user();

        $this->saveRevision($snippet);

        $snippet->update($validated);

        if ($request->expectsJson()) {
            return (new SnippetResource($snippet))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.snippets.show', ['snippet' => $snippet->id]));
    }
}
