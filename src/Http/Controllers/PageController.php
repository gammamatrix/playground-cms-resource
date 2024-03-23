<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Cms\Resource\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\View\View;
use Playground\Cms\Models\Page;
use Playground\Cms\Models\PageRevision;
use Playground\Cms\Resource\Http\Requests\Page\CreateRequest;
use Playground\Cms\Resource\Http\Requests\Page\DestroyRequest;
use Playground\Cms\Resource\Http\Requests\Page\EditRequest;
use Playground\Cms\Resource\Http\Requests\Page\IndexRequest;
use Playground\Cms\Resource\Http\Requests\Page\LockRequest;
use Playground\Cms\Resource\Http\Requests\Page\RestoreRequest;
use Playground\Cms\Resource\Http\Requests\Page\RestoreRevisionRequest;
use Playground\Cms\Resource\Http\Requests\Page\RevisionsRequest;
use Playground\Cms\Resource\Http\Requests\Page\ShowRequest;
use Playground\Cms\Resource\Http\Requests\Page\ShowRevisionRequest;
use Playground\Cms\Resource\Http\Requests\Page\StoreRequest;
use Playground\Cms\Resource\Http\Requests\Page\UnlockRequest;
use Playground\Cms\Resource\Http\Requests\Page\UpdateRequest;
use Playground\Cms\Resource\Http\Resources\Page as PageResource;
use Playground\Cms\Resource\Http\Resources\PageCollection;
use Playground\Cms\Resource\Http\Resources\PageRevision as PageRevisionResource;
use Playground\Cms\Resource\Http\Resources\PageRevisionCollection;

/**
 * \Playground\Cms\Resource\Http\Controllers\PageController
 */
