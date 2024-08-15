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
use Playground\Cms\Models\Page;
use Playground\Cms\Models\PageRevision;
use Playground\Cms\Resource\Http\Requests;
use Playground\Cms\Resource\Http\Resources;

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
        'module_label_plural' => 'CMS',
        'module_route' => 'playground.cms.resource',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-resource:page',
        'table' => 'cms_pages',
        'view' => 'playground-cms-resource::page',
    ];

    /**
     * Create the Page resource in storage.
     *
     * @route GET /resource/cms/pages/create playground.cms.resource.pages.create
     */
    public function create(
        Requests\Page\CreateRequest $request
    ): JsonResponse|View|Resources\Page {

        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
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
            'data' => $page,
            'meta' => $meta,
            '_method' => 'post',
        ];

        $flash = $page->toArray();

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
     * Edit the Page resource in storage.
     *
     * @route GET /resource/cms/pages/edit/{page} playground.cms.resource.pages.edit
     */
    public function edit(
        Page $page,
        Requests\Page\EditRequest $request
    ): JsonResponse|View|Resources\Page {

        $validated = $request->validated();

        $user = $request->user();

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $flash = $page->toArray();

        if (! empty($validated['_return_url'])) {
            $flash['_return_url'] = $validated['_return_url'];
            $data['_return_url'] = $validated['_return_url'];
        }

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

        session()->flashInput($flash);

        return view(sprintf('%1$s/form', $this->packageInfo['view']), $data);
    }

    /**
     * Remove the Page resource from storage.
     *
     * @route DELETE /resource/cms/pages/{page} playground.cms.resource.pages.destroy
     */
    public function destroy(
        Page $page,
        Requests\Page\DestroyRequest $request
    ): Response|RedirectResponse {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

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

        return redirect(route($this->packageInfo['model_route']));
    }

    /**
     * Lock the Page resource in storage.
     *
     * @route PUT /resource/cms/pages/{page} playground.cms.resource.pages.lock
     */
    public function lock(
        Page $page,
        Requests\Page\LockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Page {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

        $page->locked = true;

        $page->save();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page->id,
            'timestamp' => Carbon::now()->toJson(),
            'info' => $this->packageInfo,
        ];

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
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
        ), ['page' => $page->id]));
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /resource/cms/pages playground.cms.resource.pages
     */
    public function index(
        Requests\Page\IndexRequest $request
    ): JsonResponse|View|Resources\PageCollection {

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
        $paginator = $query->paginate($perPage);

        $paginator->appends($validated);

        if ($request->expectsJson()) {
            return (new Resources\PageCollection($paginator))->response($request);
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
     * Restore the Page resource from the trash.
     *
     * @route PUT /resource/cms/pages/restore/{page} playground.cms.resource.pages.restore
     */
    public function restore(
        Page $page,
        Requests\Page\RestoreRequest $request
    ): JsonResponse|RedirectResponse|Resources\Page {

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

        $page->restore();

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
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
        ), ['page' => $page->id]));
    }

    /**
     * Restore the Page resource from the trash.
     *
     * @route PUT /resource/cms/pages/revision/{page_revision} playground.cms.resource.pages.revision.restore
     */
    public function restoreRevision(
        PageRevision $page_revision,
        Requests\Page\RestoreRevisionRequest $request
    ): JsonResponse|RedirectResponse|Resources\Page {
        $validated = $request->validated();

        /**
         * @var Page $page
         */
        $page = Page::where(
            'id',
            $page_revision->page_id
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
            return (new Resources\Page($page))->additional(['meta' => [
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
        ), ['page' => $page->id]));
    }

    /**
     * Display the Page revision.
     *
     * @route GET /resource/cms/pages/revision/{page_revision} playground.cms.resource.pages.revision
     */
    public function revision(
        PageRevision $page_revision,
        Requests\Page\ShowRevisionRequest $request
    ): JsonResponse|View|Resources\PageRevision {

        if ($request->expectsJson()) {
            return (new Resources\PageRevision($page_revision))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page_revision->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
            'input' => $request->input(),
        ];

        $data = [
            'data' => $page_revision,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/revision', $this->packageInfo['view']), $data);
    }

    /**
     * Display a listing of Page resources.
     *
     * @route GET /resource/cms/pages/{page}/revisions playground.cms.resource.pages.revisions
     */
    public function revisions(
        Page $page,
        Requests\Page\RevisionsRequest $request
    ): JsonResponse|View|Resources\PageRevisionCollection {
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
            return (new Resources\PageRevisionCollection($paginator))->additional(['meta' => [
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
     * Save a revision of a Page.
     */
    public function saveRevision(Page $page): PageRevision
    {
        $revision = new PageRevision($page->toArray());

        $revision->created_by_id = $page->created_by_id;
        $revision->modified_by_id = $page->modified_by_id;
        $revision->owned_by_id = $page->owned_by_id;
        $revision->page_id = $page->id;

        $r = PageRevision::where('page_id', $page->id)->max('revision');
        $r = ! is_numeric($r) || empty($r) || $r < 0 ? 0 : (int) $r;
        $r++;

        $revision->revision = $r;
        $page->revision = $r;

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
        Requests\Page\ShowRequest $request
    ): JsonResponse|View|Resources\Page {

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
                'info' => $this->packageInfo,
            ]])->response($request);
        }

        $validated = $request->validated();

        $user = $request->user();

        $meta = [
            'session_user_id' => $user?->id,
            'id' => $page->id,
            'timestamp' => Carbon::now()->toJson(),
            'validated' => $validated,
            'info' => $this->packageInfo,
            'input' => $request->input(),
        ];

        $data = [
            'data' => $page,
            'meta' => $meta,
        ];

        return view(sprintf('%1$s/detail', $this->packageInfo['view']), $data);
    }

    /**
     * Store a newly created API Page resource in storage.
     *
     * @route POST /resource/cms/pages playground.cms.resource.pages.post
     */
    public function store(
        Requests\Page\StoreRequest $request
    ): Response|JsonResponse|RedirectResponse|Resources\Page {

        $validated = $request->validated();

        $user = $request->user();

        $page = new Page($validated);

        if ($user?->id) {
            $page->created_by_id = $user->id;
        }

        $page->save();

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
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
        ), ['page' => $page->id]));
    }

    /**
     * Unlock the Page resource in storage.
     *
     * @route DELETE /resource/cms/pages/lock/{page} playground.cms.resource.pages.unlock
     */
    public function unlock(
        Page $page,
        Requests\Page\UnlockRequest $request
    ): JsonResponse|RedirectResponse|Resources\Page {

        $validated = $request->validated();

        $user = $request->user();

        $page->locked = false;

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

        $page->save();

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
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
        ), ['page' => $page->id]));
    }

    /**
     * Update the Page resource in storage.
     *
     * @route PATCH /resource/cms/pages/{page} playground.cms.resource.pages.patch
     */
    public function update(
        Page $page,
        Requests\Page\UpdateRequest $request
    ): JsonResponse|RedirectResponse|Resources\Page {

        $this->saveRevision($page);

        $validated = $request->validated();

        $user = $request->user();

        if ($user?->id) {
            $page->modified_by_id = $user->id;
        }

        $page->update($validated);

        if ($request->expectsJson()) {
            return (new Resources\Page($page))->additional(['meta' => [
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
        ), ['page' => $page->id]));
    }
}