class PageController extends Controller
{
    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_label' => 'Page',
        'model_label_plural' => 'Pages',
        'model_route' => 'playground.cms.resource.pages',
        'model_slug' => 'page',
        'model_slug_plural' => 'pages',
        'module_label' => 'CMS',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.cms.resource',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-resource:page',
        'table' => 'cms_pages',
        'view' => 'playground-cms-resource::page',
    ];

    /**
     * CREATE the Page resource in storage.
     *
     * @route GET /resource/cms/pages/create playground.cms.resource.pages.create
     */
    public function create(
        CreateRequest $request
    ): JsonResponse|View {

        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

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
            'data' => $page,
            'meta' => $meta,
            '_method' => 'post',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $page->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        if (! $request->session()->has('errors')) {
            session()->flashInput($flash);
        }

        return view($this->getViewPath('page', 'form'), $data);
    }

    /**
     * Edit the Page resource in storage.
     *
     * @route GET /resource/cms/pages/pages/edit playground.cms.resource.pages.edit
     */
    public function edit(
        Page $page,
        EditRequest $request
    ): JsonResponse|View {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $page,
            'meta' => $meta,
            '_method' => 'patch',
        ];

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        $flash = $page->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

        session()->flashInput($flash);

        return view(
            'playground-cms-resource::page/form',
            $data
        );
    }

    /**
     * Remove the Page resource from storage.
     *
     * @route DELETE /resource/cms/pages/{page} playground.cms.resource.pages.destroy
     */
    public function destroy(
        Page $page,
        DestroyRequest $request
    ): Response|RedirectResponse {
        $validated = $request->validated();

        if (empty($validated['force'])) {
            $page->delete();
        } else {
            $page->forceDelete();
        }

        if ($request->expectsJson()) {
            return response()->noContent();
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages'));
    }

    /**
     * Lock the Page resource in storage.
     *
     * @route PUT /resource/cms/pages/{page} playground.cms.resource.pages.lock
     */
    public function lock(
        Page $page,
        LockRequest $request
    ): JsonResponse|RedirectResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page->setAttribute('locked', true);

        $page->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];
        // dump($request);

        if ($request->expectsJson()) {
            return (new PageResource($page))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages.show', ['page' => $page->id]));
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /resource/cms/pages playground.cms.resource.pages
     */
    public function index(
        IndexRequest $request
    ): JsonResponse|View|PageCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = Page::addSelect(sprintf('%1$s.*', $this->packageInfo['table']));

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
            return (new PageCollection($paginator))->response($request);
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
            'playground-cms-resource::page/index',
            $data
        );
    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /resource/cms/pages/restore/{page} playground.cms.resource.pages.restore
     */
    public function restore(
        Page $page,
        RestoreRequest $request
    ): JsonResponse|RedirectResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page->restore();

        if ($request->expectsJson()) {
            return (new PageResource($page))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages.show', ['page' => $page->id]));
    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /resource/cms/pages/revision/{page_revision} playground.cms.resource.pages.revision.restore
     */
    public function restoreRevision(
        PageRevision $page_revision,
        RestoreRevisionRequest $request
    ): JsonResponse|RedirectResponse|PageResource {
        $validated = $request->validated();

        /**
         * @var Page $page
         */
        $page = Page::where(
            'id',
            $page_revision->getAttributeValue('page_id')
        )->firstOrFail();

        $this->saveRevision($page);

        $user = $request->user();

        foreach ($page->getFillable() as $column) {
            $page->setAttribute(
                $column,
                $page_revision->getAttributeValue($column)
            );
        }

        $page->save();

        if ($request->expectsJson()) {
            return (new PageResource($page))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages.show', ['page' => $page->id]));
    }

    /**
     * Display the Page revision.
     *
     * @route GET /resource/cms/pages/revision/{page_revision} playground.cms.resource.pages.revision
     */
    public function revision(
        PageRevision $page_revision,
        ShowRevisionRequest $request
    ): JsonResponse|View|PageRevisionResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new PageRevisionResource($page_revision))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $page_revision,
            'meta' => $meta,
        ];

        return view(
            'playground-cms-resource::page/revision',
            $data
        );
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /resource/cms/pages/{page}/revisions playground.cms.resource.pages.revisions
     */
    public function revisions(
        Page $page,
        RevisionsRequest $request
    ): JsonResponse|View|PageRevisionCollection {
        $user = $request->user();

        $validated = $request->validated();

        $query = $page->revisions();

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
            return (new PageRevisionCollection($paginator))->response($request);
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
            'playground-cms-resource::page/revisions',
            $data
        );
    }

    /**
     * Save a revision of a Page.
     */
    public function saveRevision(Page $page): PageRevision
    {
        $revision = new PageRevision($page->toArray());

        $revision->setAttribute('created_by_id', $page->getAttributeValue('created_by_id'));
        $revision->setAttribute('modified_by_id', $page->getAttributeValue('modified_by_id'));
        $revision->setAttribute('owned_by_id', $page->getAttributeValue('owned_by_id'));
        $revision->setAttribute('page_id', $page->getAttributeValue('id'));

        $r = PageRevision::where('page_id', $page->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->setAttribute('revision', $r);
        $page->setAttribute('revision', $r);

        $revision->saveOrFail();

        return $revision;
    }

    /**
     * Display the Page resource.
     *
     * @route GET /resource/cms/pages/{page} playground.cms.resource.pages.show
     */
    public function show(
        Page $page,
        ShowRequest $request
    ): JsonResponse|View|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new PageResource($page))->response($request);
        }

        $meta['input'] = $request->input();
        $meta['validated'] = $request->validated();

        $data = [
            'data' => $page,
            'meta' => $meta,
        ];

        return view(
            'playground-cms-resource::page/detail',
            $data
        );
    }

    /**
     * Store a newly created API Page resource in storage.
     *
     * @route POST /resource/cms playground.cms.resource.pages.post
     */
    public function store(
        StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

        $page->created_by_id = $user?->id;

        $page->save();

        if ($request->expectsJson()) {
            return (new PageResource($page))
                ->response($request)
                ->setStatusCode(201);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages.show', ['page' => $page->id]));
    }

    /**
     * Unlock the Page resource in storage.
     *
     * @route DELETE /resource/cms/pages/lock/{page} playground.cms.resource.pages.unlock
     */
    public function unlock(
        Page $page,
        UnlockRequest $request
    ): JsonResponse|RedirectResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $page->setAttribute('locked', false);

        $page->save();

        if ($request->expectsJson()) {
            return (new PageResource($page))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages.show', ['page' => $page->id]));
    }

    /**
     * Update the Page resource in storage.
     *
     * @route PATCH /resource/cms/pages/{page} playground.cms.resource.pages.patch
     */
    public function update(
        Page $page,
        UpdateRequest $request
    ): JsonResponse|RedirectResponse|PageResource {
        $validated = $request->validated();

        $user = $request->user();

        $this->saveRevision($page);

        $page->modified_by_id = $user?->id;

        $page->update($validated);

        if ($request->expectsJson()) {
            return (new PageResource($page))->response($request);
        }

        $returnUrl = $validated['_return_url'] ?? '';

        if ($returnUrl && is_string($returnUrl)) {
            return redirect($returnUrl);
        }

        return redirect(route('playground.cms.resource.pages.show', ['page' => $page->id]));
    }
}
